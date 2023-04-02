<template>
    <div class="card">
        <div class="row g-0">
            <div class="col-md-3">
                <div
                    class="img-fluid w-100 h-100 rounded-start"
                    :style="{
                       backgroundImage: `url('${cardImage}')`,
                       backgroundSize: 'contain',
                       backgroundPosition: 'center'
                     }"></div>
            </div>
            <div class="col-md-9">
                <div class="card-body">
                    <Link :href="`/${card.category_slug}/` + card.slug" rel="preload" as="h5" class="card-title mb-3 text-truncate">
                        {{ card.name }}
                    </Link>
                    <p class="card-text text-truncate">{{ card.description }}</p>
                    <p class="card-text"><small class="text-muted">Last updated {{formattedTime}}</small></p>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import moment from 'moment';

export default {
    name: "Card",
    components: {Link},
    props: ['card'],
    computed: {
        formattedTime() {
            return moment(this.card.updated_at).fromNow();
        },
        cardImage() {
            let img = this.card.image;

            if (!img) img = 'photo_placement_wide.jpg'

            return 'storage/' + img;
        }
    }
}
</script>

<style scoped>
    .card-title {
        cursor: pointer;
    }
</style>
