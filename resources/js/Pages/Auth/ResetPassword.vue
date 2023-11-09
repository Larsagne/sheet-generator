<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/Form/PrimaryButton.vue';
import { Head, useForm } from '@inertiajs/vue3';
import Input from "@/Components/Form/Input.vue";

const props = defineProps({
    email: String,
    token: String,
});

const form = useForm({
    token: props.token,
    email: props.email,
    password: '',
    password_confirmation: '',
});

const submit = () => {
    form.post(route('password.store'), {
        onFinish: () => form.reset('password', 'password_confirmation'),
    });
};
</script>

<template>
    <GuestLayout>
        <Head :title="__('auth.reset_password')" />

        <form @submit.prevent="submit">
            <div>
                <Input name="email"
                       v-model="form.email"
                       label="auth.email"
                       :error="form.errors.email"
                />
            </div>

            <div class="mt-4">
                <Input name="password"
                       type="password"
                       v-model="form.password"
                       label="auth.password_label"
                       :error="form.errors.password"
                />
            </div>

            <div class="mt-4">
                <Input name="password_confirmation"
                       type="password"
                       v-model="form.password_confirmation"
                       label="auth.confirm_password"
                       :error="form.errors.password_confirmation"
                />
            </div>

            <div class="flex items-center justify-end mt-4">
                <PrimaryButton
                    type="submit"
                    :class="{ 'opacity-25': form.processing }"
                    :disabled="form.processing || !form.password || !form.password_confirmation"
                >
                    {{ __('auth.reset_password') }}
                </PrimaryButton>
            </div>
        </form>
    </GuestLayout>
</template>
