<script setup>
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";
import {PencilSquareIcon, TrashIcon} from '@heroicons/vue/24/outline'
import moment from "moment/moment";
import {ref} from "vue";
import CreateSheetModal from "@/Pages/Sheet/Partials/List/CreateSheetModal.vue";
import DeleteSheetModal from "@/Pages/Sheet/Partials/List/DeleteSheetModal.vue";

defineProps({
    sheets: Array
});

const deleteSheet = ref(null);

function formatDate(date) {
    return moment(date).format('DD.MM.YYYY');
}
</script>

<template>
    <table class="min-w-full divide-y divide-gray-300">
        <thead class="bg-gray-50">
        <tr>
            <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">{{ __('sheet.title') }}</th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">{{ __('sheet.artist') }}</th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">{{ __('sheet.duration') }}</th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">{{ __('sheet.created_at') }}</th>
            <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">{{ __('sheet.updated_at') }}</th>
            <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                <span class="sr-only">{{ __('sheet.edit') }}</span>
            </th>
        </tr>
        </thead>
        <tbody class="divide-y divide-gray-200 bg-white">
        <tr v-for="sheet in sheets" :key="sheet.title">
            <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                <a :href="'/sheets/' + sheet.id" target="_blank" class="text-indigo-700 hover:underline"><strong>{{ sheet.title }}</strong></a>
                <span class="ml-1">(<a :href="'/sheet/' + sheet.id + '?lyrics=1'" target="_blank" class="text-indigo-700 hover:underline">{{ __('sheet.lyrics') }}</a>)</span>
                <dl class="font-normal lg:hidden">
                    <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ sheet.artist }}</dd>
                    <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ sheet.duration }}</dd>
                </dl>
            </td>
            <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ sheet.artist }}</td>
            <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ sheet.duration }}</td>
            <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ formatDate(sheet.created_at) }}</td>
            <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ formatDate(sheet.updated_at) }}</td>
            <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                <span class="inline-flex">
                    <SecondaryButton @click="deleteSheet = sheet" class="px-2"><TrashIcon class="h-4 w-4" aria-hidden="true"/></SecondaryButton>
                    <SecondaryButton :href="route('sheets.edit', sheet.id)" class="px-2"><PencilSquareIcon class="h-4 w-4" aria-hidden="true"/></SecondaryButton>
                    <SecondaryButton :href="route('sheets.playback', sheet.id)">{{ __('sheet.playback') }}</SecondaryButton>
                </span>
            </td>
        </tr>
        </tbody>
    </table>

    <DeleteSheetModal :show="deleteSheet !== null" :sheet="deleteSheet" @close="deleteSheet = null"></DeleteSheetModal>
</template>
