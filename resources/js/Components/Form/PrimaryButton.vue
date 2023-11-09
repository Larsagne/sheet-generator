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
        class="bg-indigo-600 text-white hover:bg-indigo-700 focus:ring-indigo-500 focus:ring-offset-2"
        :href="href"
        :method="method"
    >
        <slot></slot>
    </Button>
</template>
