<script>
import moment from 'moment';
import BaseLayout from '@/Layouts/BaseLayout.vue';
import {InertiaLink} from "@inertiajs/inertia-vue3";

import {
    PencilSquareIcon,
} from '@heroicons/vue/24/outline'

export default {
    components: {
        BaseLayout, PencilSquareIcon, InertiaLink
    },
    props: {
        sheets: Object,
    },
    data() {
        return {
            searchTerm: ""
        }
    },
    methods: {
        formatDate(date) {
            return moment(date).format('DD.MM.YYYY');
        },
    },
    computed: {
        filteredSheets() {
            const searchTerm = this.searchTerm;
            return this.sheets.filter(sheet => {
                if (sheet.title.includes(searchTerm) || sheet.artist.includes(searchTerm) )
                return true;
            });
        }
    }
}
</script>

<template>
    <BaseLayout>
        <template #title>
            <div class="grid grid-cols-2 gap-x-4">
                <div>Sheets</div>
                <div class="flex justify-end">
                    <button type="button"
                            class="justify-end disabled:opacity-25 inline-flex items-center rounded-md border border-transparent bg-indigo-600 px-4 py-2 text-sm font-medium text-white shadow-sm hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2">
                        Neues Sheet anlegen
                    </button>
                </div>
            </div>
        </template>
        <template #header>

            <div>
                <p class="mb-4">Lorem ipsum dolor sit amet, consectetur adipisicing elit. Ab animi consequuntur explicabo nisi non! Accusamus atque distinctio eos, facere quasi sapiente. Deserunt, exercitationem laboriosam maiores officiis ratione sequi suscipit veritatis?</p>
                <div class="mt-1 mb-2">
                    <input type="text" placeholder="Suchbegriff" name="searchTerm" id="searchTerm" v-model="searchTerm" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                </div>
                <p class="text-xs pl-2 text-gray-600">Es wurden <strong>{{ filteredSheets.length }} Sheets</strong> gefunden.</p>
            </div>
        </template>
        <div class="max-w-7xl mx-auto space-y-6">
            <div
                class="-mx-4 overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
                <table class="min-w-full divide-y divide-gray-300">
                    <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Titel</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">Künstler</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">Dauer</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">Hinzugefügt am</th>
                        <th scope="col" class="hidden px-3 py-3.5 text-left text-sm font-semibold text-gray-900 md:table-cell">Aktualisiert am</th>
                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                            <span class="sr-only">Bearbeiten</span>
                        </th>
                    </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-200 bg-white">
                    <tr v-for="sheet in filteredSheets" :key="sheet.title">
                        <td class="w-full max-w-0 py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:w-auto sm:max-w-none sm:pl-6">
                            <a :href="'/sheets/' + sheet.id" target="_blank" class="text-indigo-700 hover:underline"><strong>{{ sheet.title }}</strong></a>
                            <span class="ml-1">(<a :href="'/sheet/' + sheet.id + '?lyrics=1'" target="_blank" class="text-indigo-700 hover:underline">Lyrics</a>)</span>
                            <dl class="font-normal lg:hidden">
                                <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ sheet.artist }}</dd>
                                <dd class="mt-1 truncate text-gray-500 sm:hidden">{{ sheet.duration }}</dd>
                            </dl>
                        </td>
                        <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ sheet.artist }}</td>
                        <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ sheet.duration }}</td>
                        <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ formatDate(sheet.created_at) }}</td>
                        <td class="hidden px-3 py-4 text-sm text-gray-500 md:table-cell">{{ formatDate(sheet.updated_at) }}</td>
                        <td class="py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                            <InertiaLink :href="route('sheets.edit', sheet.id)">
                                <button type="button"
                                        class="inline-flex items-center rounded-md bg-indigo-50 text-indigo-700 hover:text-white hover:bg-indigo-700 border-none p-2 ml-1 text-sm font-medium leading-4 text-gray-700 shadow-sm">
                                    <PencilSquareIcon class="h-4 w-4" aria-hidden="true"/>
                                </button>
                            </InertiaLink>

                            <InertiaLink :href="route('sheets.playback', sheet.id)">
                                <button type="button"
                                        class="inline-flex items-center rounded-md bg-indigo-50 text-indigo-700 hover:text-white hover:bg-indigo-700 border-none p-2 ml-1 text-sm font-medium leading-4 text-gray-700 shadow-sm">
                                    Playback
                                </button>
                            </InertiaLink>
                        </td>
                    </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </BaseLayout>
</template>
