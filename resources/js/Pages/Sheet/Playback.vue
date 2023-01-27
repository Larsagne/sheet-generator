<script>

import BaseLayout from "@/Layouts/BaseLayout.vue";
import {Synth} from "tone";
import {Chord, Note } from "tonal";
// import {Howler, howl} from "howler";
// import {OpenSheetMusicDisplay} from "opensheetmusicdisplay";

export default {
    components: {
        BaseLayout
    },
    props: {
        sheet: Object,
    },
    data() {
        return {
            activePart: null,
            activeSequence: null,
            sound: null,
            soundEngine: null,
            completeChordProgression: [],
            nextChord: 0,
            clock: 0,
            audio: null,
            click: null
        }
    },
    mounted() {
        this.getCompleteChordProgression();

        let me = this;
        this.sound = new Howl({
            src: ['/storage/pianosprite.mp3'],
            onload () {
                me.setStripes()
            }
        });


        let osmd = new OpenSheetMusicDisplay("osmdContainer");
        osmd.setOptions({
            backend: "svg",
            drawTitle: true,
            // drawingParameters: "compacttight" // don't display title, composer etc., smaller margins
        });
        osmd
        .load("https://downloads2.makemusic.com/musicxml/MozaVeilSample.xml")
        .then(
            function() {
                osmd.render();
            }
        );

    },
    methods: {
        start() {
            let me = this;
            this.audio = setInterval(function() {
                if (me.completeChordProgression[me.nextChord].startAt === me.clock) {
                    me.play(me.completeChordProgression[me.nextChord].chord)
                    me.nextChord++;
                }

                me.clock++;
                console.log('Clock')
            }, 1 / (this.sheet.tempo / 60) * 1000);
        },
        stop() {
            clearInterval(this.audio);
        },
        play(chord) {
            chord = Chord.get(chord);
            const notes = chord.notes.map(note => note + '3');
            const chordMidiNumbers = notes.map(noteName => {
                return Note.get(noteName).midi;
            });
            this.sound.volume(0.5);

            chordMidiNumbers.forEach(noteMidiNumber => {
                this.sound.play(noteMidiNumber.toString());
            });
        },
        setStripes() {
            const lengthOfNote = 2400;
            let timeIndex = 0;
            for (let i = 24; i <= 96; i++) {
                this.sound['_sprite'][i] = [timeIndex, lengthOfNote];
                timeIndex += lengthOfNote;
            }
        },
        getCompleteChordProgression() {
            let me = this;
            let startAt = 0;

            this.sheet.parts.forEach(part => {
                part.sequences.forEach(sequence => {
                    let quantity = sequence.quantity;

                    for (let i = 1; i <= quantity; i++) {
                        sequence.measures.forEach(measure => {
                            let chords = measure.chords.split('-');
                            let chordsLength = chords.length;
                            let timeSignatureParts = measure.time_signature.split('/');

                            chords.forEach(chord => {
                                let numerator = parseInt(timeSignatureParts[0]) / chordsLength;
                                me.completeChordProgression.push({
                                    chord: chord,
                                    numerator: numerator,
                                    denominator: parseInt(timeSignatureParts[1]),
                                    startAt: startAt,
                                    chordsInThisMeasure: chordsLength,
                                    completeMeasure: measure.chords
                                })

                                startAt += numerator;
                            })
                        })
                    }
                })
            })

            console.log('Sequences', this.completeChordProgression);
        }
    }
}
</script>


<template>
    <BaseLayout>
        <template #title>
            <div class="grid grid-cols-2 gap-x-4">
                <div>
                    <span>Sheet Playback</span>
                </div>
                <div class="flex justify-end">
                    <button type="button"
                            @click="$inertia.get(this.route('sheet.index'))"
                            class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-300 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-2">
                        Abbrechen
                    </button>
                </div>
            </div>
        </template>
        <template #header>
            header

        </template>

        <h1>Playback</h1>
        <button class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-300 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-2" type="button"
                @click="start()">Start</button>
        <button class="inline-flex items-center rounded-md border border-gray-300 px-4 py-2 text-sm font-medium text-gray-300 shadow-sm hover:bg-gray-50 hover:text-gray-900 focus:outline-none focus:ring-2 focus:ring-indigo-500 focus:ring-offset-2 mr-2" type="button"
                @click="stop()">Stop</button>

        <h1>Test</h1>
        <div id="osmdContainer"></div>
    </BaseLayout>
</template>
