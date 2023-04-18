<template>
    <nav class="navbar navbar-expand-lg ac-navbar mb-4">
        <div class="container">
            <Logo class="navbar-brand" />
            <button class="navbar-toggler ms-auto" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <ul class="navbar-nav ps-3 flex-row order-lg-1">
                <li>
                    <Link class="nav-link px-2" :href="route(isAuth ? 'profile.index' : 'login')">
                        <img  width="25" :src="'/images/' + (isAuth ? 'auth-stub.svg' : 'sign_in.svg')" :alt="'icon' + (isAuth ? 'auth' : 'sign in')">
                    </Link>
                </li>
                <li v-if="isAuth">
                    <form @submit.prevent="submit" class="nav-link px-2">
                        <button type="submit" class="btn btn-link p-0">
                            <img src="/images/sign_out.svg" width="23" alt="icon sing out">
                        </button>
                    </form>
                </li>
            </ul>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mt-4 mt-lg-0">
                    <li :class="['nav-item', { 'active': $page.url.startsWith('/' + slug) }]" v-for="{id, name, slug} in this.$page.props.shared.categories" :key="id">
                        <Link class="nav-link px-3" aria-current="page" :href="'/' + slug">{{ name }}</Link>
                    </li>
                </ul>
            </div>
        </div>
    </nav>
</template>

<script>
import {Link, useForm} from "@inertiajs/inertia-vue3";
import Logo from "./Logo.vue";

export default {
    name: "Navbar",
    components: {Logo, Link},
    computed: {
        isAuth() {
            return this.$page.props.shared.auth;
        }
    },
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
