<template>
    <nav class="navbar navbar-expand-lg ac-navbar">
        <div class="container-fluid">
            <Logo class="navbar-brand me-0" />
            <ul class="navbar-nav ps-0 ps-sm-3 flex-row">
                <li class="nav-item">
                    <Link
                        class="nav-link px-2" :href="route(isAuth ? 'profile.index' : 'login.create')">
                        <img
                            :data-bs-title="isAuth ? 'Профил' : 'Воридшавӣ'"
                            data-bs-placement="bottom"
                            @click="handleTooltipDispose"
                            data-bs-toggle="tooltip"
                            data-bs-custom-class="custom-tooltip"
                            data-bs-offset="0,8"
                            width="25" :src="'/images/' + (isAuth ? 'auth-stub.svg' : 'sign_in.svg')" :alt="'icon' + (isAuth ? 'auth' : 'sign in')">
                    </Link>
                </li>
                <li class="nav-item" v-if="isAuth">
                    <form @submit.prevent="submit" class="nav-link px-2" style="margin-top: -2px;">
                        <button type="submit" class="btn btn-link p-0"
                                data-bs-title="Баромад"
                                data-bs-placement="bottom"
                                @click="handleTooltipDispose"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-toggle="tooltip"
                                data-bs-offset="0,8"
                        >
                            <img src="/images/sign_out.svg" width="25" alt="icon sing out">
                        </button>
                    </form>
                </li>
            </ul>
        </div>
    </nav>
</template>

<script>
import {Link, useForm} from "@inertiajs/inertia-vue3";
import Logo from "./Logo.vue";
import tooltipMixin from "../mixins/tooltip-mixin";

export default {
    name: "Navbar",
    components: {Logo, Link},
    mixins: [tooltipMixin],
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
        // Отправляет запрос на выход пользователя
        submit() {
            // Вызываем метод delete() на объекте form с указанием пути '/logout'
            this.form.delete('/logout');
        }
    }
}
</script>
