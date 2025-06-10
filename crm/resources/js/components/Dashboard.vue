<template>
    <div class="grid gap-4 md:grid-cols-2">
        <canvas ref="salesCanvas"></canvas>
        <canvas ref="statusCanvas"></canvas>
    </div>
</template>

<script setup>
import { ref, onMounted } from 'vue';
import { Chart, registerables } from 'chart.js';
import axios from 'axios';
Chart.register(...registerables);

const salesCanvas = ref(null);
const statusCanvas = ref(null);

onMounted(async () => {
    const { data } = await axios.get('/api/orders');
    const orders = data.data ?? data;
    const monthly = Array(12).fill(0);
    const statuses = {};

    orders.forEach(o => {
        const date = new Date(o.created_at);
        monthly[date.getMonth()] += o.total ?? 0;
        statuses[o.status] = (statuses[o.status] || 0) + 1;
    });

    new Chart(salesCanvas.value, {
        type: 'bar',
        data: {
            labels: ['Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec'],
            datasets: [{ label: 'Sales', data: monthly, backgroundColor: '#60a5fa' }]
        }
    });

    new Chart(statusCanvas.value, {
        type: 'doughnut',
        data: {
            labels: Object.keys(statuses),
            datasets: [{ data: Object.values(statuses), backgroundColor: ['#34d399','#f87171','#fbbf24'] }]
        }
    });
});
</script>
