<template>
    <div class="container-fluid">
        <Navbar/>
        <div :class="`container mt-${hasMoreMargin ? '5' : '4'}`">
            <slot/>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";

export default {
    components: {Link, Navbar},
    computed: {
        hasMoreMargin() {
            const routes = ['Home', 'Profile/Index'];

            return routes.indexOf(this.$page.component) !== -1;
        }
    },
    methods: {
        logout() {
            this.$inertia.delete(route('logout'))
        }
    }
}
</script>
