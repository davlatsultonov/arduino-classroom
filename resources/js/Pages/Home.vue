<template>
    <Head>
        <title>Home Page</title>
    </Head>
    <CardGroup :cards="articles" />
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
