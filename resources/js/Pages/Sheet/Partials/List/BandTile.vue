<script setup>

import {EllipsisVerticalIcon, PlusIcon} from "@heroicons/vue/20/solid";
import { Menu, MenuButton, MenuItem, MenuItems } from '@headlessui/vue';
import {Link} from "@inertiajs/vue3";
import {ref} from "vue";
import InvitationModal from "@/Pages/Band/Partials/InvitationModal.vue";

const props = defineProps({
    initials: String|null,
    title: String,
    subtitle: String|null,
    editable: Boolean,
    callback: Function,
    backgroundColor: String|null,
    active: Boolean,
    bandId: String|null
});
const invitableId = ref(null);
</script>

<template>
    <li :class="[
        active ? 'bg-gray-300': '',
        'col-span-1 flex rounded-md shadow-sm cursor-pointer rounded-l-md'
    ]" @click="callback">
        <div :class="[backgroundColor ?? 'bg-gray-400', 'flex w-16 flex-shrink-0 items-center justify-center rounded-l-md text-sm font-medium text-white']">
            <span v-if="initials">{{ initials }}</span>
            <span v-else>
                <PlusIcon class="h-5 w-5"></PlusIcon>
            </span>
        </div>
        <div class="flex flex-1 items-center justify-between rounded-r-md border-b border-r border-t border-gray-200 ">
            <div class="flex-1 px-4 py-2 text-sm">
                <span class="font-medium text-gray-900 hover:text-gray-600">{{ title }}</span>
                <p class="text-gray-500" v-if="subtitle">{{ subtitle }}</p>
            </div>
            <div class="flex-shrink-0 pr-2" v-if="editable">

                <Menu as="div" class="relative inline-block text-left" @click.stop>
                    <div>
                        <MenuButton class="flex items-center rounded-full text-gray-400 hover:text-gray-600 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 focus:ring-offset-gray-100">
                            <span class="sr-only">Open options</span>
                            <EllipsisVerticalIcon class="h-5 w-5" aria-hidden="true" />
                        </MenuButton>
                    </div>

                    <transition enter-active-class="transition ease-out duration-100" enter-from-class="transform opacity-0 scale-95" enter-to-class="transform opacity-100 scale-100" leave-active-class="transition ease-in duration-75" leave-from-class="transform opacity-100 scale-100" leave-to-class="transform opacity-0 scale-95">
                        <MenuItems class="absolute -right-1/2 z-10 mt-6 w-56 origin-top-right rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none">
                            <div class="py-1">
                                <MenuItem v-slot="{ active }">
                                    <Link :href="route('bands.edit', bandId)" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']">
                                        {{ __('general.edit') }}
                                    </Link>
                                </MenuItem>
                                <MenuItem v-slot="{ active }">
                                    <a href="#" :class="[active ? 'bg-gray-100 text-gray-900' : 'text-gray-700', 'block px-4 py-2 text-sm']" @click="invitableId = bandId">
                                        {{ __('band.invite') }}
                                    </a>
                                </MenuItem>
                            </div>
                        </MenuItems>
                    </transition>
                </Menu>
            </div>
        </div>
    </li>

    <InvitationModal
        :show="invitableId !== null"
        :invitable-id="invitableId"
        invitable-type="App\Models\Band"
        @close="invitableId = null"
    ></InvitationModal>
</template>
