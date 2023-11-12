<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import Modal from "@/Components/Modal.vue";
import Input from "@/Components/Form/Input.vue";
import MutedButton from "@/Components/Form/MutedButton.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";

const props = defineProps({
    show: Boolean
})

defineEmits(['close'])

const form = useForm('post', route('sheets.store'), {
    title: null
})
</script>

<template>
    <Modal @close="$emit('close')" :show="show" max-width="lg" title="sheet.create">
        <form @submit.prevent="form.submit">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-12">
                <Input name="title" placeholder="Let It Be" v-model="form.title" @input="form.validate('title')" :error="form.errors.title" />

                <div class="sm:col-span-12 flex justify-end">
                    <MutedButton @click="$emit('close')" class="mr-2">
                        {{ __('general.cancel') }}
                    </MutedButton>

                    <PrimaryButton type="submit" :disabled="form.processing || !form.title || form.hasErrors">
                        {{ __('sheet.create') }}
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
