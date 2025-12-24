<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import { ref } from 'vue';

// دریافت اطلاعات از لاراول
const props = defineProps({ contact: Object });

// وضعیت‌های محلی برای کنترل UI
const isEditing = ref(false);
const isModalOpen = ref(false);

// ۱. فرم ویرایش اطلاعات شناسنامه‌ای مشتری
const editForm = useForm({
    first_name: props.contact.first_name,
    last_name: props.contact.last_name,
    company: props.contact.company || '',
    job_title: props.contact.job_title || '',
    mobile: props.contact.mobile,
    email: props.contact.email || '',
    website: props.contact.website || '',
    province: props.contact.province || '',
    city: props.contact.city || '',
    address: props.contact.address || '',
    type: props.contact.type || 'lead',
});

// ۲. فرم ثبت سفارش جدید
const orderForm = useForm({
    contact_id: props.contact.id,
    type: 'سرویس',
    amount: 0,
    deposit: 0,
    status: 'new'
});

// ۳. فرم ثبت فعالیت جدید در تایم‌لاین
const interactionForm = useForm({
    type: 'یادداشت',
    content: ''
});

/** توابع اجرایی **/
const updateContact = () => {
    editForm.patch(route('contacts.update', props.contact.id), {
        onSuccess: () => isEditing.value = false,
        preserveScroll: true
    });
};

const submitOrder = () => {
    orderForm.post(route('orders.store'), {
        onSuccess: () => {
            isModalOpen.value = false;
            orderForm.reset('amount', 'deposit');
        },
        preserveScroll: true
    });
};

const submitInteraction = () => {
    if (!interactionForm.content) return;
    interactionForm.post(route('contacts.interactions.store', props.contact.id), {
        onSuccess: () => interactionForm.reset(),
        preserveScroll: true
    });
};

/** توابع کمکی ظاهر **/
const formatPrice = (n) => new Intl.NumberFormat('fa-IR').format(n) + ' تومان';
const formatDate = (date) => new Intl.DateTimeFormat('fa-IR', { dateStyle: 'long', timeStyle: 'short' }).format(new Date(date));
const getStatusClass = (s) => ({ 'new': 'bg-blue-100 text-blue-800', 'pending': 'bg-yellow-100 text-yellow-800', 'completed': 'bg-green-100 text-green-800' }[s] || 'bg-gray-100');
</script>

<template>
    <Head :title="'پرونده ' + contact.first_name" />

    <AuthenticatedLayout>
        <template #header>
            <div class="flex justify-between items-center" dir="rtl">
                <h2 class="font-semibold text-xl text-gray-800 leading-tight">پرونده: {{ contact.first_name }} {{ contact.last_name }}</h2>
                <Link :href="route('contacts.index')" class="text-sm text-blue-600 hover:underline">← بازگشت به لیست</Link>
            </div>
        </template>

        <div class="py-12 bg-gray-50 font-vazir" dir="rtl">
            <div class="max-w-7xl mx-auto sm:px-6 lg:px-8 space-y-6">

                <!-- بخش اول: کارت اطلاعات شناسنامه‌ای -->
                <div class="bg-white p-6 shadow rounded-xl border-t-4 border-blue-500">
                    <div class="flex justify-between items-center mb-8 border-b pb-4">
                        <div class="flex items-center gap-2">
                            <span class="text-2xl">👤</span>
                            <h3 class="text-lg font-bold text-gray-700">اطلاعات جامع مشتری</h3>
                        </div>
                        <button @click="isEditing = !isEditing" class="text-sm px-5 py-2 rounded-lg font-medium shadow-sm transition"
                                :class="isEditing ? 'bg-red-50 text-red-600 hover:bg-red-100' : 'bg-blue-50 text-blue-600 hover:bg-blue-100'">
                            {{ isEditing ? '❌ انصراف' : '📝 ویرایش پرونده' }}
                        </button>
                    </div>

                    <!-- نمایش اطلاعات -->
                    <div v-if="!isEditing" class="grid grid-cols-1 md:grid-cols-4 gap-8">
                        <div><label class="text-gray-400 text-xs block mb-1">نام و نام خانوادگی</label><p class="font-bold text-gray-800">{{ contact.first_name }} {{ contact.last_name }}</p></div>
                        <div><label class="text-gray-400 text-xs block mb-1">نوع مشتری</label><span class="bg-blue-50 text-blue-700 text-xs px-3 py-1 rounded-full font-bold">{{ contact.type }}</span></div>
                        <div><label class="text-gray-400 text-xs block mb-1">نام شرکت</label><p class="font-bold text-gray-800">{{ contact.company || '---' }}</p></div>
                        <div><label class="text-gray-400 text-xs block mb-1">شماره همراه</label><p class="font-bold font-mono tracking-wider">{{ contact.mobile }}</p></div>
                        <div><label class="text-gray-400 text-xs block mb-1">ایمیل</label><p class="font-bold text-sm">{{ contact.email || '---' }}</p></div>
                        <div><label class="text-gray-400 text-xs block mb-1">موقعیت</label><p class="font-bold">{{ contact.province }} - {{ contact.city }}</p></div>
                        <div class="md:col-span-2"><label class="text-gray-400 text-xs block mb-1">آدرس دقیق</label><p class="text-gray-700 text-sm leading-6">{{ contact.address || 'آدرسی ثبت نشده است' }}</p></div>
                    </div>

                    <!-- فرم ویرایش -->
                    <form v-else @submit.prevent="updateContact" class="space-y-6">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-5">
                            <div class="space-y-1"><label class="text-sm font-bold text-gray-600">نام</label><input v-model="editForm.first_name" class="w-full border-gray-200 rounded-lg shadow-sm" /></div>
                            <div class="space-y-1"><label class="text-sm font-bold text-gray-600">نام خانوادگی</label><input v-model="editForm.last_name" class="w-full border-gray-200 rounded-lg shadow-sm" /></div>
                            <div class="space-y-1"><label class="text-sm font-bold text-gray-600">نوع</label>
                                <select v-model="editForm.type" class="w-full border-gray-200 rounded-lg shadow-sm">
                                    <option value="lead">سرنخ</option>
                                    <option value="customer">مشتری فعلی</option>
                                    <option value="vip">ویژه (VIP)</option>
                                </select>
                            </div>
                            <div class="space-y-1"><label class="text-sm font-bold text-gray-600">موبایل</label><input v-model="editForm.mobile" class="w-full border-gray-200 rounded-lg shadow-sm" /></div>
                            <div class="space-y-1"><label class="text-sm font-bold text-gray-600">استان</label><input v-model="editForm.province" class="w-full border-gray-200 rounded-lg shadow-sm" /></div>
                            <div class="space-y-1"><label class="text-sm font-bold text-gray-600">شهر</label><input v-model="editForm.city" class="w-full border-gray-200 rounded-lg shadow-sm" /></div>
                            <div class="md:col-span-3 space-y-1"><label class="text-sm font-bold text-gray-600">آدرس</label><textarea v-model="editForm.address" class="w-full border-gray-200 rounded-lg shadow-sm" rows="2"></textarea></div>
                        </div>
                        <div class="flex justify-end pt-4 border-t gap-3">
                            <button type="submit" :disabled="editForm.processing" class="bg-green-600 text-white px-10 py-2 rounded-lg shadow hover:bg-green-700 transition disabled:opacity-50">ذخیره تغییرات نهایی</button>
                        </div>
                    </form>
                </div>

                <!-- بخش دوم: سفارشات و فعالیت‌ها -->
                <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

                    <!-- تاریخچه سفارشات + وضعیت مالی -->
                    <div class="bg-white p-6 shadow rounded-xl border-t-4 border-green-500">
                        <div class="flex justify-between items-center mb-6">
                            <h3 class="text-lg font-bold">💰 وضعیت مالی و سفارشات</h3>
                            <button @click="isModalOpen = true" class="bg-green-600 text-white px-4 py-1 rounded-lg text-sm shadow hover:bg-green-700">+ ثبت سفارش</button>
                        </div>

                        <div v-if="contact.orders.length > 0" class="space-y-4">
                            <div v-for="order in contact.orders" :key="order.id" class="p-4 border border-gray-100 rounded-xl space-y-3">
                                <div class="flex justify-between items-center">
                                    <span :class="getStatusClass(order.status)" class="text-[10px] px-2 py-1 rounded-full font-bold">{{ order.status }}</span>
                                    <div class="text-left">
                                        <p class="font-bold text-green-700">{{ formatPrice(order.amount) }}</p>
                                        <p class="text-[10px] text-gray-400">مانده: {{ formatPrice(order.amount - order.deposit) }}</p>
                                    </div>
                                </div>
                                <!-- نوار پیشرفت پرداخت -->
                                <div class="w-full bg-gray-100 rounded-full h-1.5 overflow-hidden">
                                    <div class="bg-green-500 h-full transition-all" :style="{ width: (order.deposit / order.amount * 100) + '%' }"></div>
                                </div>
                            </div>
                        </div>
                        <div v-else class="text-center py-10 bg-gray-50 rounded-xl border-2 border-dashed border-gray-200 text-gray-400">سفارشی یافت نشد.</div>
                    </div>

                    <!-- تایم‌لاین فعالیت‌ها -->
                    <div class="bg-white p-6 shadow rounded-xl border-t-4 border-indigo-500">
                        <h3 class="text-lg font-bold mb-6 italic">⏳ جریان فعالیت‌ها</h3>

                        <div class="mb-6 flex gap-2">
                            <input v-model="interactionForm.content" placeholder="گزارش فعالیت جدید..." class="flex-1 text-sm border-gray-200 rounded-lg shadow-sm focus:ring-indigo-500" @keyup.enter="submitInteraction" />
                            <button @click="submitInteraction" class="bg-indigo-600 text-white px-4 py-1 rounded-lg text-sm shadow hover:bg-indigo-700 transition">ثبت</button>
                        </div>

                        <div class="space-y-6 relative before:absolute before:inset-y-0 before:right-3 before:w-0.5 before:bg-gray-100">
                            <div v-for="item in contact.interactions" :key="item.id" class="relative pr-8">
                                <div class="absolute right-0 top-1.5 w-6 h-6 rounded-full bg-white border-4 border-indigo-400 z-10"></div>
                                <div class="bg-white p-4 rounded-xl border border-gray-100 shadow-sm hover:shadow-md transition">
                                    <div class="flex justify-between items-center mb-1">
                                        <span class="font-bold text-xs text-indigo-700">{{ item.type }}</span>
                                        <span class="text-[10px] text-gray-400 font-mono">{{ formatDate(item.created_at) }}</span>
                                    </div>
                                    <p class="text-sm text-gray-600 leading-6">{{ item.content }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Modal ثبت سفارش جدید -->
        <div v-if="isModalOpen" class="fixed inset-0 bg-black/60 backdrop-blur-sm flex items-center justify-center z-50 p-4" dir="rtl">
            <div class="bg-white rounded-2xl shadow-2xl w-full max-w-md p-8">
                <h3 class="text-xl font-bold mb-6 border-b pb-4">ایجاد سفارش جدید</h3>
                <form @submit.prevent="submitOrder" class="space-y-5">
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-2">نوع سفارش</label>
                        <select v-model="orderForm.type" class="w-full border-gray-200 rounded-xl focus:ring-blue-500">
                            <option value="سرویس">سرویس / خدمات</option>
                            <option value="محصول">فروش محصول</option>
                            <option value="اشتراک">تمدید اشتراک</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-2">مبلغ کل (تومان)</label>
                        <input v-model="orderForm.amount" type="number" class="w-full border-gray-200 rounded-xl font-mono text-lg" placeholder="0" />
                    </div>
                    <div>
                        <label class="block text-sm font-bold text-gray-600 mb-2">بیعانه دریافتی (تومان)</label>
                        <input v-model="orderForm.deposit" type="number" class="w-full border-gray-200 rounded-xl font-mono text-lg bg-green-50" placeholder="0" />
                    </div>
                    <div class="flex gap-4 mt-8 pt-4 border-t">
                        <button type="submit" :disabled="orderForm.processing" class="flex-1 bg-green-600 text-white py-3 rounded-xl font-bold shadow-lg hover:bg-green-700 disabled:opacity-50">تایید و ثبت نهایی</button>
                        <button type="button" @click="isModalOpen = false" class="px-6 py-3 text-gray-500 font-medium hover:bg-gray-100 rounded-xl transition">انصراف</button>
                    </div>
                </form>
            </div>
        </div>
    </AuthenticatedLayout>
</template>

<style>
.font-vazir { font-family: 'Vazirmatn', sans-serif !important; }
.font-mono { font-family: 'Vazirmatn', sans-serif !important; } /* برای هماهنگی اعداد */
</style>
