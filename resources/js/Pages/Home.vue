<template>
    <Head>
        <title>Home Page</title>
    </Head>

   <div class="container">
       <Navbar :categories="categories"/>
   </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";

export default {
    components: {Navbar, Head, Link},
    props: {
        categories: Object
    }
}
</script>
