<template>
    <Head>
        <title>Articles list</title>
    </Head>
    <Breadcrumb :breadcrumbs="breadcrumbs.breadcrumbs" />
    <div class="row">
        <div class="col-lg-8">
            <CardGroup v-if="articles.length" :cards="articles" :horizontal="true" :cards-in-row="1"/>
            <div class="mt-3 text-center" v-else>
                No data.
            </div>
        </div>
        <div class="col-lg-4">
            <CardGroup :cards="topArticles" title="Top" :cards-in-row="1"/>
        </div>
    </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import CardGroup from "../../Shared/Card/CardGroup.vue";
import Breadcrumb from "../../Shared/Breadcrumb.vue";
export default {
    components: {Breadcrumb, Head, Link, CardGroup},
    props: ['articles', 'breadcrumbs', 'topArticles']
}
</script>
