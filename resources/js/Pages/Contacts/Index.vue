<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/vue3';
import CustomerList from '@/components/CustomerList.vue';
import CustomerForm from '@/components/CustomerForm.vue';

// دریافت دیتای مشتریان که از سمت لاراول فرستاده شده
defineProps({ contacts: Object });
</script>

<template>
    <Head title="مدیریت مشتریان" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">
                مدیریت مشتریان 👥
            </h2>
        </template>

        <div class="py-12">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-6">
                <!-- ستون فرم -->
                <div class="lg:col-span-1 bg-white p-6 shadow rounded-lg">
                    <h3 class="font-bold mb-4">ثبت مشتری جدید</h3>
                    <CustomerForm />
                </div>

                <!-- ستون لیست -->
                <div class="lg:col-span-2 bg-white p-6 shadow rounded-lg">
                    <h3 class="font-bold mb-4">لیست کل مشتریان</h3>
                    <CustomerList />
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
