<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import Modal from "@/Components/Modal.vue";
import MutedButton from "@/Components/Form/MutedButton.vue";
import DangerButton from "@/Components/Form/DangerButton.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    sheet: Object,
    show: Boolean
})

const emits = defineEmits(['close'])

const form = useForm('post', route('sheets.store'), {
    title: null
})

function deleteSheet() {
    router.delete(
        route('sheets.destroy', {sheet: props.sheet}),
    )

    emits('close');
}
</script>

<template>
    <Modal @close="$emit('close')" :show="show" max-width="lg" title="sheet.delete">
        <p>{{ __('sheet.delete_confirm_description', {title: sheet.title}) }}</p>

        <div class="sm:col-span-12 mt-4 flex justify-end">
            <MutedButton @click="$emit('close')" class="mr-2">
                {{ __('general.cancel') }}
            </MutedButton>

            <DangerButton @click="deleteSheet">
                {{ __('sheet.delete') }}
            </DangerButton>
        </div>
    </Modal>
</template>
