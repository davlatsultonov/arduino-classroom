<template>
    <Link :href="categorySlug"
          class="badge ms-2 mb-2 position-absolute bottom-0 start-0 text-decoration-none">
        {{ badgeText }}
    </Link>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "CardTag",
    components: {Link},
    props: ['categorySlug', 'badgeText']
}
</script>
