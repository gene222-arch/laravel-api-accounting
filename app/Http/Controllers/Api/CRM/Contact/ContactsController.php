<?php

namespace App\Http\Controllers\Api\CRM\Contact;

use App\Models\Contact;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\CRM\Contact\DeleteContacteNoteRequest;
use App\Http\Requests\CRM\Contact\DeleteContactLogRequest;
use App\Http\Requests\CRM\Contact\DeleteContactScheduleRequest;
use App\Http\Requests\CRM\Contact\DeleteContactTaskRequest;
use App\Http\Requests\CRM\Contact\StoreRequest;
use App\Http\Requests\CRM\Contact\DeleteRequest;
use App\Http\Requests\CRM\Contact\MailContactRequest;
use App\Http\Requests\CRM\Contact\StoreContacteNoteRequest;
use App\Http\Requests\CRM\Contact\StoreContactLogRequest;
use App\Http\Requests\CRM\Contact\StoreContactScheduleRequest;
use App\Http\Requests\CRM\Contact\StoreContactTaskRequest;
use App\Http\Requests\CRM\Contact\UpdateContacteNoteRequest;
use App\Http\Requests\CRM\Contact\UpdateContactLogRequest;
use App\Http\Requests\CRM\Contact\UpdateContactScheduleRequest;
use App\Http\Requests\CRM\Contact\UpdateContactTaskRequest;
use App\Http\Requests\CRM\Contact\UpdateRequest;
use App\Jobs\QueueContactNotification;

class ContactsController extends Controller
{
    use ApiResponser;

    private Contact $contact;
    
    public function __construct(Contact $contact)
    {
        $this->contact = $contact;
        $this->middleware(['auth:api', 'permission:Manage Contacts']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function index()
    {
        $result = $this->contact
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
        $contact = $this->contact->create($request->validated());

        return $this->success($contact, 'Contact created successfully.');
    }

    /**
     * Store a newly created resource contact_notes.
     *
     * @param StoreContacteNoteRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeNote(StoreContacteNoteRequest $request, Contact $contact)
    {
        $contact->logs()->create($request->validated());

        return $this->success();
    }

    /**
     * Store a newly created resource contact_logs.
     *
     * @param StoreContactLogRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeLog(StoreContactLogRequest $request, Contact $contact)
    {
        $contact->logs()->create($request->validated());

        return $this->success();
    }
    
    /**
     * Store a newly created resource contact_schedules.
     *
     * @param StoreContactScheduleRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeSchedule(StoreContactScheduleRequest $request, Contact $contact)
    {
        $contact->schedules()->create($request->validated());

        return $this->success();
    }

    /**
     * Store a newly created resource contact_tasks.
     *
     * @param StoreContactTaskRequest $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function storeTask(StoreContactTaskRequest $request, Contact $contact)
    {
        $contact->tasks()->create($request->validated());

        return $this->success();
    }

    /**
     * Send mail
     *
     * @param  MailContactRequest $request
     * @param  Contact $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function mailContact(MailContactRequest $request, Contact $contact)
    {
        dispatch(new QueueContactNotification(
            $contact, 
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
    public function show(Contact $contact)
    {
        return !$contact
            ? $this->noContent()
            : $this->success($contact);
    }

    /**
     * Display a listing of the resource contact_notes.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showNotes(Contact $contact)
    {
        $result = $contact->with('notes')->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Display a listing of the resource contact_logs.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showLogs(Contact $contact)
    {
        $result = $contact->with('logs')->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Display a listing of the resource contact_schedules.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showSchedules(Contact $contact)
    {
        $result = $contact->with('schedules')->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Display a listing of the resource contact_tasks.
     *
     * @return \Illuminate\Http\JsonResponse
     */
    public function showTasks(Contact $contact)
    {
        $result = $contact->with('tasks')->get();

        return !$result->count()
            ? $this->noContent()
            : $this->success($result);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(UpdateRequest $request, Contact $contact)
    {   
        $contact->update($request->validated());

        return $this->success(null, 'Contact updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContacteNoteRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateNote(UpdateContacteNoteRequest $request, Contact $contact)
    {   
        $contact->notes()
            ->find($request->note_id)
            ->update($request->validated());

        return $this->success(null, 'Note updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContactLogRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateLog(UpdateContactLogRequest $request, Contact $contact)
    {   
        $contact->logs()
            ->find($request->log_id)
            ->update($request->validated());

        return $this->success(null, 'Log updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContactScheduleRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateSchedule(UpdateContactScheduleRequest $request, Contact $contact)
    {   
        $contact->schedules()
            ->find($request->schedule_id)
            ->update($request->validated());

        return $this->success(null, 'Schedule updated successfully.');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateContactTaskRequest $request
     * @param Contact $contact
     * @return \Illuminate\Http\JsonResponse
     */
    public function updateTask(UpdateContactTaskRequest $request, Contact $contact)
    {   
        $contact->tasks()
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
        $this->contact->whereIn('id', $request->ids)->delete();

        return $this->success(null, 'Contact or contacts deleted successfully.');
    }

    /**
     * Remove the specified resource from storage contact_notes.
     *
     * @param  DeleteContacteNoteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyNotes(DeleteContacteNoteRequest $request, Contact $contact)
    {
        $contact->notes()->whereIn('id', $request->note_ids)->delete();

        return $this->success(null, 'Notes deleted successfully.');
    }

    /**
     * Remove the specified resource from storage contact_notes.
     *
     * @param  DeleteContacteNoteRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyLogs(DeleteContactLogRequest $request, Contact $contact)
    {
        $contact->logs()->whereIn('id', $request->log_ids)->delete();

        return $this->success(null, 'Logs deleted successfully.');
    }

    /**
     * Remove the specified resource from storage contact_schedules.
     *
     * @param  DeleteContactScheduleRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroySchedules(DeleteContactScheduleRequest $request, Contact $contact)
    {
        $contact->schedules()->whereIn('id', $request->schedule_ids)->delete();

        return $this->success(null, 'Schedules deleted successfully.');
    }

    /**
     * Remove the specified resource from storage contact_tasks.
     *
     * @param  DeleteContactTaskRequest  $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroyTasks(DeleteContactTaskRequest $request, Contact $contact)
    {
        $contact->tasks()->whereIn('id', $request->task_ids)->delete();

        return $this->success(null, 'Tasks deleted successfully.');
    }
}
