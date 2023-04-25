<template>
    <BaseLayout>
        <template v-slot:container>
            <div class="container-fluid flex-grow-1">
                <slot>Main content</slot>
            </div>
        </template>

        <template v-slot:footer>
            <Footer class="mt-auto"/>
        </template>
    </BaseLayout>
</template>

<script>
import TutorialMap from "../Pages/Tutorial/TutorialMap.vue";
import Navbar from "../Shared/Navbar.vue";
import Footer from "../Shared/Footer.vue";
import BaseLayout from "./BaseLayout.vue";

export default {
    name: "TutorialLayout",
    components: {BaseLayout, Footer, Navbar, TutorialMap}
}
</script>
