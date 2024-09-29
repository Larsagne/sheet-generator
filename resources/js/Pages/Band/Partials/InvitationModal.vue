<script setup>
import { useForm } from 'laravel-precognition-vue-inertia';
import Modal from "@/Components/Modal.vue";
import Input from "@/Components/Form/Input.vue";
import MutedButton from "@/Components/Form/MutedButton.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";

const props = defineProps({
    show: Boolean,
    invitableType: String,
    invitableId: String
})

const emits = defineEmits(['close'])


const form = useForm('post', route('invitations.store'), {
    email: null,
    invitable_id: props.invitableId,
    invitable_type: props.invitableType,
})

function invite() {
    form.submit();
    emits('close');
}
</script>

<template>
    <Modal @close="$emit('close')" :show="show" max-width="lg" title="band.invite">
        <form @submit.prevent="form.submit">
            <div class="grid grid-cols-1 gap-y-6 gap-x-4 sm:grid-cols-12">
                <Input name="email" :placeholder="__('general.email')" v-model="form.email" @input="form.validate('email')" :error="form.errors.email" />

                <div class="sm:col-span-12 flex justify-end">
                    <MutedButton @click="$emit('close')" class="mr-2">
                        {{ __('general.cancel') }}
                    </MutedButton>

<!--                    <PrimaryButton type="submit" :disabled="form.processing || !form.email || form.hasErrors">-->
                    <PrimaryButton type="button" @click="invite" :disabled="false">
                        {{ __('band.invite') }}
                    </PrimaryButton>
                </div>
            </div>
        </form>
    </Modal>
</template>
