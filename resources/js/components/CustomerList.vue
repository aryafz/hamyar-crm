<template>
    <div>
        <input v-model="search" type="text" placeholder="جستجو" class="border p-2 mb-4 w-full"/>
        <table class="min-w-full text-sm">
            <thead>
                <tr class="bg-gray-100">
                    <th class="p-2">نام</th>
                    <th class="p-2">ایمیل</th>
                </tr>
            </thead>
            <tbody>
                <tr v-for="c in customers" :key="c.id" class="border-b">
                    <td class="p-2">
                        <Link :href="route('contacts.show', c.id)" class="text-blue-600 hover:underline font-bold">
                            {{ c.first_name }} {{ c.last_name }}
                        </Link>
                    </td>
                    <td class="p-2">{{ c.email }}</td>
                </tr>
            </tbody>
        </table>
        <div class="flex justify-between mt-4">
            <button @click="prev" :disabled="page===1" class="px-2 py-1 bg-gray-200">قبلی</button>
            <button @click="next" class="px-2 py-1 bg-gray-200">بعدی</button>
        </div>
    </div>
</template>

<script setup>
import { ref, watch, onMounted } from 'vue';
import axios from 'axios';
import { Link } from '@inertiajs/vue3';

const customers = ref([]);
const page = ref(1);
const search = ref('');

const load = async () => {
    const { data } = await axios.get('/api/contacts', { params: { page: page.value, search: search.value }});
    customers.value = data.data ?? data;
};

onMounted(load);
watch([page, search], load);

const prev = () => { if (page.value > 1) page.value--; };
const next = () => { page.value++; };
</script>
