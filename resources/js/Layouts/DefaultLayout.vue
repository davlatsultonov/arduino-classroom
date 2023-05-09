<template>
   <BaseLayout>
       <template v-slot:container>
           <div class="container flex-grow-1">
               <div class="row justify-content-center">
                   <div class="col-10">
                       <slot/>
                   </div>
               </div>
           </div>
       </template>
       <template v-slot:footer>
           <Footer class="mt-auto" v-if="!this.$page.component.startsWith('Profile')"/>
       </template>
   </BaseLayout>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";
import Footer from "../Shared/Footer.vue";
import BaseLayout from "./BaseLayout.vue";

export default {
    components: {BaseLayout, Footer, Link, Navbar},
    methods: {
        logout() {
            this.$inertia.delete(route('logout'))
        }
    }
}
</script>
