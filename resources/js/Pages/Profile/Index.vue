<template>
    <div>
        <h2 class="fw-bold mb-5">My learning</h2>

        <div class="border rounded-4 p-5">
            <div class="row position-relative">
                <div class="col-7">
                    <h3 class="mb-4">
                        Hi, {{ userName }}
                    </h3>
                    <p>
                        Welcome to the new "My learning" here at W3schools. This will be your hub to all the tutorials we offer and your learning progress.
                    </p>

                    <p>We hope you will continue to learn with us.</p>

                    <div class="card position-absolute result-card shadow p-2 rounded-4">
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
                </div>
            </div>
        </div>

        <div class="row my-4" v-if="$page.props.auth.solved_tests.length">
            <h4>Solved tests:</h4>
            <div class="col-3">
                <ul class="list-group">
                    <li class="list-group-item" v-for="item in $page.props.auth.solved_tests">
                        {{ item }}
                    </li>
                </ul>
            </div>
        </div>

        <div class="mt-4">
            <Link :href="route('profile.test.index')" class="btn btn-outline-dark">Test Myself</Link>
        </div>
    </div>
</template>

<script>
import {Link, useForm} from "@inertiajs/inertia-vue3";
import CircleProgress from "./CircleProgress.vue";
export default {
    name: "Index",
    components: {CircleProgress, Link},
    props: ['name'],
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
    .card.result-card {
        right: 35px;
        width: 350px;
        top: -110px;
    }

    .card-points h5 {
        line-height: .95;
    }
</style>
