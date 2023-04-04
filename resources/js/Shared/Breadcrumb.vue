<template>
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item" v-for="(breadcrumb, index) in breadcrumbs" :class="{ 'active':index === (breadcrumbs.length - 1) }" :aria-current="index === (breadcrumbs.length - 1) ? 'page' : null">
                <Link v-if="index !== (breadcrumbs.length - 1)" :href="breadcrumb.url">{{ breadcrumb.title }}</Link>
                <span v-else>{{ breadcrumb.title }}</span>
            </li>
        </ol>
    </nav>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "Breadcrumb",
    components: {Link},
    props: {
        breadcrumbs: {
            type: Array,
            required: true,
        },
    },
}
</script>

<style scoped>

</style>
