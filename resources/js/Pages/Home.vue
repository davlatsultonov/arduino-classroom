<template>
    <Head>
        <title>Home Page</title>
    </Head>
    <div class="row gx-5">
        <div class="col-lg-8">
            <CardGroup v-for="(category, key) in articles" :title="key" :cards="category" :cards-in-row="3"/>
        </div>
        <div class="col-lg-4">
            <CardGroup :cards="articles['Платы']" title="Top" :cards-in-row="1"/>
        </div>
    </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";
import CardGroup from "../Shared/Card/CardGroup.vue";

export default {
    components: {CardGroup, Navbar, Head, Link},
    props: {
        articles: Array
    }
}
</script>
