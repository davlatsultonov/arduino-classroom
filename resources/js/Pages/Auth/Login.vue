<template>
    <Head>
        <title>Авторизация</title>
    </Head>

    <form @submit.prevent="submit">
        <div class="form-group field-loginform-email required" :class="{'has-error': form.errors.email}">
            <div class="wrapper-placeholder modal-input">
                <input type="text" id="email"
                       v-model="form.email"
                       class="input-custom dark-input placeholder-input"
                       name="email"/>

                <span><i><label class="control-label" for="email">E-mail</label></i></span>

                <p v-if="form.errors.email" >
                    {{ form.errors.email }}
                </p>
            </div>
        </div>
        <div class="form-group field-loginform-password" :class="{'has-error': form.errors.password}">
            <div class="wrapper-placeholder modal-input">
                <input type="password" id="password"
                       v-model="form.password"
                       class="input-custom dark-input placeholder-input"
                       name="password"/>

                <span><i><label class="control-label" for="password">Пароль</label></i></span>

                <p v-if="form.errors.password" >
                    {{ form.errors.password }}
                </p>
            </div>
        </div>
        <div class="line-btn-modal">
            <button type="submit" class="btn-brand">Войти</button>
        </div>
    </form>
</template>

<script>
import AuthLayout from "../../Layouts/AuthLayout.vue"
import {Head, useForm} from "@inertiajs/inertia-vue3";

export default {
    layout: AuthLayout,
    components: {Head},
    data() {
        return {
            form: useForm({
                email: process.env.NODE_ENV === 'development' ? 'test@mail.com' : null,
                password: process.env.NODE_ENV === 'development' ? 'testtest' : null
            }),
        }
    },
    methods: {
        submit() {
            this.form.post('/login');
        }
    }
}
</script>
