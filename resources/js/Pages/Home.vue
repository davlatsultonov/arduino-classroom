<template>
    <Head>
        <title>Home Page</title>
    </Head>

   <div class="container">
       <Navbar :categories="categories"/>
        <CardGroup :cards="articles" />
   </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";
import CardGroup from "../Shared/Card/CardGroup.vue";

export default {
    components: {CardGroup, Navbar, Head, Link},
    props: {
        categories: Array,
        articles: Array
    }
}
</script>
