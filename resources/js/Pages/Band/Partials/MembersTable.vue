<script setup>
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import {TrashIcon} from '@heroicons/vue/24/outline'
import {ref} from "vue";
import DeleteMemberModal from "@/Pages/Band/Partials/DeleteMemberModal.vue";
import InvitationModal from "@/Pages/Band/Partials/InvitationModal.vue";

defineProps({
    members: Array,
    band: Object
});

const removeMember = ref(null);
const showInvitationModal = ref(false);

const tileBackgrounds = [
    'bg-pink-600', 'bg-purple-600', 'bg-yellow-500', 'bg-green-500', 'bg-blue-500'
];

function getBackgroundColor(index)
{
    return tileBackgrounds[index % tileBackgrounds.length];
}
</script>

<template>
    <div class="mx-auto max-w-7xl mb-4 flex justify-between">
        <div class="text-xl mb-2">{{ __('band.members') }}</div>
        <div class="flex justify-end">
            <SecondaryButton @click="showInvitationModal = true">{{ __('band.invite') }}</SecondaryButton>
        </div>
    </div>
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ __('band.name') }}</th>
            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                <span class="sr-only">{{ __('band.edit') }}</span>
            </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-for="(member, key) in members" :key="member.id">
            <td class="flex items-center py-4 pl-3">
                <div class="h-11 w-11 flex-shrink-0">
                    <div :class="[
                        getBackgroundColor(key),
                        'h-11 w-11 rounded-full grid justify-center place-content-center text-white'
                    ]">
                        {{ member.name.split(' ').map(wort => wort.charAt(0).toUpperCase()).join('') }}
                    </div>
                </div>
                <div class="ml-4">
                    <div class="font-medium text-gray-900">{{ member.name }}</div>
                    <div class="text-gray-500">{{ member.email }}</div>
                </div>
            </td>
            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                <span class="inline-flex">
                    <SecondaryButton @click="removeMember = member" class="px-2 mr-2"><TrashIcon class="h-4 w-4" aria-hidden="true"/></SecondaryButton>
                </span>
            </td>
        </tr>
        </tbody>
    </table>

    <DeleteMemberModal
        :show="removeMember !== null"
        :member="removeMember"
        :band="band"
        @close="removeMember = null"
    ></DeleteMemberModal>


    <InvitationModal
        :show="showInvitationModal"
        :invitable-id="band.id"
        invitable-type="App\Models\Band"
        @close="showInvitationModal = false"
    ></InvitationModal>
</template>
