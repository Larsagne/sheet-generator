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

const form = useForm('post', route('bands.store'), {
    name: null
})
</script>

<template>
    <Modal @close="$emit('close')" :show="show" max-width="lg" title="band.create">
        <form @submit.prevent="form.submit">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-12">
                <Input name="name" placeholder="The Beatles" v-model="form.name" @input="form.validate('name')" :error="form.errors.name" />

                <div class="sm:col-span-12 flex justify-end">
                    <MutedButton @click="$emit('close')" class="mr-2">
                        {{ __('general.cancel') }}
                    </MutedButton>

                    <PrimaryButton type="submit" :disabled="form.processing || !form.name || form.hasErrors">
                        {{ __('band.create') }}
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
