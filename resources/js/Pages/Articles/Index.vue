<template>
    <Head>
        <title>Articles list</title>
    </Head>
    <div class="row h-100">
        <div class="col-lg-9 pe-4 py-4">
            <Breadcrumb :breadcrumbs="breadcrumbs.breadcrumbs" />

            <CardGroup v-if="articles.length" :cards="articles" :horizontal="true" :cards-in-row="1"/>
            <div class="mt-3 text-center" v-else>
                No data.
            </div>
        </div>
        <div class="col-lg-3 ps-4 py-4 border-start">
            <CardGroup :cards="shared.topArticles"
                       title="Top"
                       type="top"
                       :cards-in-row="1"
            />
        </div>
    </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import CardGroup from "../../Shared/Card/CardGroup.vue";
import Breadcrumb from "../../Shared/Breadcrumb.vue";
export default {
    components: {Breadcrumb, Head, Link, CardGroup},
    props: ['articles', 'breadcrumbs', 'shared']
}
</script>
