<template>
    <div class="card result-card shadow p-2 rounded-4">
        <div class="card-body">
            <h5 class="card-title mb-2 text-center">Good job!</h5>
            <div class="text-center">
                <small>your score</small>
            </div>
            <div class="mt-4 mb-4">
                <CircleProgress :percentage="19" :size="150" />
            </div>
            <small class="d-inline-block mb-3 ms-3">Score factors</small>
            <div class="row gx-2">
                <div class="col-6">
                    <div class="card result-card__inner-card rounded-3">
                        <div class="card-body py-2 px-3">
                            <div class="card-title fw-bold mb-0">2</div>
                            <small>lessons read</small>
                        </div>
                    </div>
                </div>
                <div class="col-6">
                    <div class="card rounded-3">
                        <div class="card-body py-2 px-3">
                            <div class="card-title fw-bold mb-0">2</div>
                            <small>quiz points</small>
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
    components: {CircleProgress}
}
</script>

<style scoped>

</style>
