<template>
    <slot/>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    components: {Link},
    methods: {
        logout() {
            this.$inertia.delete(route('logout'))
        }
    }
}
</script>
