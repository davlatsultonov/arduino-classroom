<template>
    <Show :article="currentTutorial" :tutorials="$page.props.shared.tutorials"/>
    <Teleport to="body">
        <TutorialMap/>
    </Teleport>
</template>

<script>
// TODO check if views counter working in tutorial page

import {Link} from "@inertiajs/inertia-vue3";
import TutorialLayout from "../../Layouts/TutorialLayout.vue";
import Show from "../Articles/Show.vue";
import TutorialMap from "./TutorialMap.vue";
export default {
    name: "Tutorial",
    components: {TutorialMap, Show, Link},
    layout: TutorialLayout,
    props: ['currentTutorial']
}
</script>
