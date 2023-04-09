<template>
    <div>
        Profile Page, {{ name }}

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
