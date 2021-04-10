<?php

namespace App\Traits\Sales\Invoice;

use App\Jobs\QueueEstimateInvoiceNotification;
use App\Models\Customer;
use App\Models\EstimateInvoice;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Collection;

trait EstimateInvoicesServices
{
    
    /**
     * Get latest records of estimate invoices
     *
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public function getAllEstimateInvoices (): Collection
    {
        return EstimateInvoice::with('paymentDetail')
            ->latest()
            ->get();
    }
    
    /**
     * Get a record of estimate invoice via id
     *
     * @param  int $id
     * @return EstimateInvoice|null
     */
    public function getEstimateInvoiceById (int $id): EstimateInvoice|null
    {
        return EstimateInvoice::find($id)
            ->with([
                'items' => fn($q) => $q->select('name'),
                'paymentDetail'
            ])
            ->first();
    }
        

    /**
     * Create a new record of estimated invoice
     *
     * @param  integer $customerId
     * @param  string $estimateNumber
     * @param  string $estimatedAt
     * @param  string $expiredAt
     * @param  bool $enableReminder
     * @param  array $items
     * @param  array $paymentDetail
     * @return mixed
     */
    public function createEstimateInvoice (int $customerId, string $estimateNumber, string $estimatedAt, string $expiredAt, bool $enableReminder, array $items, array $paymentDetail): mixed
    {
        try {
            DB::transaction(function () use ($customerId, $estimateNumber, $estimatedAt, $expiredAt, $enableReminder, $items, $paymentDetail)
            {
                $estimateInvoice = EstimateInvoice::create([
                    'customer_id' => $customerId,
                    'estimate_number' => $estimateNumber,
                    'estimated_at' => $estimatedAt,
                    'expired_at' => $expiredAt,
                    'enable_reminder' => $enableReminder
                ]);

                $estimateInvoice->items()->attach($items);

                $estimateInvoice->paymentDetail()->create($paymentDetail);

                $estimateInvoice->histories()->create([
                    'description' => "${estimateNumber} added!"
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        return true;
    }

    public function mail(EstimateInvoice $estimateInvoice, Customer $customer, ?string $subject, ?string $greeting, ?string $note, ?string $footer): mixed
    {
        try {
            DB::transaction(function () use ($estimateInvoice, $customer, $subject, $greeting, $note, $footer)
            {
                $isCreated = $estimateInvoice->histories()
                    ->create([
                        'status' => 'Mailed',
                        'description' => "Invoice marked as sent!"
                    ]);

                if ($isCreated)
                {
                    dispatch(new QueueEstimateInvoiceNotification(
                        $estimateInvoice, 
                        $customer, 
                        $subject, 
                        $greeting, 
                        $note, 
                        $footer
                    ))
                    ->delay(now()->addSeconds(5));
                }
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Mark an estimated invoice as approve
     *
     * @param  EstimateInvoice $estimateInvoice
     * @return mixed
     */
    public function markAsApproved(EstimateInvoice $estimateInvoice): mixed
    {
        try {
            DB::transaction(function () use ($estimateInvoice)
            {
                $estimateInvoice->histories()->create([
                    'status' => 'Approved',
                    'description' => "{$estimateInvoice->estimate_number} marked as approved!"
                ]);

                $estimateInvoice->update([
                    'status' => 'Approved'
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }

    /**
     * Mark an estimated invoice as refused
     *
     * @param  EstimateInvoice $estimateInvoice
     * @return mixed
     */
    public function markAsRefused(EstimateInvoice $estimateInvoice): mixed
    {
        try {
            DB::transaction(function () use ($estimateInvoice)
            {
                $estimateInvoice->histories()->create([
                    'status' => 'Refused',
                    'description' => "{$estimateInvoice->estimate_number} marked as refused!"
                ]);

                $estimateInvoice->update([
                    'status' => 'Refused'
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }
        
        return true;
    }
    
    /**
     * Update an existing record of estimated invoice
     *
     * @param  integer $id
     * @param  integer $customerId
     * @param  string $estimateNumber
     * @param  string $estimatedAt
     * @param  string $expiredAt
     * @param  bool $enableReminder
     * @param  array $items
     * @param  array $paymentDetail
     * @return mixed
     */
    public function updateEstimateInvoice (int $id, int $customerId, string $estimateNumber, string $estimatedAt, string $expiredAt, bool $enableReminder, array $items, array $paymentDetail): mixed
    {
        try {
            DB::transaction(function () use ($id, $customerId, $estimateNumber, $estimatedAt, $expiredAt, $enableReminder, $items, $paymentDetail)
            {
                $estimateInvoice = EstimateInvoice::find($id);

                $estimateInvoice->update([
                    'customer_id' => $customerId,
                    'estimate_number' => $estimateNumber,
                    'estimated_at' => $estimatedAt,
                    'expired_at' => $expiredAt,
                    'enable_reminder' => $enableReminder
                ]);

                $estimateInvoice->items()->sync($items);

                $estimateInvoice->paymentDetail()->update($paymentDetail);

                $estimateInvoice->histories()->create([
                    'status' => DB::raw('status'),
                    'description' => "${estimateNumber} updated!"
                ]);
            });
        } catch (\Throwable $th) {
            return $th->getMessage();
        }

        return true;
    }

    /**
     * Delete one or multiple records of estimated invoices
     *
     * @param  array $ids
     * @return boolean
     */
    public function deleteEstimateInvoices (array $ids): bool
    {
        return EstimateInvoice::whereIn('id', $ids)->delete();
    }

}