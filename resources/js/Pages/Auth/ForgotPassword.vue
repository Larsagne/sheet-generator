<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/Form/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Input from "@/Components/Form/Input.vue";

defineProps({
    status: String,
});

const form = useForm({
    email: '',
});

const submit = () => {
    form.post(route('password.email'));
};
</script>

<template>
    <GuestLayout>
        <Head :title="__('forgot_password_title')" />

        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.forgot_password') }}
        </div>

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <Input name="email" v-model="form.email" label="auth.email" :error="form.errors.email"/>
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing || !form.email"
                >
                    {{ __('auth.reset_password') }}
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
