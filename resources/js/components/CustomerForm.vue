<template>
    <form @submit.prevent="submit" class="space-y-4 text-right" dir="rtl">
        <div class="grid grid-cols-2 gap-4">
            <input v-model="form.first_name" type="text" placeholder="نام" class="border p-2 rounded w-full" required />
            <input v-model="form.last_name" type="text" placeholder="نام خانوادگی" class="border p-2 rounded w-full" required />
        </div>

        <div class="grid grid-cols-2 gap-4">
            <input v-model="form.company" type="text" placeholder="نام شرکت / سازمان" class="border p-2 rounded w-full" />
            <input v-model="form.job_title" type="text" placeholder="سمت شغلی" class="border p-2 rounded w-full" />
        </div>

        <input v-model="form.mobile" type="text" placeholder="شماره موبایل" class="border p-2 rounded w-full" required />
        <input v-model="form.email" type="email" placeholder="ایمیل" class="border p-2 rounded w-full" />

        <div class="grid grid-cols-2 gap-4">
            <input v-model="form.province" type="text" placeholder="استان" class="border p-2 rounded w-full" />
            <input v-model="form.city" type="text" placeholder="شهر" class="border p-2 rounded w-full" />
        </div>

        <select v-model="form.type" class="border p-2 rounded w-full">
            <option value="lead">سرنخ (Lead)</option>
            <option value="customer">مشتری فعلی</option>
            <option value="vip">مشتری ویژه (VIP)</option>
        </select>

        <button type="submit" class="w-full bg-blue-600 text-white py-2 rounded font-bold hover:bg-blue-700">
            + ثبت و ایجاد پرونده
        </button>
    </form>
</template>

<script setup>
import { useForm } from '@inertiajs/vue3';

const form = useForm({
    first_name: '', last_name: '', company: '', job_title: '',
    mobile: '', email: '', province: '', city: '', type: 'lead'
});

const submit = () => {
    form.post(route('contacts.store'), {
        onSuccess: () => {
            form.reset();
            alert('مشتری با موفقیت ثبت شد');
        }
    });
};
</script>
