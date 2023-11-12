<script setup>
import {Head} from "@inertiajs/vue3";
import moment from "moment";
import Notes from "@/Pages/Sheet/Partials/Show/Notes.vue";
import {onMounted, ref} from "vue";

defineProps({
    sheet: Object
});
const container = ref(null);
</script>

<template>
    <Head :title="sheet.title" />
    <Notes :container="container"></Notes>

    <div class="min-h-screen" style="background-color: #4e4e4e">
        <div class="min-h-screen mx-auto max-w-3xl bg-gray-100" ref="container" style="box-shadow: 0 0 17px 2px rgba(0,0,0,0.75)">
            <div class="pt-3 px-8 fixed w-full max-w-3xl bg-gray-100">
                <div class="py-2 border-gray-800 border-b border-t flex justify-between">
                    <div>
                        <div class="text-md leading-4 font-bold">{{sheet.title}}</div>
                        <div class="text-xs leading-4 font-bold">{{sheet.artist}}</div>
                        <div class="text-xs mt-1" v-if="sheet.description">{{sheet.description}}</div>
                    </div>
                    <div class="text-xs">
                        <div class="flex">
                            <div class="w-12"><strong>{{ __('sheet.key') }}:</strong></div>
                            <div class="w-6 text-right">{{ sheet.key }}</div>
                        </div>
                        <div class="flex">
                            <div class="w-12"><strong>{{ __('sheet.tempo') }}:</strong></div>
                            <div class="w-6 text-right">{{ sheet.tempo }}</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="px-4 sm:px-6 lg:px-8" :class="sheet.description ? 'pt-24' : 'pt-16'">
                <div
                    v-for="(part, partIndex) in sheet.parts"
                    :key="part.id"
                    class="grid grid-cols-2 text-xs space-x-4 py-2"
                    :class="partIndex === sheet.parts.length - 1 ? '' : 'border-b border-gray-700'"
                >
                    <div>
                        <div>
                            <strong>{{ part.name }}</strong>
                        </div>
                        <div>
                            <span v-html='part.description?.replace("\n", "<br/>")'></span>
                        </div>
                        <div v-for="(sequence, index) in part.sequences" :key="index">
                            <div v-if="sequence.description">
                                <div :class="index === 0 && !part.description ? 'mt-0' : 'mt-1' ">
                                    <span class="italic">{{ index + 1 }} . Akkordfolge: </span>
                                    <span v-html='sequence.description?.replace("\n", "<br/>")'></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div v-for="sequence in part.sequences" class="flex">
                            <div class="w-4 pr-6">
                                <strong>{{ sequence.quantity }}x</strong>
                            </div>
                            <div class="flex flex-wrap">
                                <div v-for="(measure, measureIndex) in sequence.measures" class="inline-flex">
                                    <div class="inline-flex whitespace-nowrap">
                                        <div class="">{{ measure.chords }}</div>
                                        <div class="mx-1" v-if="measureIndex !== sequence.measures.length - 1">|</div>
                                    </div>
                                </div>
                            </div>
                            <!--                                        @foreach($sequence->measures as $measure)-->
                            <!--                                        @php-->
                            <!--                                        $sup = ['b', '#', 1, 2, 3, 4, 5, 6, 7, 8, 9, 'add', '+', '°', 'maj', 'dim', '(sus)', '(', ')'];-->
                            <!--                                        $sub = ['sus'];-->
                            <!--                                        $chords = $measure['chords'];-->
                            <!--                                        foreach ($sup as $key) {-->
                            <!--                                        $chords = str_replace($key, '<sup>'. $key .'</sup>', $chords);-->
                            <!--                                        }-->
                            <!--                                        foreach ($sub as $key) {-->
                            <!--                                        $chords = str_replace($key, '<span class="custom-sub">'. $key .'</span>', $chords);-->
                            <!--                                        }-->
                            <!--                                        $chords = str_replace('H', 'B', $chords);-->
                            <!--                                        $chords = str_replace('_', ' ', $chords);-->
                            <!--                                        $chords = str_replace('-', '&mdash;', $chords);-->
                            <!--                                        @endphp-->
                            <!--                                        <span>{!! $chords !!}</span>-->
                            <!--                                        @if (!$loop->last)-->
                            <!--                                        <span style="padding: 0 1px;">|</span>-->
                            <!--                                        @endif-->
                            <!--                                        @endforeach-->
                        </div>
                    </div>
                </div>
                <div
                    v-for="(part, partIndex) in sheet.parts"
                    :key="part.id"
                    class="grid grid-cols-2 text-xs space-x-4 py-2"
                    :class="partIndex === sheet.parts.length - 1 ? '' : 'border-b border-gray-700'"
                >
                    <div>
                        <div>
                            <strong>{{ part.name }}</strong>
                        </div>
                        <div>
                            <span v-html='part.description?.replace("\n", "<br/>")'></span>
                        </div>
                        <div v-for="(sequence, index) in part.sequences" :key="index">
                            <div v-if="sequence.description">
                                <div :class="index === 0 && !part.description ? 'mt-0' : 'mt-1' ">
                                    <span class="italic">{{ index + 1 }} . Akkordfolge: </span>
                                    <span v-html='sequence.description?.replace("\n", "<br/>")'></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div>
                        <div v-for="sequence in part.sequences" class="flex">
                            <div class="w-4 pr-6">
                                <strong>{{ sequence.quantity }}x</strong>
                            </div>
                            <div class="flex flex-wrap">
                                <div v-for="(measure, measureIndex) in sequence.measures" class="inline-flex">
                                    <div class="inline-flex whitespace-nowrap">
                                        <div class="">{{ measure.chords }}</div>
                                        <div class="mx-1" v-if="measureIndex !== sequence.measures.length - 1">|</div>
                                    </div>
                                </div>
                            </div>
                            <!--                                        @foreach($sequence->measures as $measure)-->
                            <!--                                        @php-->
                            <!--                                        $sup = ['b', '#', 1, 2, 3, 4, 5, 6, 7, 8, 9, 'add', '+', '°', 'maj', 'dim', '(sus)', '(', ')'];-->
                            <!--                                        $sub = ['sus'];-->
                            <!--                                        $chords = $measure['chords'];-->
                            <!--                                        foreach ($sup as $key) {-->
                            <!--                                        $chords = str_replace($key, '<sup>'. $key .'</sup>', $chords);-->
                            <!--                                        }-->
                            <!--                                        foreach ($sub as $key) {-->
                            <!--                                        $chords = str_replace($key, '<span class="custom-sub">'. $key .'</span>', $chords);-->
                            <!--                                        }-->
                            <!--                                        $chords = str_replace('H', 'B', $chords);-->
                            <!--                                        $chords = str_replace('_', ' ', $chords);-->
                            <!--                                        $chords = str_replace('-', '&mdash;', $chords);-->
                            <!--                                        @endphp-->
                            <!--                                        <span>{!! $chords !!}</span>-->
                            <!--                                        @if (!$loop->last)-->
                            <!--                                        <span style="padding: 0 1px;">|</span>-->
                            <!--                                        @endif-->
                            <!--                                        @endforeach-->
                        </div>
                    </div>
                </div>
            </div>

            <div class="px-8 fixed w-full max-w-3xl bg-gray-100 bottom-0">
                <div class="py-2 border-gray-800 border-t flex justify-between">
                    <div class="text-xs">{{moment(sheet.created_at).format('DD.MM.YYYY')}}</div>
                    <div class="text-xs">{{ sheet.user.name }}</div>
                </div>
            </div>
        </div>
    </div>
</template>
