<script setup>
import {Link} from "@inertiajs/vue3";
import {computed} from "vue";

const props = defineProps({
    href: String,
    method: {
        type: String,
        default: 'GET'
    }
})

const classes = computed(() => {
    return 'justify-end disabled:opacity-25 border border-transparent px-4 py-2 inline-flex items-center rounded-md p-2 ml-1 text-sm font-medium leading-4 shadow-sm focus:outline-none focus:ring-2';
});
</script>

<template>
    <Link
        :href="href"
        :class="classes"
        :method="method"
        v-if="href"
        as="button"
    >
        <slot></slot>
    </Link>

    <button
        type="button"
        :class="classes"
        v-else
    >
        <slot></slot>
    </button>
</template>
