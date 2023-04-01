<template>
    <div class="card">
        <div class="row g-0">
            <div class="col-md-4">
                <img :src="cardImage" class="img-fluid rounded-start" :alt="card.title">
            </div>
            <div class="col-md-8">
                <div class="card-body">
                    <div class="card-title mb-3 text-truncate">
                        <Link :href="`/${card.category_slug}/` + card.slug">
                            {{ card.name }}
                        </Link>
                    </div>
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

</style>
