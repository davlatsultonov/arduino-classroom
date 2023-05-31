<template>
    <Head>
        <title>Авторизация</title>
    </Head>

    <Link :href="route('home')" class="btn btn-outline-light text-decoration-none text-black d-inline-flex border-dark align-items-center py-1">
        <img src="/images/arrow_left_single.svg" alt="icon arrow left" width="23" class="me-1">
        Cаҳифаи асосӣ </Link>
    <h1 class="my-5 text-center">Авторизатсия</h1>
    <form @submit.prevent="submit">
        <div class="mb-3">
            <label for="login-email" class="form-label">Суроғаи почтаи электронӣ</label>
            <input type="email" name="email" v-model="form.email" class="form-control" :class="{
                'is-invalid': form.errors.email
            }" id="login-email" aria-describedby="emailHelp">
            <div class="invalid-feedback" v-if="form.errors.email">
                {{ form.errors.email }}
            </div>
        </div>
        <div class="mb-4">
            <label for="login-password" class="form-label">Рамз</label>
            <input type="password" name="password" v-model="form.password" class="form-control" :class="{
                'is-invalid': form.errors.password
            }" id="login-password">
            <div class="invalid-feedback" v-if="form.errors.password">
                {{ form.errors.password }}
            </div>
        </div>
        <button type="submit" class="btn btn-light border-dark btn w-100">Воридшавӣ</button>
        <div class="text-center mt-4">
            <Link :href="route('register.create')" class="btn btn-link text-secondary">Бақайдгирӣ</Link>
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
                email: process.env.NODE_ENV === 'development' ? 'test@mail.com' : null,
                password: process.env.NODE_ENV === 'development' ? 'testtest' : null
            }),
        }
    },
    methods: {
        /**
         * Отправляет данные формы на сервер.
         */
        submit() {
            this.form.post('/login');
        }
    }
}
</script>
