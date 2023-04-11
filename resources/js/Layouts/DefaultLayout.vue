<template>
    <div class="container-fluid">
        <Navbar/>
        <div :class="`container mt-${$page.component === 'Home' ? '5' : '4'}`">
            <slot/>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";

export default {
    components: {Link, Navbar},
    methods: {
        logout() {
            this.$inertia.delete(route('logout'))
        }
    }
}
</script>
