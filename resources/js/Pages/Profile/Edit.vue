<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import DeleteUserForm from './Partials/DeleteUserForm.vue';
import UpdatePasswordForm from './Partials/UpdatePasswordForm.vue';
import UpdateProfileInformationForm from './Partials/UpdateProfileInformationForm.vue';

defineProps({
    mustVerifyEmail: Boolean,
    status: String,
});
</script>

<template>
    <BaseLayout :title="__('profile.settings')">
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <UpdateProfileInformationForm
                    :must-verify-email="mustVerifyEmail"
                    :status="status"
                    class="max-w-xl"
                />
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg" v-if="$page.props.auth.user.source === 'laravel'">
                <UpdatePasswordForm class="max-w-xl"/>
            </div>

            <div class="p-4 sm:p-8 bg-white shadow sm:rounded-lg">
                <DeleteUserForm class="max-w-xl"/>
            </div>
        </div>
    </BaseLayout>
</template>
