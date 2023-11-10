<script setup>
import {ref} from "vue";
import SecondaryButton from "@/Components/Form/SecondaryButton.vue";

const tapStart = ref(null);
const lastTap = ref(null);
const tapDuration = ref(null);
const beats = ref(0);

const emit = defineEmits(['tappedTempo']);

function tapTempo() {
    let now = new Date();
    let timeSinceLastTapInSeconds = lastTap.value ? ((now - lastTap.value) / 1000) : 0;

    if (timeSinceLastTapInSeconds > 2) {
        tapStart.value = null;
        lastTap.value = null;
        tapDuration.value = null;
        beats.value = null;
    }

    if (!tapStart.value) {
        tapStart.value = now;
    }
    beats.value++;

    lastTap.value = now;
    tapDuration.value = (lastTap.value - tapStart.value) / 1000;

    let tempo = tapDuration.value > 0 ? (((beats.value - 1) / (tapDuration.value / 60)).toFixed(0)) : 0;
    emit('tappedTempo', tempo)
}
</script>

<template>
    <SecondaryButton @click="tapTempo">{{ __('sheet.tap') }}</SecondaryButton>
</template>
