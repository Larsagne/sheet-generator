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
        class="border-1 border-red-600 text-red-600 hover:text-white hover:bg-red-600"
        :href="href"
        :method="method"
    >
        <slot></slot>
    </Button>
</template>
