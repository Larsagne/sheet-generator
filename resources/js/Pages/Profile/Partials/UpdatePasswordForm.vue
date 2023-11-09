<script setup>
import PrimaryButton from '@/Components/Form/PrimaryButton.vue';
import { useForm } from '@inertiajs/vue3';
import { ref } from 'vue';
import Input from "@/Components/Form/Input.vue";

const passwordInput = ref(null);
const currentPasswordInput = ref(null);

const form = useForm({
    current_password: '',
    password: '',
    password_confirmation: '',
});

const updatePassword = () => {
    form.put(route('password.update'), {
        preserveScroll: true,
        onSuccess: () => form.reset(),
        onError: () => {
            if (form.errors.password) {
                form.reset('password', 'password_confirmation');
                passwordInput.value.focus();
            }
            if (form.errors.current_password) {
                form.reset('current_password');
                currentPasswordInput.value.focus();
            }
        },
    });
};
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">{{ __('profile.update_password') }}</h2>

            <p class="mt-1 text-sm text-gray-600">
                {{ __('profile.update_password_description') }}
            </p>
        </header>

        <form @submit.prevent="updatePassword" class="mt-6 space-y-6">
            <div>
                <Input
                    name="current_password"
                    label="auth.current_password"
                    v-model="form.current_password"
                    type="password"
                    :error="form.errors.current_password"
                />
            </div>

            <div>
                <Input
                    name="password"
                    label="auth.password_label"
                    v-model="form.password"
                    type="password"
                    :error="form.errors.password"
                />
            </div>

            <div>
                <Input
                    name="password_confirmation"
                    label="auth.confirm_password"
                    v-model="form.password_confirmation"
                    type="password"
                    :error="form.errors.password_confirmation"
                />
            </div>

            <div v-if="form.recentlySuccessful" class="mb-4 font-medium text-sm text-green-600">
                {{ __('profile.password_saved') }}
            </div>

            <div class="flex items-center gap-4">
                <PrimaryButton
                    :disabled="form.processing"
                    type="submit"
                >
                    {{ __('general.save') }}
                </PrimaryButton>
            </div>
        </form>
    </section>
</template>
