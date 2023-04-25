<template>
    <Show :article="currentTutorial" :tutorials="tutorials"/>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import TutorialLayout from "../Layouts/TutorialLayout.vue";
import Show from "./Articles/Show.vue";
export default {
    name: "Tutorial",
    components: {Show, Link},
    layout: TutorialLayout,
    props: ['currentTutorial', 'tutorials'],
}
</script>
