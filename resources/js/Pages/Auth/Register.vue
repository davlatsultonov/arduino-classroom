<template>
    <Head>
        <title>Регистрация</title>
    </Head>

    <Link :href="route('home')" class="btn btn-outline-secondary text-decoration-none text-black d-inline-flex align-items-center py-1">
        <img src="/images/arrow_left_single.svg" alt="icon arrow left" width="23" class="me-1">
        Home</Link>
    <h1 class="my-5 text-center">Регистрация</h1>
    <form @submit.prevent="submit">
        <div class="mb-3">
            <label for="login-name" class="form-label">Name</label>
            <input type="text" name="name" v-model="form.name" class="form-control" :class="{
                'is-invalid': form.errors.name
            }" id="login-name">
            <div class="invalid-feedback" v-if="form.errors.name">
                {{ form.errors.name }}
            </div>
        </div>
        <div class="mb-3">
            <label for="login-email" class="form-label">Email address</label>
            <input type="email" name="email" v-model="form.email" class="form-control" :class="{
                'is-invalid': form.errors.email
            }" id="login-email" aria-describedby="emailHelp">
            <div class="invalid-feedback" v-if="form.errors.email">
                {{ form.errors.email }}
            </div>
        </div>
        <div class="mb-4">
            <label for="login-password" class="form-label">Password</label>
            <input type="password" name="password" v-model="form.password" class="form-control" :class="{
                'is-invalid': form.errors.password
            }" id="login-password">
            <div class="invalid-feedback" v-if="form.errors.password">
                {{ form.errors.password }}
            </div>
        </div>
        <div class="mb-4">
            <label for="login-password-confirmation" class="form-label">Confirm password</label>
            <input type="password" name="password_confirmation"  v-model="form.password_confirmation" class="form-control" id="login-password-confirmation">
        </div>
        <button type="submit" class="btn btn-primary btn w-100">Зарегистрироваться</button>
        <div class="text-center mt-4">
            <Link :href="route('login.create')" class="btn btn-link">Войти</Link>
        </div>
    </form>
</template>

<script>
import AuthLayout from "../../Layouts/AuthLayout.vue"
import {Head, useForm, Link} from "@inertiajs/inertia-vue3";

export default {
    layout: AuthLayout,
    components: {Head, Link},
    data() {
        return {
            form: useForm({
                name: process.env.NODE_ENV === 'development' ? 'Test1' : null,
                email: process.env.NODE_ENV === 'development' ? 'test1@mail.com' : null,
                password: process.env.NODE_ENV === 'development' ? 'test11' : null,
                password_confirmation: process.env.NODE_ENV === 'development' ? 'test11' : null
            }),
        }
    },
    methods: {
        /**
         * Отправляет данные формы регистрации на сервер.
         */
        submit() {
            this.form.post('/register');
        }
    }
}
</script>
