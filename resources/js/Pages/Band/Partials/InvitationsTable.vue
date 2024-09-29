<script setup>
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import {TrashIcon} from '@heroicons/vue/24/outline'
import {ref} from "vue";
import DeleteInvitationModal from "@/Pages/Band/Partials/DeleteInvitationModal.vue";

defineProps({
    invitations: Array,
});

const removeInvitation = ref(null);
</script>

<template>

        <div class="mx-auto max-w-7xl mb-4 flex justify-between mt-16">
            <div class="text-xl mb-2">{{ __('band.open_invitations') }}</div>
        </div>
        <table class="min-w-full divide-y divide-gray-300">
            <thead class="bg-gray-50">
            <tr>
                <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ __('band.email') }}</th>
                <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                    <span class="sr-only">{{ __('band.edit') }}</span>
                </th>
            </tr>
            </thead>
            <tbody class="divide-y divide-gray-200 bg-white">
            <tr v-for="(invitation) in invitations" :key="invitation.id">
                <td class="flex items-center py-4 pl-3">
                    <div class="ml-4">
                        <div class="font-medium text-gray-900">{{ invitation.email }}</div>
                    </div>
                </td>
                <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                    <span class="inline-flex">
                        <SecondaryButton @click="removeInvitation = invitation" class="px-2 mr-2"><TrashIcon class="h-4 w-4" aria-hidden="true"/></SecondaryButton>
                    </span>
                </td>
            </tr>
            </tbody>
        </table>

    <DeleteInvitationModal
        :show="removeInvitation !== null"
        :invitation="removeInvitation"
        @close="removeInvitation = null"
    ></DeleteInvitationModal>
</template>
