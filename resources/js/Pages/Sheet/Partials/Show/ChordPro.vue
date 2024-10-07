<script setup>
import { computed } from 'vue';

const props = defineProps({
    part: Object,
});

const lines = computed(() => {
    return props.part.lyrics.split("\n");
});

function splitLyrics(input) {
    const result = [];

    const regex = /([^\[]+)?\[([^\]]+)\]/g;

    let lastIndex = 0;
    let match;

    while ((match = regex.exec(input)) !== null) {
        const [fullMatch, textPart, chord] = match;

        if (textPart) {
            result.push({ content: textPart.trim() + ' ', type: "word" });
        }

        result.push({ content: chord, type: "chord" });

        lastIndex = regex.lastIndex;
    }

    if (lastIndex < input.length) {
        const remainingText = input.slice(lastIndex).trim();
        if (remainingText) {
            result.push({ content: remainingText + ' ', type: "word" });
        }
    }

    return result;
}
</script>

<template>
    <div class="whitespace-pre-wrap">
        <div v-for="line in lines">
            <div>CHORDS</div>
           <div class="relative">
                <div
                    v-for="word in splitLyrics(line)"
                    :style="{'background-color': Math.floor(Math.random()*16777215).toString(16)}"
                    class="inline-block"
                >
                    <span v-if="word.type === 'word'" class="word">{{ word.content }}</span>
                    <span v-if="word.type === 'chord'" class="text-green-600 chord">{{ word.content }}</span>
                </div>
           </div>
        </div>
    </div>
</template>
