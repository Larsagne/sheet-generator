<script setup>
import AuthenticatedLayout from '@/Layouts/AuthenticatedLayout.vue';
import { Head } from '@inertiajs/inertia-vue3';
import BaseLayout from "@/Layouts/BaseLayout.vue";
</script>

<template>
    <Head title="Dashboard" />

    <BaseLayout>
        <template #title>
            Dashboard
        </template>

        <template #header>
            <p class="mb-2">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Debitis dolores ducimus est fuga impedit laudantium nam nisi nobis perferendis, possimus quis ratione rerum, sed totam vitae. Eligendi fugit minima vitae!</p>
            <p>Lorem ipsum dolor sit amet, consectetur adipisicing elit. Aliquid animi dicta laboriosam mollitia rem suscipit! Debitis ea facilis natus provident repellat, sequi voluptate? Consequuntur delectus dolorum fugit harum in ipsam, iure labore magni nihil omnis quod repudiandae, sequi suscipit ullam vel. Architecto aspernatur commodi illum molestias reiciendis rerum sint vel?</p>
        </template>
                <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                    <div class="p-6 text-gray-900">You're logged in!</div>
                </div>

    </BaseLayout>
</template>
