<template>
    <div>
        <div class="d-flex mb-4" :class="setContentPosition">
            <template v-for="{url, title} in tutorialLinks">
                <Link v-if="url" :href="url" class="btn btn-outline-dark">
                    {{ title[0].toUpperCase() + title.slice(1) }}
                </Link>
            </template>
        </div>
        <Show :article="currentTutorial" />
    </div>
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
    computed: {
        tutorialLinks: function () {
            const links = this.tutorials.map(tutorial => tutorial.slug);
            const indexOf = links.indexOf(this.currentTutorial.slug);

            return {
                prev: {
                    url: links[indexOf - 1],
                    title: 'Previous'
                },
                next: {
                    url: links[indexOf + 1],
                    title: 'Next'
                }
            }
        },
        setContentPosition: function () {
            const { prev: { url: prevUrl }, next: { url: nextUrl } } = this.tutorialLinks;

            return 'justify-content-' + (prevUrl && !nextUrl ? 'start' :
                !prevUrl && nextUrl ? 'end' : 'between');
        }
    }
}
</script>
