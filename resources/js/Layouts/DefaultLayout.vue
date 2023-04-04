<template>
    <div class="container-fluid">
        <Navbar :categories="categories"/>
        <div class="container mt-5">
            <slot/>
        </div>
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
