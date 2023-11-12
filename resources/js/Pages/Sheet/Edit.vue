<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import {router} from '@inertiajs/vue3'
import TapTempo from "@/Pages/Sheet/Partials/Edit/TapTempo.vue";
import Input from "@/Components/Form/Input.vue";
import { useForm } from 'laravel-precognition-vue-inertia';
import TextArea from "@/Components/Form/TextArea.vue";
import Parts from "@/Pages/Sheet/Partials/Edit/Parts.vue";
import {onBeforeUnmount, onMounted, ref} from "vue";

const props = defineProps({
    sheet: Object,
});

const form = useForm('put', route('sheets.update', {sheet: props.sheet}), props.sheet);
const showCloseDismissModal = ref(false);

const handleSaveShortcut = (event) => {
    if ((event.metaKey || event.ctrlKey) && event.key === 's') {
        save();
        event.preventDefault();
    }
};

onMounted(() => {
    setInterval(autoSave, 10000);
    window.addEventListener('keydown', handleSaveShortcut);
})

onBeforeUnmount(() => {
    window.removeEventListener('keydown', handleSaveShortcut);
});

function save() {
    form.submit()
}

function autoSave() {
    if (form.isDirty) {
        save();
    }
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
    <BaseLayout :title="__('sheet.edit_sheet', {'title': form.title})">
        <template #title>
            <div class="grid grid-cols-2 gap-x-4">
                <div>
                    {{ __('sheet.edit') }}
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
                        name="title"
                        label="sheet.title"
                        v-model="form.title"
                        :error="form.errors.title"
                        @input="form.validate('title')"
                    />
                </div>

                <div class="sm:col-span-6">
                    <Input
                        name="artist"
                        label="sheet.artist"
                        v-model="form.artist"
                        :error="form.errors.artist"
                        @input="form.validate('artist')"
                    />
                </div>

                <div class="sm:col-span-6">
                    <TextArea
                        name="description"
                        label="sheet.description_label"
                        v-model="form.description"
                        :error="form.errors.description"
                        @input="form.validate('description')"
                    />
                </div>

                <div class="sm:col-span-6">
                    <div class="grid grid-cols-4 gap-4">
                        <div class="sm:col-span-1">
                            <Input
                                name="tempo"
                                label="sheet.tempo"
                                v-model="form.tempo"
                                :error="form.errors.tempo"
                                type="number"
                                @input="form.validate('tempo')"
                            />
                            <div class="mt-2">
                                <TapTempo @tapped-tempo="(tempo) => form.tempo = tempo"></TapTempo>
                            </div>
                        </div>

                        <div class="sm:col-span-1">
                            <Input
                                name="key"
                                label="sheet.key"
                                v-model="form.key"
                                :error="form.errors.key"
                                type="text"
                                @input="form.validate('key')"
                            />
                        </div>

                        <div class="sm:col-span-1">
                            <Input
                                name="time_signature"
                                label="sheet.time_signature"
                                v-model="form.time_signature"
                                :error="form.errors.time_signature"
                                type="text"
                                @input="form.validate('time_signature')"
                            />
                        </div>

                        <div class="sm:col-span-1">
                            <Input
                                name="duration"
                                label="sheet.duration"
                                v-model="form.duration"
                                :error="form.errors.duration"
                                type="number"
                                @input="form.validate('duration')"
                            />
                        </div>
                    </div>
                </div>
            </div>

        </template>

        <Parts
            :parts="form.parts"
            :show-close-dismiss-modal="showCloseDismissModal"
            :time_signature="form.time_signature"
            @close-close-dismiss-modal="showCloseDismissModal = false"
            @redirect-back="redirectBack"
        />
    </BaseLayout>
</template>
