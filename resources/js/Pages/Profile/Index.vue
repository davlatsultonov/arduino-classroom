<template>
    <div class="py-4">
        <h2 class="fw-bold mb-5">Омӯзиши ман</h2>

        <div id="welcome-block" class="border rounded-4 py-5 px-4">
            <div class="row position-relative">
                <div class="col-7">
                    <h3 class="mb-4">
                        Салом, {{ stringUpperFirstLetter(name) }}
                    </h3>
                    <p>
                        Хуш омадед ба саҳифаи "Омӯзиши ман".
                        Ин маркази шумо барои ҳама дарсҳои пешниҳодкардаи мо ва пешрафти омӯзиши шумо хоҳад буд.
                    </p>

                    <p>Мо умедворем, ки шумо бо мо омӯхтанро идома медиҳед.</p>

                    <ResultCard class="position-absolute"
                                :total-points-count="totalPointsCount"
                                :current-points-count="currentPointsCount"
                    />
                </div>
            </div>
        </div>

        <ProgressListRow :list="$page.props.shared.auth.solved_tests" />


    </div>
</template>

<script>
import {Link, useForm} from "@inertiajs/inertia-vue3";
import CircleProgress from "../../Shared/CircleProgress.vue";
import ResultCard from "./ResultCard.vue";
import ProgressListRow from "./ProgressBlock/ProgressListRow.vue";
import utilitiesMixin from "../../mixins/utilities-mixin";

export default {
    name: "Index",
    components: {ProgressListRow, ResultCard, CircleProgress, Link},
    props: ['name', 'totalPointsCount', 'currentPointsCount'],
    mixins: [utilitiesMixin],
    data() {
        return {
            form: useForm({}),
        }
    },
    methods: {
        submit() {
            this.form.delete('/logout');
        }
    }
}
</script>

<style scoped lang="scss">
    #welcome-block {
        margin-bottom: 150px;
    }

    .card.result-card {
        right: 35px;
        width: 350px;
        top: -110px;
    }

    .card-points h5 {
        line-height: .95;
    }
</style>
