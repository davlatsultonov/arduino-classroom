<template>
    <Head>
        <title>Articles list</title>
    </Head>
    <div class="container">
        <CardGroup v-if="articles.length" :cards="articles" />
        <div class="mt-3 text-center" v-else>
            No data.
        </div>
    </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import CardGroup from "../../Shared/Card/CardGroup.vue";
export default {
    components: {Head, Link, CardGroup},
    props: ['articles']
}
</script>
