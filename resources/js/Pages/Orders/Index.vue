<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, useForm } from '@inertiajs/vue3';

const props = defineProps({ orders: Object });

// تابع کمکی برای فرمت پول
const formatPrice = (n) => new Intl.NumberFormat('fa-IR').format(n) + ' تومان';

// تابع تغییر وضعیت سریع
const updateStatus = (order, newStatus) => {
    const form = useForm({ status: newStatus });
    form.patch(route('orders.update', order.id), { preserveScroll: true });
};
</script>

<template>
    <Head title="مدیریت سفارشات" />

    <AuthenticatedLayout>
        <template #header>
            <h2 class="font-semibold text-xl text-gray-800 leading-tight text-right">مدیریت کل سفارشات 💰</h2>
        </template>

        <div class="py-12" dir="rtl">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6 font-vazir">
                    <table class="w-full text-right border-collapse">
                        <thead>
                        <tr class="bg-gray-50 border-b">
                            <th class="p-4">شناسه</th>
                            <th class="p-4">مشتری</th>
                            <th class="p-4">نوع</th>
                            <th class="p-4">مبلغ</th>
                            <th class="p-4">وضعیت</th>
                            <th class="p-4">عملیات</th>
                        </tr>
                        </thead>
                        <tbody>
                        <tr v-for="order in orders.data" :key="order.id" class="border-b hover:bg-gray-50 transition">
                            <td class="p-4 text-gray-500 text-sm">#{{ order.id }}</td>
                            <td class="p-4 font-bold text-blue-600">
                                {{ order.contact.first_name }} {{ order.contact.last_name }}
                            </td>
                            <td class="p-4">{{ order.type }}</td>
                            <td class="p-4 font-mono">{{ formatPrice(order.amount) }}</td>
                            <td class="p-4">
                                <select
                                    @change="updateStatus(order, $event.target.value)"
                                    :value="order.status"
                                    class="text-xs rounded border-gray-300 py-1"
                                >
                                    <option value="new">جدید</option>
                                    <option value="pending">در جریان</option>
                                    <option value="completed">تکمیل شده</option>
                                    <option value="canceled">لغو شده</option>
                                </select>
                            </td>
                            <td class="p-4">
                                <Link :href="route('contacts.show', order.contact_id)" class="text-xs text-gray-400 hover:text-blue-600">مشاهده پرونده</Link>
                            </td>
                        </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </AuthenticatedLayout>
</template>
