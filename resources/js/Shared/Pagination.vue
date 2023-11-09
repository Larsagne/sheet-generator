<template>
    <div class="flex items-center justify-between border-t border-gray-200 bg-white px-4 py-3 sm:px-6">
        <div class="flex flex-1 justify-between sm:hidden">
            <a href="#" class="relative inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Previous</a>
            <a href="#" class="relative ml-3 inline-flex items-center rounded-md border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50">Next</a>
        </div>
        <div class="hidden sm:flex sm:flex-1 sm:items-center sm:justify-between">
            <div>
                <p class="text-sm text-gray-700">
                    <span class="font-medium">{{ pagination.from }}</span>
                    {{ ' ' }}
                    bis
                    {{ ' ' }}
                    <span class="font-medium">{{ pagination.to }}</span>
                    {{ ' ' }}
                    von
                    {{ ' ' }}
                    <span class="font-medium">{{ pagination.total }}</span>
                    {{ ' ' }}
                    Ergebnissen
                </p>
            </div>
            <div>
                <nav class="isolate inline-flex -space-x-px rounded-md shadow-sm" aria-label="Pagination">
                    <inertia-link class="relative inline-flex items-center rounded-l-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20" :href="pagination.prev_page_url">
                        <span class="sr-only">Prev</span>
                        <ChevronLeftIcon class="h-5 w-5" aria-hidden="true" />
                    </inertia-link>

                    <template v-for="(link, key) in pagination.links" :key="key">
                        <span v-if="link.label.includes('Next') || link.label.includes('Previous')"></span>
                        <span v-else-if="link.url === null" class="relative inline-flex items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-700" v-html="link.label"></span>
                        <inertia-link v-else-if="link.active === true" class="relative z-10 inline-flex items-center border border-indigo-500 bg-indigo-50 px-4 py-2 text-sm font-medium text-indigo-600 focus:z-20" :href="link.url" v-html="link.label" />
                        <inertia-link v-else class="relative hidden items-center border border-gray-300 bg-white px-4 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20 md:inline-flex" :href="link.url" v-html="link.label" />
                    </template>

                    <inertia-link class="relative inline-flex items-center rounded-r-md border border-gray-300 bg-white px-2 py-2 text-sm font-medium text-gray-500 hover:bg-gray-50 focus:z-20" :href="pagination.next_page_url">
                        <span class="sr-only">Next</span>
                        <ChevronRightIcon class="h-5 w-5" aria-hidden="true" />
                    </inertia-link>
                </nav>
            </div>
        </div>
    </div>
</template>

<script setup>
import { ChevronLeftIcon, ChevronRightIcon } from '@heroicons/vue/20/solid'
import {Link} from "@inertiajs/vue3";

defineProps({
    pagination: Object,
});
</script>
