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
        class="border-1 border-gray-500 text-gray-500 hover:border-0 hover:text-white hover:bg-gray-400"
        :href="href"
        :method="method"
    >
        <slot></slot>
    </Button>
</template>
