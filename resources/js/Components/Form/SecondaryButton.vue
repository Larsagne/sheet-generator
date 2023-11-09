<script setup>
import Button from "@/Components/Form/Button.vue";

const props = defineProps({
    href: String,
    method: {
        type: String,
        default: 'GET'
    }
})

</script>

<template>
    <Button
        class="bg-indigo-50 text-indigo-700 hover:text-white hover:bg-indigo-700"
        :href="href"
        :method="method"
    >
        <slot></slot>
    </Button>
</template>
