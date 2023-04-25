<template>
    <Show :article="currentTutorial" :tutorials="tutorials"/>
    <Teleport to="body">
        <TutorialMap :tutorials="tutorials"/>
    </Teleport>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import TutorialLayout from "../../Layouts/TutorialLayout.vue";
import Show from "../Articles/Show.vue";
import TutorialMap from "./TutorialMap.vue";
export default {
    name: "Tutorial",
    components: {TutorialMap, Show, Link},
    layout: TutorialLayout,
    props: ['currentTutorial', 'tutorials'],
}
</script>
