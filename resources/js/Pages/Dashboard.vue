<script setup>
import BaseLayout from "@/Layouts/BaseLayout.vue";
import { Head } from '@inertiajs/vue3';

const props = defineProps({
    invitations: Array,
});
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


        <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg p-6" v-if="invitations.length > 0">
            <div class="text-xl mb-2">{{ __('general.open_invitations') }}</div>
            <div>
                <div v-for="invitation in invitations">
                    {{ invitation.invitable.name }}
                </div>
            </div>
        </div>

    </BaseLayout>
</template>
