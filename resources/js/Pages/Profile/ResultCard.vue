<template>
    <div class="card result-card shadow p-2 rounded-4">
        <div class="card-body">
            <div v-if="currentPointsCount">
                <h5 class="card-title mb-2 text-center">Офарин!</h5>
                <div class="text-center">
                    <small>холи шумо</small>
                </div>
            </div>
            <h5 class="card-title mb-2 text-center" v-else>Холи шумо</h5>

            <div class="mt-4 mb-4">
                <CircleProgress :percentage="getPercentage" :size="150"/>
            </div>
            <small class="d-inline-block mb-3 ms-3">Омилҳои холӣ</small>
            <div class="row gx-2">
                <div class="col-6">
                    <div class="card result-card__inner-card rounded-3">
                        <div class="card-body py-2 px-3">
                            <div class="card-title fw-bold mb-0">{{
                                    this.$page.props.shared.auth.read_articles.length
                                }}
                            </div>
                            <small>дарсхои хонда</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card rounded-3">
                        <div class="card-body py-2 px-3">
                            <div class="card-title fw-bold mb-0">{{
                                    this.$page.props.shared.auth.solved_tests.length
                                }}
                            </div>
                            <small>санҷишҳо</small>
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
        getPercentage: function () {
            if (this.totalPointsCount <= 0) return 0;

            return (this.currentPointsCount / this.totalPointsCount) * 100
        }
    }
}
</script>

<style scoped>

</style>
