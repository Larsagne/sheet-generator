<script setup>
import Modal from "@/Components/Modal.vue";
import MutedButton from "@/Components/Form/MutedButton.vue";
import DangerButton from "@/Components/Form/DangerButton.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    invitation: Object,
    show: Boolean
})

const emits = defineEmits(['close'])

function removeInvitation() {
    router.delete(
        route('invitations.destroy', {invitation: props.invitation}),
    )

    emits('close');
}
</script>

<template>
    <Modal @close="$emit('close')" :show="show" max-width="lg" title="invitation.remove">
        <p>{{ __('invitation.delete_confirm_description') }}</p>

        <div class="sm:col-span-12 mt-4 flex justify-end">
            <MutedButton @click="$emit('close')" class="mr-2">
                {{ __('general.cancel') }}
            </MutedButton>

            <DangerButton @click="removeInvitation">
                {{ __('invitation.remove') }}
            </DangerButton>
        </div>
    </Modal>
</template>
