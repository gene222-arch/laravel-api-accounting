<?php

namespace App\Jobs;

use App\Models\CRMCompany;
use Illuminate\Bus\Queueable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use App\Notifications\CRMCompanyNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Contracts\Queue\ShouldBeUnique;

class QueueCRMCompanyNotification implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public CRMCompany $company;
    public string $subject = '';
    public string $body = '';

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(CRMCompany $company, string $subject, string $body)
    {
        $this->company = $company;
        $this->subject = $subject;
        $this->body = $body;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $this->company->notify(
            new CRMCompanyNotification($this->company, $this->subject, $this->body)
        );
    }
}
