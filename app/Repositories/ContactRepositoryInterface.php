<?php

namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Support\Collection;

interface ContactRepositoryInterface
{
    public function all($search = null);

    public function create(array $data): Contact;

    public function update(Contact $contact, array $data): Contact;

    public function delete(Contact $contact): void;
}
