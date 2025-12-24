<?php

namespace App\Services;

use App\Models\Contact;
use App\Repositories\ContactRepositoryInterface;
use Illuminate\Support\Collection;

class ContactService
{
    public function __construct(private ContactRepositoryInterface $contacts)
    {
    }

    public function list($search = null)
    {
        return $this->contacts->all($search);
    }

    public function create(array $data): Contact
    {
        return $this->contacts->create($data);
    }

    public function update(Contact $contact, array $data): Contact
    {
        return $this->contacts->update($contact, $data);
    }

    public function delete(Contact $contact): void
    {
        $this->contacts->delete($contact);
    }
}
