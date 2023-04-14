<template>
    <div>
        <h2 class="fw-bold mb-5">My learning</h2>

        <div id="welcome-block" class="border rounded-4 py-5 px-4">
            <div class="row position-relative">
                <div class="col-7">
                    <h3 class="mb-4">
                        Hi, {{ userName }}
                    </h3>
                    <p>
                        Welcome to the new "My learning" here at W3schools. This will be your hub to all the tutorials we offer and your learning progress.
                    </p>

                    <p>We hope you will continue to learn with us.</p>

                    <ResultCard class="position-absolute"
                                :total-points-count="totalPointsCount"
                                :current-points-count="currentPointsCount"
                    />
                </div>
            </div>
        </div>

        <ProgressListRow v-if="$page.props.auth.solved_tests.length" :list="$page.props.auth.solved_tests" />


    </div>
</template>

<script>
import {Link, useForm} from "@inertiajs/inertia-vue3";
import CircleProgress from "../../Shared/CircleProgress.vue";
import ResultCard from "./ResultCard.vue";
import ProgressListRow from "./ProgressBlock/ProgressListRow.vue";
export default {
    name: "Index",
    components: {ProgressListRow, ResultCard, CircleProgress, Link},
    props: ['name', 'totalPointsCount', 'currentPointsCount'],
    data() {
        return {
            form: useForm({}),
        }
    },
    computed: {
        userName: function () {
            return this.name[0].toUpperCase() + this.name.slice(1)
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
