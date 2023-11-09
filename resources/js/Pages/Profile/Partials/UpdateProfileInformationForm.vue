<script setup>
import PrimaryButton from '@/Components/Form/PrimaryButton.vue';
import { useForm, usePage } from '@inertiajs/vue3';
import Input from "@/Components/Form/Input.vue";
import {computed} from "vue";

const props = defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});

const user = usePage().props.auth.user;

const form = useForm({
    name: user.name,
    email: user.email,
});

const editable = computed(() => {
    return user.source === 'laravel';
});
</script>

<template>
    <section>
        <header>
            <h2 class="text-lg font-medium text-gray-900">{{ __('profile.settings') }}</h2>

            <p class="mt-1 text-sm text-gray-600">
                <span v-html="__(editable ? 'profile.update_description' : 'profile.fix_description')"></span>
            </p>
        </header>

        <form @submit.prevent="form.patch(route('profile.update'))" class="mt-6 space-y-4">
            <div>
                <Input
                    name="name"
                    label="auth.name"
                    v-model="form.name"
                    :error="form.errors.name"
                    :disabled="!editable"
                />
            </div>

            <div>
                <Input
                    name="email"
                    label="auth.email"
                    v-model="form.email"
                    type="email"
                    :error="form.errors.email"
                    :disabled="!editable"
                />
            </div>

            <div v-if="form.recentlySuccessful" class="mb-4 font-medium text-sm text-green-600">
                {{ __('profile.saved') }}
            </div>

            <div class="flex items-center gap-4" v-if="editable">
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
