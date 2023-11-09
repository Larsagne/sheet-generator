<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import Input from "@/Components/Form/Input.vue";

const form = useForm({
    name: '',
    email: '',
    password: '',
    password_confirmation: '',
    terms: false,
});

const submit = () => {
    form.post(route('register'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head :title="__('auth.register')" />

        <form @submit.prevent="submit">
            <div>
                <Input
                    name="name"
                    label="auth.name"
                    v-model="form.name"
                    :error="form.errors.name"
                />
            </div>

            <div class="mt-4">
                <Input
                    name="email"
                    label="auth.email"
                    v-model="form.email"
                    type="email"
                    :error="form.errors.email"
                />
            </div>

            <div class="mt-4">
                <Input
                    name="password"
                    label="auth.password_label"
                    v-model="form.password"
                    type="password"
                    :error="form.errors.password"
                />
            </div>

            <div class="mt-4">
                <Input
                    name="password_confirm"
                    label="auth.confirm_password"
                    v-model="form.password_confirmation"
                    type="password"
                    :error="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    :href="route('login')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    {{ __('auth.already_registred') }}
                </Link>

                <PrimaryButton
                    class="ml-4"
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing || !form.email || !form.password || !form.password_confirmation || !form.name"
                >
                    {{ __('auth.register') }}
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
