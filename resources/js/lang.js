import { usePage } from '@inertiajs/vue3'
const page = usePage()

export default function __ (key, replacements = {}) {
    let translation = usePage().props.translations[key] || key

    Object.keys(replacements).forEach(replacement => {
        translation = translation.replace(`:${replacement}`, replacements[replacement])
    })

    return translation
}
