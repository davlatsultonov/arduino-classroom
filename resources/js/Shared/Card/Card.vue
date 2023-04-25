<template>
    <div
        class="card ac-card border-0"
        :class="{'border-bottom rounded-0': hideBody}"
    >
        <div class="row g-3" v-if="horizontal">
            <div class="col-md-3">
                <CardImage class="img-fluid w-100 h-100 position-relative rounded" :image="card.image">
                    <CardTag :category-slug="card.category.slug" :badge-text="badgeText" />
                    <CardView v-if="card.views" :views="card.views" />
                </CardImage>
            </div>
            <div class="col-md-9">
                <CardBody
                    class="py-0"
                    :hide-body="hideBody"
                    :card="card"
                />
            </div>
        </div>
        <template v-else>
            <CardImage class="img-fluid position-relative rounded" :image="card.image" :image-height="hideBody ? 160 : 200">
                <CardTag :category-slug="card.category.slug" :badge-text="badgeText" />
                <CardView v-if="card.views" :views="card.views" />
            </CardImage>
            <CardBody
                :hide-body="hideBody"
                :card="card"
            />
        </template>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import CardImage from "./CardImage.vue";
import CardView from "./CardView.vue";
import CardTag from "./CardTag.vue";
import CardBody from "./CardBody.vue";

export default {
    name: "Card",
    components: {CardBody, CardTag, CardView, CardImage, Link},
    props: {
        card: Object,
        horizontal: Boolean,
        hideBody: Boolean
    },
    computed: {
        badgeText() {
            return this.card.category.name
        },
    }
}
</script>

<style lang="scss">
.ac-card {

    .badge {
        background-color: #00979d !important;

    }

    a.badge:hover {
        color: #fff;
    }
}
</style>
