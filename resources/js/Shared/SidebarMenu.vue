<template>
    <ul class="list-group rounded-0 sidebar">
        <li class="list-group-item p-0 border-0" v-for="({slug, name}, index) in tutorials">
            <Link class="list-group-item list-group-item-action" :class="{
                'border-top-0': index !== 0
            }" :href="'/tutorial/' + slug">{{ name }}</Link>
        </li>
    </ul>
</template>

<script>
import { Link } from '@inertiajs/inertia-vue3';
export default {
    name: "SidebarMenu",
    components: {Link},
    props: ['tutorials']
}
</script>

<style scoped>

</style>
