<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import {router} from '@inertiajs/vue3'
import Input from "@/Components/Form/Input.vue";
import { useForm } from 'laravel-precognition-vue-inertia';
import {onBeforeUnmount, onMounted, ref} from "vue";
import MembersTable from "@/Pages/Band/Partials/MembersTable.vue";
import InvitationsTable from "@/Pages/Band/Partials/InvitationsTable.vue";
import FileUpload from "@/Components/Form/FileUpload.vue";

const props = defineProps({
    band: Object,
});

const form = useForm('put', route('bands.update', {band: props.band}), props.band);
const showCloseDismissModal = ref(false);

const handleSaveShortcut = (event) => {
    if ((event.metaKey || event.ctrlKey) && event.key === 's') {
        save();
        event.preventDefault();
    }
};

onMounted(() => {
    window.addEventListener('keydown', handleSaveShortcut);
})

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleSaveShortcut);
});

function save() {
    form.submit()
}

function returnToSheetsOverview() {
    if (form.isDirty) {
        showCloseDismissModal.value = true;
    } else {
        redirectBack();
    }
}

function redirectBack() {
    router.visit(
        route('sheets.index'),
        {
            method: 'get'
        }
    )
}
</script>

<template>
    <BaseLayout :title="__('band.edit_band', {'title': form.name})">
        <template #title>
            <div class="grid grid-cols-2 gap-x-4">
                <div>
                    {{ __('band.edit') }}
                </div>
                <div class="flex justify-end">
                    <button type="button"
                            @click="returnToSheetsOverview"
                            class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-300 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-2">
                        {{ __('general.cancel') }}
                    </button>
                    <button type="button"
                            :disabled="!form.isDirty"
                            @click="save"
                            class="justify-end disabled:opacity-25 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        {{ __('general.save') }}
                    </button>
                </div>
            </div>
        </template>
        <template #header>
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-12">
                <div class="sm:col-span-6">
                    <Input
                        name="name"
                        label="band.name"
                        v-model="form.name"
                        :error="form.errors.name"
                        @input="form.validate('name')"
                    />
                </div>
                <div class="sm:col-span-6">
                    <FileUpload></FileUpload>
                </div>
            </div>
        </template>
        <MembersTable :members="band.members" :band="band"></MembersTable>

        <InvitationsTable
            :invitations="band.invitations"
            v-if="band.invitations.length > 0"
        ></InvitationsTable>
    </BaseLayout>
</template>
