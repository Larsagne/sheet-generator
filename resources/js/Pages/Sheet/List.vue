<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import CreateSheetModal from "@/Pages/Sheet/Partials/List/CreateSheetModal.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import {computed, ref} from "vue";
import Table from "@/Pages/Sheet/Partials/List/Table.vue";

const props = defineProps({
    sheets: Object
});

const searchTerm = ref("");
const createSheet = ref(false);

const filteredSheets = computed(() => {
    return props.sheets.filter(sheet => {
        if (sheet.title.includes(searchTerm.value) || sheet.artist?.includes(searchTerm.value)) {
            return true;
        }
    });
});
</script>

<template>
    <BaseLayout :title="__('sheet.sheets')">
        <template #title>
            <div class="grid grid-cols-2 gap-x-4">
                <div>{{ __('sheet.sheets') }}</div>
                <div class="flex justify-end">
                    <PrimaryButton @click="createSheet = true;">{{ __('sheet.create') }}</PrimaryButton>
                </div>
            </div>
        </template>

        <template #header>
            <div>
                <p class="mb-4">{{ __('sheet.description') }}</p>
                <div class="mt-1 mb-2">
                    <input type="text" :placeholder="__('sheet.search_term')" name="searchTerm" id="searchTerm" v-model="searchTerm" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                </div>
                <p class="text-xs pl-2 text-gray-600">
                    <span v-html="__('sheet.found_x_sheets', {'count': filteredSheets.length})"></span>
                </p>
            </div>
        </template>
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
                <Table :sheets="filteredSheets"></Table>
            </div>
        </div>

        <CreateSheetModal :show="createSheet" @close="createSheet = false"></CreateSheetModal>
    </BaseLayout>
</template>
