<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, usePage } from '@inertiajs/vue3'; // اضافه کردن usePage
import CrmDashboard from '@/components/Dashboard.vue';
import CustomerForm from '@/components/CustomerForm.vue';
import CustomerList from '@/components/CustomerList.vue';
import { computed } from 'vue';


const page = usePage();

const props = defineProps({
    stats: Object,
    chartData: Array
});

const user = computed(() => page.props.auth.user);
const farsiNumber = (n) => new Intl.NumberFormat('fa-IR').format(n);
const today = new Intl.DateTimeFormat('fa-IR', { dateStyle: 'full' }).format(new Date());
</script>

<template>
    <Head title="داشبورد مدیریت" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center">
                <span class="text-sm text-gray-500">{{ today }}</span>
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                    سلام {{ user.name }}، خوش آمدی! 👋
                </h2>
            </div>
        </template>

        <div class="py-12 bg-gray-50 min-h-screen">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-8">

                <div class="grid grid-cols-1 md:grid-cols-4 gap-4">

                    <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-blue-500">
                        <p class="text-sm text-gray-500">کل مشتریان</p>
                        <p class="text-2xl font-bold">{{ farsiNumber(stats.total_contacts) }} نفر</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-green-500">
                        <p class="text-sm text-gray-500">سفارشات فعال</p>
                        <p class="text-2xl font-bold">{{ farsiNumber(stats.active_orders) }} مورد</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-yellow-500">
                        <p class="text-sm text-gray-500">پروژه‌های در جریان</p>
                        <p class="text-2xl font-bold">{{ farsiNumber(stats.pending_projects) }} پروژه</p>
                    </div>

                    <div class="bg-white p-6 rounded-xl shadow-sm border-r-4 border-red-500">
                        <p class="text-sm text-gray-500">تسک‌های امروز</p>
                        <p class="text-2xl font-bold text-red-600">{{ farsiNumber(stats.today_tasks) }} تسک</p>
                    </div>

                </div>

                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6">
                    <CrmDashboard :orders="chartData" />
                </div>

                <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                    <div class="lg:col-span-1 bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-right">ثبت مشتری</h3>
                        <CustomerForm />
                    </div>
                    <div class="lg:col-span-2 bg-white shadow-sm sm:rounded-lg p-6">
                        <h3 class="text-lg font-bold mb-4 border-b pb-2 text-right">لیست مشتریان</h3>
                        <CustomerList />
                    </div>
                </div>

            </div>
        </div>
    </AuthenticatedLayout>
</template>
