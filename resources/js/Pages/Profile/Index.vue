<template>
    <div>
        Profile Page, {{ name }}

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
export default {
    name: "Index",
    components: {Link},
    props: ['name'],
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

<style scoped>

</style>
