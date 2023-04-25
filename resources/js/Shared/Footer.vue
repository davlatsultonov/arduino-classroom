<template>
    <div class="footer">
<!--        <div class="container">
            <div class="row py-4 align-items-center">
                <div class="col-4">
                    <Logo dark-theme />
                </div>
                <div class="col-8">
                    <p>
                        О НАС
                    </p>
                    <p>
                        ArduinoClassroom.tj - сайт для тех, кто использует в своих DIY проектах микроконтроллеры и ардуино. Перепечатка материалов возможна только с согласия авторов.
                    </p>
                    <p class="mb-0">
                        Свяжитесь с нами: info@arduinoclassroom.tj
                    </p>
                </div>
            </div>
        </div>-->

        <div class="footer-copyright text-center text-white py-3">
            <div class="container">
                © ArduinoClassroom.tj, 2023 -
            </div>
        </div>
    </div>
</template>

<script>
import Logo from "./Logo.vue";

export default {
    name: "Footer",
    components: {Logo}
}
</script>

<style scoped>

</style>
