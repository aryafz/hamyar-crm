<?php

namespace App\Repositories;

use App\Models\Contact;
use Illuminate\Support\Collection;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class ContactRepository implements ContactRepositoryInterface
{
    public function all($search = null): LengthAwarePaginator
    {
        $query = Contact::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('first_name', 'like', "%{$search}%")
                    ->orWhere('last_name', 'like', "%{$search}%")
                    ->orWhere('mobile', 'like', "%{$search}%");
            });
        }

        // ordenBy یعنی جدیدترین‌ها اول باشن
        // paginate یعنی صفحه‌بندی کن (۱۰ تا ۱۰ تا)
        return $query->orderBy('id', 'desc')->paginate(10);
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
