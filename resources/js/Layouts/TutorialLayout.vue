<template>
    <BaseLayout>
        <template v-slot:container>
            <div class="row">
                <div class="col-3">
                    <SidebarMenu :tutorials="tutorials"/>
                </div>
                <div class="col-9">
                    <slot>Main content</slot>
                </div>
            </div>
        </template>

        <template v-slot:footer>
            <Footer class="mt-auto"/>
        </template>
    </BaseLayout>
</template>

<script>
import SidebarMenu from "../Shared/SidebarMenu.vue";
import Navbar from "../Shared/Navbar.vue";
import Footer from "../Shared/Footer.vue";
import BaseLayout from "./BaseLayout.vue";

export default {
    name: "TutorialLayout",
    components: {BaseLayout, Footer, Navbar, SidebarMenu},
    props: ['tutorials']
}
</script>

<style scoped>

</style>
