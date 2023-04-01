<template>
    <div class="container">
        <Navbar :categories="categories"/>
        <slot/>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";
export default {
    components: {Link, Navbar},
    props: {
        categories: Array
    },
    methods: {
        logout() {
            this.$inertia.delete(route('logout'))
        }
    }
}
</script>
