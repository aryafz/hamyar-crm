<template>
    <form @submit.prevent="submit" class="space-y-4">
        <div>
            <label class="block mb-1">نام</label>
            <input v-model="form.name" type="text" class="border p-2 w-full" />
            <span class="text-red-500 text-sm" v-if="errors.name">{{ errors.name }}</span>
        </div>
        <div>
            <label class="block mb-1">ایمیل</label>
            <input v-model="form.email" type="email" class="border p-2 w-full" />
            <span class="text-red-500 text-sm" v-if="errors.email">{{ errors.email }}</span>
        </div>
        <button :disabled="invalid" class="px-4 py-2 bg-blue-600 text-white disabled:opacity-50">ذخیره</button>
    </form>
</template>

<script setup>
import { computed } from 'vue';
import { useField, useForm, defineRule, configure } from 'vee-validate';
import { required, email, min } from '@vee-validate/rules';
import axios from 'axios';

defineRule('required', required);
defineRule('email', email);
defineRule('min', min);

configure({
    generateMessage: ctx => ({
        required: `فیلد ${ctx.field} الزامی است`,
        email: 'فرمت ایمیل نادرست است',
        min: `حداقل ${ctx.rule.params[0]} کاراکتر`,
    }[ctx.rule.name]),
});

const { handleSubmit, errors, meta } = useForm();
const { value: name } = useField('name', 'required|min:3');
const { value: emailValue } = useField('email', 'required|email');
const form = { name, email: emailValue };

const submit = handleSubmit(async values => {
    await axios.post('/api/contacts', values);
    name.value = '';
    emailValue.value = '';
});

const invalid = computed(() => Object.keys(errors.value).length > 0 || !meta.value.valid);
</script>
