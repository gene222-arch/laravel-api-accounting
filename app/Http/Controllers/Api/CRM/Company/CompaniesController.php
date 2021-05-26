<?php

namespace App\Http\Controllers\Api\CRM\Company;

use App\Models\CRMCompany;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Jobs\QueueCRMCompanyNotification;
use App\Http\Requests\CRM\Company\StoreRequest;
use App\Http\Requests\CRM\Company\DeleteRequest;
use App\Http\Requests\CRM\Company\UpdateRequest;
use App\Http\Requests\CRM\Company\MailCompanyRequest;
use App\Http\Requests\CRM\Company\StoreCompanyLogRequest;
use App\Http\Requests\CRM\Company\DeleteCompanyLogRequest;
use App\Http\Requests\CRM\Company\StoreCompanyNoteRequest;
use App\Http\Requests\CRM\Company\StoreCompanyTaskRequest;
use App\Http\Requests\CRM\Company\UpdateCompanyLogRequest;
use App\Http\Requests\CRM\Company\DeleteCompanyNoteRequest;
use App\Http\Requests\CRM\Company\DeleteCompanyTaskRequest;
use App\Http\Requests\CRM\Company\UpdateCompanyNoteRequest;
use App\Http\Requests\CRM\Company\UpdateCompanyTaskRequest;
use App\Http\Requests\CRM\Company\StoreCompanyScheduleRequest;
use App\Http\Requests\CRM\Company\DeleteCompanyScheduleRequest;
use App\Http\Requests\CRM\Company\UpdateCompanyScheduleRequest;

class CompaniesController extends Controller
{
    use ApiResponser;

    private CRMCompany $company;
    
    public function __construct(CRMCompany $company)
    {
        $this->company = $company;
        $this->middleware(['auth:api', 'permission:Manage CRM Companies']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->company
            ->select([ 'name', 'email', 'phone', 'stage', 'owner', 'created_at', 'enabled' ])
            ->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(StoreRequest $request)
    {
        $company = $this->company->create($request->validated());

        return $this->success($company, 'Company created successfully.');
    }

    /**
     * Store a newly created resource contact_notes.
     *
     * @param StoreCompanyNoteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeNote(StoreCompanyNoteRequest $request, CRMCompany $company)
    {
        $company->logs()->create($request->validated());

        return $this->success();
    }

    /**
     * Store a newly created resource contact_logs.
     *
     * @param StoreCompanyLogRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeLog(StoreCompanyLogRequest $request, CRMCompany $company)
    {
        $company->logs()->create($request->validated());

        return $this->success();
    }
    
    /**
     * Store a newly created resource contact_schedules.
     *
     * @param StoreCompanyScheduleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSchedule(StoreCompanyScheduleRequest $request, CRMCompany $company)
    {
        $company->schedules()->create($request->validated());

        return $this->success();
    }

    /**
     * Store a newly created resource contact_tasks.
     *
     * @param StoreCompanyTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTask(StoreCompanyTaskRequest $request, CRMCompany $company)
    {
        $company->tasks()->create($request->validated());

        return $this->success();
    }

    /**
     * Send mail
     *
     * @param  MailCompanyRequest $request
     * @param  CRMCompany $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function mailCompany(MailCompanyRequest $request, CRMCompany $company)
    {
        dispatch(new QueueCRMCompanyNotification(
            $company, 
            $request->subject, 
            $request->body
        ))->delay(now()->addSeconds(10));

        return $this->success('Mail sent');
    }

    /**
     * Display the specified resource.
     *
     * @param integer $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show(CRMCompany $company)
    {
        return !$company
            ? $this->noContent()
            : $this->success($company);
    }

    /**
     * Display a listing of the resource contact_notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showNotes(CRMCompany $company)
    {
        $result = $company->with('notes')->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Display a listing of the resource contact_logs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showLogs(CRMCompany $company)
    {
        $result = $company->with('logs')->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Display a listing of the resource contact_schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showSchedules(CRMCompany $company)
    {
        $result = $company->with('schedules')->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Display a listing of the resource contact_tasks.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showTasks(CRMCompany $company)
    {
        $result = $company->with('tasks')->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param CRMCompany $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, CRMCompany $company)
    {   
        $company->update($request->validated());

        return $this->success(null, 'Company updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyNoteRequest $request
     * @param CRMCompany $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNote(UpdateCompanyNoteRequest $request, CRMCompany $company)
    {   
        $company->notes()
            ->find($request->note_id)
            ->update($request->validated());

        return $this->success(null, 'Note updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyLogRequest $request
     * @param CRMCompany $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLog(UpdateCompanyLogRequest $request, CRMCompany $company)
    {   
        $company->logs()
            ->find($request->log_id)
            ->update($request->validated());

        return $this->success(null, 'Log updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyScheduleRequest $request
     * @param CRMCompany $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSchedule(UpdateCompanyScheduleRequest $request, CRMCompany $company)
    {   
        $company->schedules()
            ->find($request->schedule_id)
            ->update($request->validated());

        return $this->success(null, 'Schedule updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCompanyTaskRequest $request
     * @param CRMCompany $company
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTask(UpdateCompanyTaskRequest $request, CRMCompany $company)
    {   
        $company->tasks()
            ->find($request->task_id)
            ->update($request->validated());

        return $this->success(null, 'Tasks updated successfully.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  DeleteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy(DeleteRequest $request)
    {
        $this->company->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Company or contacts deleted successfully.');
    }

    /**
     * Remove the specified resource from storage contact_notes.
     *
     * @param  DeleteCompanyNoteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyNotes(DeleteCompanyNoteRequest $request, CRMCompany $company)
    {
        $company->notes()->whereIn('id', $request->note_ids)->delete();

        return $this->success(null, 'Notes deleted successfully.');
    }

    /**
     * Remove the specified resource from storage contact_notes.
     *
     * @param  DeleteCompanyNoteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyLogs(DeleteCompanyLogRequest $request, CRMCompany $company)
    {
        $company->logs()->whereIn('id', $request->log_ids)->delete();

        return $this->success(null, 'Logs deleted successfully.');
    }

    /**
     * Remove the specified resource from storage contact_schedules.
     *
     * @param  DeleteCompanyScheduleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroySchedules(DeleteCompanyScheduleRequest $request, CRMCompany $company)
    {
        $company->schedules()->whereIn('id', $request->schedule_ids)->delete();

        return $this->success(null, 'Schedules deleted successfully.');
    }

    /**
     * Remove the specified resource from storage contact_tasks.
     *
     * @param  DeleteCompanyTaskRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyTasks(DeleteCompanyTaskRequest $request, CRMCompany $company)
    {
        $company->tasks()->whereIn('id', $request->task_ids)->delete();

        return $this->success(null, 'Tasks deleted successfully.');
    }
}
