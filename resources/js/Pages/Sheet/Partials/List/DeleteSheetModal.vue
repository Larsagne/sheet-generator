<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import Modal from "@/Components/Modal.vue";

const props = defineProps({
    sheet: Object,
    show: Boolean
})

defineEmits(['close'])

const form = useForm('post', route('sheets.store'), {
    title: null
})


</script>

<template>
    <Modal @close="$emit('close')" :show="show" max-width="lg" title="sheet.delete">
        <p>{{ __('sheet.delete_confirm_description', {title: sheet.title}) }}</p>
    </Modal>
</template>
