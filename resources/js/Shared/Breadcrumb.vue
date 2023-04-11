<template>
    <nav aria-label="breadcrumb" style="--bs-breadcrumb-divider: '';" class="my-4">
        <ol class="breadcrumb">
            <li class="breadcrumb-item badge" :class="{ 'active': index === (breadcrumbs.length - 1) }" v-for="(breadcrumb, index) in breadcrumbs" :aria-current="index === (breadcrumbs.length - 1) ? 'page' : null">
                <Link class="text-decoration-none text-black" v-if="index !== (breadcrumbs.length - 1)" :href="breadcrumb.url">{{ breadcrumb.title }}</Link>
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
    }
}
</script>

<style scoped>

</style>
