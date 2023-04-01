<template>
    <Head>
        <title>Article</title>
    </Head>

    <h1>{{ article.name }}</h1>
    <h2>{{newImgUrl}}</h2>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";

export default {
    components: {Head, Link},
    props: ['article', 'newImgUrl']
}
</script>
