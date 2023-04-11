<template>
    <div class="card border-0" v-if="horizontal">
        <div class="row g-3">
            <div class="col-md-4">
                <CardImage class="img-fluid w-100 h-100 position-relative rounded-end rounded-top" :image="card.image">
                    <Link :href="card.category_slug"
                          class="badge text-bg-dark rounded-0 position-absolute bottom-0 start-0 text-decoration-none">
                        {{ badgeText }}
                    </Link>
                </CardImage>
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <Link :href="`/${card.category_slug}/` + card.slug" as="h5"
                          class="card-title mb-3 text-truncate">
                        {{ card.name }}
                    </Link>
                    <p class="card-text card-description">{{ card.description }}</p>
                    <p class="card-text"><small class="text-muted">Last updated {{ formattedTime }}</small></p>
                </div>
            </div>
        </div>
    </div>
    <div class="card border-0 mb-3" v-else>
        <CardImage class="img-fluid position-relative rounded-end rounded-top" :image="card.image" image-height="200">
            <Link :href="card.category_slug"
                  class="badge text-bg-dark rounded-0 position-absolute bottom-0 start-0 text-decoration-none">
                {{ badgeText }}
            </Link>
        </CardImage>
        <div class="card-body">
            <Link :href="`/${card.category_slug}/` + card.slug" as="h5"
                  class="card-title mb-3 text-truncate">
                {{ card.name }}
            </Link>
            <p class="card-text card-description">{{ card.description }}</p>
            <p class="card-text"><small class="text-muted">Last updated {{ formattedTime }}</small></p>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import moment from 'moment';
import CardImage from "./CardImage.vue";

export default {
    name: "Card",
    components: {CardImage, Link},
    props: {
        card: Object,
        horizontal: Boolean
    },
    computed: {
        formattedTime() {
            return moment(this.card.updated_at).fromNow();
        },
        badgeText() {
            return this.card.category_name
        },
        cardImage() {
            let img = this.card.image;

            img = !img ? '/images/photo_placement_wide.jpg' : '/storage/' + img;

            return img;
        },
        cardImageStyles() {
            return {
                backgroundImage: `url('${this.cardImage}')`,
                backgroundSize: 'cover',
                backgroundPosition: 'center',
                backgroundRepeat: 'no-repeat'
            };
        }
    }
}
</script>

<style scoped lang="scss">
.card {

    &-title {
        cursor: pointer;
        color: #f47a20;
    }

    &-body {
        padding: var(--bs-card-spacer-y) 0;
    }

    &-text {
        color: #777;
    }

    &-description {
        overflow: hidden;
        text-overflow: ellipsis;
        display: -webkit-box;
        -webkit-line-clamp: 3;
        -webkit-box-orient: vertical;
    }
}
</style>
