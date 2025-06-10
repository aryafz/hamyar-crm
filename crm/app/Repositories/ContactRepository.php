<?php

namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Support\Collection;

class ContactRepository implements ContactRepositoryInterface
{
    public function all(): Collection
    {
        return Contact::all();
    }

    public function create(array $data): Contact
    {
        return Contact::create($data);
    }

    public function update(Contact $contact, array $data): Contact
    {
        $contact->update($data);
        return $contact;
    }

    public function delete(Contact $contact): void
    {
        $contact->delete();
    }
}
