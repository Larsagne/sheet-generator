<script setup>
import GuestLayout from '@/Layouts/GuestLayout.vue';
import PrimaryButton from '@/Components/Form/PrimaryButton.vue';
import {Head, Link} from '@inertiajs/vue3';

</script>

<template>
    <GuestLayout>
        <Head :title="__('auth.verification')" />

        <div class="mb-4 text-sm text-gray-600">
            {{ __('auth.verify_description') }}
        </div>

        <div class="mb-4 font-medium text-sm text-green-600" v-if="$page.props.status === 'verification-link-sent'">
            {{ __('auth.verify_status') }}
        </div>

        <div class="mt-4 flex items-center justify-between">
            <PrimaryButton
                :href="route('verification.send')"
                method="POST"
            >
                {{ __('auth.verification_resend') }}
            </PrimaryButton>

            <Link
                :href="route('logout')"
                method="post"
                as="button"
                class="underline text-sm text-gray-600 hover:text-gray-900 rounded-md focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                >{{ __('auth.logout') }}</Link>
        </div>
    </GuestLayout>
</template>
