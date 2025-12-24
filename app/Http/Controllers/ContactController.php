<?php

namespace App\Http\Controllers;

use App\Models\Contact;
use App\Services\ContactService;
use Illuminate\Http\Request;
use App\Http\Resources\ContactResource;
use Inertia\Inertia;

class ContactController extends Controller
{
    public function __construct(private ContactService $service)
    {
        // تزریق وابستگی سرویس برای رعایت اصول معماری
    }

    /**
     * نمایش لیست مشتریان (برای پاسخ به جستجوی Axios در فرانت)
     */
    public function index(Request $request)
    {
        $search = $request->get('search');

        // چون این متد توسط Axios صدا زده می‌شود، همچنان Resource برمی‌گردانیم
        return ContactResource::collection($this->service->list($search));
    }

    /**
     * ذخیره مشتری جدید (ارسال شده توسط Inertia Form)
     */
    public function store(Request $request)
    {
        // ۱. اعتبارسنجی دقیق تمام فیلدها
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'mobile'     => 'required|string|unique:contacts,mobile',
            'email'      => 'nullable|email',
            'company'    => 'nullable|string|max:255',
            'job_title'  => 'nullable|string|max:255',
            'province'   => 'nullable|string|max:255',
            'city'       => 'nullable|string|max:255',
            'address'    => 'nullable|string',
            'type'       => 'nullable|string',
        ]);

        // ۲. ایجاد مشتری از طریق سرویس
        $this->service->create($data);

        // ۳. بسیار مهم: Inertia نیاز به ریدایرکت دارد تا صفحه را رفرش کند
        return redirect()->route('contacts.index')->with('success', 'مشتری با موفقیت ثبت شد.');
    }

    /**
     * نمایش پروفایل یک مشتری خاص
     */
    public function show(Contact $contact)
    {
        // لود کردن روابط برای جلوگیری از مشکل N+1
        $contact->load(['orders', 'interactions']);

        return Inertia::render('Contacts/Show', [
            'contact' => $contact
        ]);
    }

    /**
     * ذخیره یک فعالیت یا تعامل جدید در تایم‌لاین مشتری
     */
    public function storeInteraction(Request $request, Contact $contact)
    {
        // اصلاح اعتبارسنجی: اینجا باید فیلدهای Interaction چک شوند نه Contact!
        $data = $request->validate([
            'type'    => 'required|string', // تماس، یادداشت و...
            'content' => 'required|string', // متن گزارش
        ]);

        // ثبت در دیتابیس از طریق رابطه
        $contact->interactions()->create($data);

        return back()->with('success', 'فعالیت با موفقیت در پرونده ثبت شد.');
    }

    /**
     * بروزرسانی اطلاعات مشتری (Inline Edit در پروفایل)
     */
    public function update(Request $request, Contact $contact)
    {
        // ۱. اعتبارسنجی فیلدها (با رعایت یکتایی موبایل برای همین آیدی)
        $data = $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name'  => 'required|string|max:255',
            'mobile'     => 'required|string|unique:contacts,mobile,' . $contact->id,
            'email'      => 'nullable|email',
            'company'    => 'nullable|string|max:255',
            'job_title'  => 'nullable|string|max:255',
            'province'   => 'nullable|string|max:255',
            'city'       => 'nullable|string|max:255',
            'address'    => 'nullable|string',
            'type'       => 'nullable|string',
            'notes'      => 'nullable|string',
        ]);

        // ۲. آپدیت دیتابیس
        $this->service->update($contact, $data);

        // ۳. بازگشت به صفحه قبل برای آپدیت شدن آنی Vue
        return back()->with('success', 'اطلاعات مشتری بروزرسانی شد.');
    }

    /**
     * حذف مشتری
     */
    public function destroy(Contact $contact)
    {
        $this->service->delete($contact);

        return redirect()->route('contacts.index')->with('success', 'مشتری از سیستم حذف شد.');
    }
}
