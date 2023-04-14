<template>
    <div class="card result-card shadow p-2 rounded-4">
        <div class="card-body">
            <div v-if="currentPointsCount">
                <h5 class="card-title mb-2 text-center">Good job!</h5>
                <div class="text-center">
                    <small>your score</small>
                </div>
            </div>
            <h5 class="card-title mb-2 text-center" v-else>Your score</h5>

            <div class="mt-4 mb-4">
                <CircleProgress :percentage="getPercentage" :size="150" />
            </div>
            <small class="d-inline-block mb-3 ms-3">Score factors</small>
            <div class="row gx-2">
                <div class="col-6">
                    <div class="card result-card__inner-card rounded-3">
                        <div class="card-body py-2 px-3">
                            <div class="card-title fw-bold mb-0">{{ this.$page.props.auth.read_articles.length }}</div>
                            <small>lessons read</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card rounded-3">
                        <div class="card-body py-2 px-3">
                            <div class="card-title fw-bold mb-0">{{ this.$page.props.auth.solved_tests.length }}</div>
                            <small>quiz finished</small>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</template>

<script>
import CircleProgress from "../../Shared/CircleProgress.vue";

export default {
    name: "ResultCard",
    components: {CircleProgress},
    props: ['totalPointsCount', 'currentPointsCount'],
    computed: {
        getPercentage: function() {
           return (this.currentPointsCount / this.totalPointsCount) * 100
        }
    }
}
</script>

<style scoped>

</style>
