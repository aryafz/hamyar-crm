<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\Request;
use App\Http\Resources\ContactResource;

class ContactController extends Controller
{
    public function __construct(private ContactService $service)
    {
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return ContactResource::collection($this->service->list());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string',
            'last_name' => 'required|string',
            'email' => 'nullable|email',
            'mobile' => 'required|string|unique:contacts',
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $contact = $this->service->create($data);
        return new ContactResource($contact);
    }

    /**
     * Display the specified resource.
     */
    public function show(Contact $contact)
    {
        return new ContactResource($contact);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Contact $contact)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Contact $contact)
    {
        $data = $request->validate([
            'first_name' => 'sometimes|string',
            'last_name' => 'sometimes|string',
            'email' => 'nullable|email',
            'mobile' => 'sometimes|string|unique:contacts,mobile,'.$contact->id,
            'address' => 'nullable|string',
            'notes' => 'nullable|string',
        ]);

        $contact = $this->service->update($contact, $data);

        return new ContactResource($contact);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Contact $contact)
    {
        $this->service->delete($contact);
        return response()->noContent();
    }
}
