<template>
    <div class="card-body" :class="{ 'pb-1': hideBody }">
        <Link :href="`/${card.category.slug}/` + card.slug" as="h5"
              class="card-title text-truncate"
              :class="{ 'mb-3': !hideBody }"
        >
            {{ card.name }}
        </Link>
        <template v-if="!hideBody">
            <p class="card-text card-description">{{ card.description }}</p>
            <p class="card-text"><small class="text-muted">Охирин навсозӣ {{ formattedUpdateTime }}</small></p>
        </template>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import moment from 'moment/min/moment-with-locales';

export default {
    name: "CardBody",
    props: ['card', 'hideBody'],
    components: {Link},
    computed: {
        // Возвращает отформатированное время обновления
        formattedUpdateTime() {
            moment.locale('tg');
            return moment(this.card.updated_at).fromNow();
        }
    }
}
</script>

<style scoped lang="scss">
.ac-card {
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
}

</style>
