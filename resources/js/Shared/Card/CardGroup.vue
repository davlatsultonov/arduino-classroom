<template>
    <div class="row row-cols-1 row-cols-md-2 g-4 my-2 card-group">
        <div v-for="card in cards" class="col">
            <Card :card="card"/>
        </div>
    </div>
</template>

<script>
import Card from "./Card.vue";

export default {
    name: "CardGroup",
    components: {Card},
    props: ['cards']
}
</script>
