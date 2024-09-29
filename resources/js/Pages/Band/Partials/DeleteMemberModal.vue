<script setup>
import Modal from "@/Components/Modal.vue";
import MutedButton from "@/Components/Form/MutedButton.vue";
import DangerButton from "@/Components/Form/DangerButton.vue";
import {router} from "@inertiajs/vue3";

const props = defineProps({
    member: Object,
    band: Object,
    show: Boolean
})

const emits = defineEmits(['close'])

function removeMember() {
    router.delete(
        route('bands.removeMember', {band: props.band, memberId: props.member}),
    )

    emits('close');
}
</script>

<template>
    <Modal @close="$emit('close')" :show="show" max-width="lg" title="band.removeMember">
        <p>{{ __('band.delete_member_confirm_description', {name: member.name}) }}</p>

        <div class="sm:col-span-12 mt-4 flex justify-end">
            <MutedButton @click="$emit('close')" class="mr-2">
                {{ __('general.cancel') }}
            </MutedButton>

            <DangerButton @click="removeMember">
                {{ __('band.removeMember') }}
            </DangerButton>
        </div>
    </Modal>
</template>
