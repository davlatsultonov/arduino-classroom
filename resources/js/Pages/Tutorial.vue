<template>
    <div>
        <Show :article="currentTutorial">
            <template v-slot:page-navigation-buttons>
                <div class="d-flex mb-4 justify-content-between">
                    <template v-for="{url, title} in tutorialLinks">
                        <Link v-if="url" :href="url" class="btn btn-outline-dark">
                            {{ title[0].toUpperCase() + title.slice(1) }}
                        </Link>
                    </template>
                </div>
            </template>
        </Show>
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
            const isFirst = indexOf === 0;

            return {
                prev: {
                    url: isFirst ? '/' : links[indexOf - 1],
                    title: isFirst ? 'Home' : 'Previous'
                },
                next: {
                    url: links[indexOf + 1] ? links[indexOf + 1] : links[0],
                    title: 'Next'
                }
            }
        },
    }
}
</script>
