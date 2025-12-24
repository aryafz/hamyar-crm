<script setup>
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';
Chart.register(...registerables);

// ۱. دریافت دیتا از والد (صفحه Dashboard.vue اصلی)
const props = defineProps({
    orders: Array
});

const salesCanvas = ref(null);
const statusCanvas = ref(null);

const formatMoney = (val) => new Intl.NumberFormat('fa-IR').format(val) + ' تومان';

onMounted(() => {
    const monthly = Array(12).fill(0);
    const statuses = {};
    const statusTranslation = { 'new': 'جدید', 'pending': 'در جریان', 'completed': 'تکمیل شده', 'canceled': 'لغو شده' };

    // ۲. پردازش دیتایی که از طریق Props آمده
    props.orders.forEach(o => {
        const date = new Date(o.created_at);
        monthly[date.getMonth()] += parseFloat(o.amount || 0);
        const statusFa = statusTranslation[o.status] || o.status;
        statuses[statusFa] = (statuses[statusFa] || 0) + 1;
    });

    // رسم نمودار فروش
    new Chart(salesCanvas.value, {
        type: 'bar',
        data: {
            labels: ['فروردین','اردیبهشت','خرداد','تیر','مرداد','شهریور','مهر','آبان','آذر','دی','بهمن','اسفند'],
            datasets: [{ label: 'مبلغ فروش', data: monthly, backgroundColor: '#3b82f6', borderRadius: 8 }]
        },
        options: { scales: { y: { ticks: { callback: (val) => formatMoney(val) } } } }
    });

    // رسم نمودار وضعیت
    new Chart(statusCanvas.value, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statuses),
            datasets: [{ data: Object.values(statuses), backgroundColor: ['#10b981','#f59e0b','#ef4444','#6366f1'] }]
        }
    });
});
</script>

<template>
    <div class="grid gap-6 md:grid-cols-2">
        <div class="bg-white p-4 rounded-lg border border-gray-100">
            <h3 class="text-sm font-bold mb-4 text-gray-500">فروش ماهانه</h3>
            <canvas ref="salesCanvas"></canvas>
        </div>
        <div class="bg-white p-4 rounded-lg border border-gray-100">
            <h3 class="text-sm font-bold mb-4 text-gray-500">وضعیت سفارش‌ها</h3>
            <canvas ref="statusCanvas"></canvas>
        </div>
    </div>
</template>
