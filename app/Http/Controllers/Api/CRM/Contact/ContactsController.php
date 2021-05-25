<?php

namespace App\Http\Controllers\Api\CRM\Contact;

use App\Models\Contact;
use App\Traits\Api\ApiResponser;
use App\Http\Controllers\Controller;
use App\Http\Requests\CRM\Contact\StoreRequest;
use App\Http\Requests\CRM\Contact\DeleteRequest;
use App\Http\Requests\CRM\Contact\UpdateRequest;

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
        $result = $this->contact->all();

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
}
