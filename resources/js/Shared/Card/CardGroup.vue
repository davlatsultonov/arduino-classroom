<template>
    <div class="cards-group">
        <div :class="['card-group-title d-flex fw-semibold mb-4', {
            'mt-4 ': type !== 'top'
        }]" v-if="title">
            <span>{{ title }}</span>
        </div>
        <div :class="`row row-cols-1 row-cols-md-2 row-cols-lg-${cardsInRow} gy-${horizontal ? 4 : 2} mb-2 card-group`">
            <div v-for="(card, index) in cards" class="col">
                <Card :card="card" :horizontal="horizontal" :class="[ `mb-${index === cards.length - 1 ? 0 : 3}` ]" :hide-body="type === 'top'"/>
            </div>
        </div>
    </div>
</template>

<script>
import Card from "./Card.vue";

export default {
    name: "CardGroup",
    components: {Card},
    props: {
        cards: Array,
        cardsInRow: Number,
        horizontal: {
            type: Boolean,
            default() {
                return false
            }
        },
        title: {
            type: String,
            default() {
                return '';
            }
        },
        type: {
            type: String,
            default() {
                return ''
            }
        }
    }
}
</script>

<style scoped lang="scss">
.card-group-title {
    border-bottom: 2px solid #f47a20;

    span {
        display: inline-block;
        background-color: #f47a20;
        color: #fff;
        font-size: 14px;
        line-height: 17px;
        padding: 7px 12px 4px;
    }
}
</style>
