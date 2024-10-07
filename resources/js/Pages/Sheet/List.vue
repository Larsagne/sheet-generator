<script setup>
import BaseLayout from '@/Layouts/BaseLayout.vue';
import CreateSheetModal from "@/Pages/Sheet/Partials/List/CreateSheetModal.vue";
import PrimaryButton from "@/Components/Form/PrimaryButton.vue";
import {computed, onMounted, ref} from "vue";
import Table from "@/Pages/Sheet/Partials/List/Table.vue";
import BandTile from "@/Pages/Sheet/Partials/List/BandTile.vue";
import CreateBandModal from "@/Pages/Sheet/Partials/List/CreateBandModal.vue";
import {usePage} from "@inertiajs/vue3";

const tileBackgrounds = [
    'bg-pink-600', 'bg-purple-600', 'bg-yellow-500', 'bg-green-500', 'bg-blue-500'
];

const props = defineProps({
    sheets: Object,
    bands: Object
});


const page = usePage()
const user = computed(() => page.props.auth.user)
const searchTerm = ref("");
const createSheet = ref(false);
const createBand = ref(false);
const activeSelfSheets = ref(false);

const filteredSheets = computed(() => {
    return props.sheets.filter(sheet => {
        if (sheet.title.includes(searchTerm.value) || sheet.artist?.includes(searchTerm.value)) {
            return true;
        }
    });
});

const bandTiles = ref([]);

onMounted(() => {
    for (let index in props.bands) {
        const band = props.bands[index];

        bandTiles.value.push({
            id: band.id,
            name: band.name,
            members: band.member_count,
            active: false,
            initials: getInitials(band.name)
        });
    }
})

function selectTile(index) {
    bandTiles.value[index]['active'] = !bandTiles.value[index]['active'];
}
function getInitials(string) {
    return string.split(' ').map(wort => wort.charAt(0).toUpperCase()).join('');
}
</script>

<template>
    <BaseLayout :title="__('sheet.sheets')">
        <template #title>
            <div class="grid grid-cols-2 gap-x-4">
                <div>{{ __('sheet.sheets') }}</div>
                <div class="flex justify-end">
                    <PrimaryButton @click="createSheet = true;">{{ __('sheet.create') }}</PrimaryButton>
                </div>
            </div>
        </template>

        <template #header>
            <div>
                    <ul role="list" class="mb-4 grid grid-cols-1 gap-5 sm:grid-cols-2 sm:gap-2 lg:grid-cols-4">
                        <BandTile
                            :initials="getInitials(user.name)"
                            :title="user.name"
                            :subtitle="__('sheet.my_sheets')"
                            background-color="bg-gray-500"
                            :active="activeSelfSheets"
                            :callback="() => {activeSelfSheets = !activeSelfSheets}"
                        ></BandTile>
                        <BandTile
                            v-for="(bandTile, key) in bandTiles"
                            :key="bandTile.name"
                            :initials="bandTile.initials"
                            :title="bandTile.name"
                            :subtitle="bandTile.members + ' ' + __('band.members')"
                            :background-color="tileBackgrounds[key]"
                            :active="bandTile.active"
                            :editable="true"
                            :band-id="bandTile.id"
                            :callback="() => {selectTile(key)}"
                        ></BandTile>
                        <BandTile
                            :title="__('band.create')"
                            background-color="bg-indigo-600"
                            :callback="() => {createBand = true}"
                        ></BandTile>
                    </ul>


                <div class="mt-1 mb-2">
                    <input type="text" :placeholder="__('sheet.search_term')" name="searchTerm" id="searchTerm" v-model="searchTerm" class="block w-full rounded-md border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500 sm:text-sm" />
                </div>
                <p class="text-xs pl-2 text-gray-600">
                    <span v-html="__('sheet.found_x_sheets', {'count': filteredSheets.length})"></span>
                </p>
            </div>

        </template>
        <div class="max-w-7xl mx-auto space-y-6">
            <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 sm:-mx-6 md:mx-0 md:rounded-lg">
                <Table :sheets="filteredSheets"></Table>
            </div>
        </div>

        <CreateSheetModal :show="createSheet" @close="createSheet = false"></CreateSheetModal>
        <CreateBandModal :show="createBand" @close="createBand = false"></CreateBandModal>
    </BaseLayout>
</template>
