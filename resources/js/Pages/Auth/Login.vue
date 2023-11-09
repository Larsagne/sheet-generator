<script setup>
import Checkbox from '@/Components/Form/Checkbox.vue';
import GuestLayout from '@/Layouts/GuestLayout.vue';
import { Head, Link, useForm } from '@inertiajs/vue3';
import Input from "@/Components/Form/Input.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";

defineProps({
    canResetPassword: Boolean,
    status: String,
});

const form = useForm({
    email: '',
    password: '',
    remember: false,
});

const submit = () => {
    form.post(route('login'), {
        onFinish: () => form.reset('password'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head :title="__('auth.login')" />

        <div v-if="status" class="mb-4 font-medium text-sm text-green-600">
            {{ status }}
        </div>

        <form @submit.prevent="submit">
            <div>
                <Input
                    name="email"
                    type="email"
                    label="auth.email"
                    :error="form.errors.email"
                    v-model="form.email"
                />
            </div>
            <div class="mt-4">
                <Input
                    name="password"
                    type="password"
                    label="auth.password_label"
                    :error="form.errors.password"
                    v-model="form.password"
                />
            </div>

            <div class="block mt-4">
                <label class="flex items-center">
                    <Checkbox name="remember" v-model:checked="form.remember" />
                    <span class="ml-2 text-sm text-gray-600">{{ __('auth.remember_me') }}</span>
                </label>
            </div>

            <div class="flex items-center justify-end mt-4">
                <Link
                    v-if="canResetPassword"
                    :href="route('password.request')"
                    class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >
                    {{ __('auth.password_forget') }}
                </Link>

                <PrimaryButton type="submit" class="ml-4" :class="{ 'opacity-25': form.processing }" :disabled="form.processing">
                    {{ __('auth.login') }}
                </PrimaryButton>
            </div>
        </form>

        <hr class="mt-6 mb-6">

        <div class="flex justify-center">
            <a
                :href="route('google.redirect')"
                class="bg-white text-gray-800 hover:bg-gray-100 py-2 px-4 rounded-lg inline-flex border border-gray-400 hover:border-gray-100 items-center text-sm"
            >
            <span class="pr-2">
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24" class="w-4"><path d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z" fill="#4285F4"/><path d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z" fill="#34A853"/><path d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l2.85-2.22.81-.62z" fill="#FBBC05"/><path d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z" fill="#EA4335"/><path d="M1 1h22v22H1z" fill="none"/></svg>
            </span>
                {{ __('auth.login_google') }}
            </a>
        </div>

    </GuestLayout>
</template>
