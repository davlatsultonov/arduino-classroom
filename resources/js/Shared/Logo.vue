<template>
    <Link class="text-decoration-none fs-4" :class="{ 'text-white': darkTheme }" href="/">Arduino<span class="d-block d-sm-inline"><b>CLASSROOM</b></span></Link>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "Logo",
    components: {Link},
    props: {
        darkTheme: Boolean,
    }
}
</script>

<style scoped>

</style>
