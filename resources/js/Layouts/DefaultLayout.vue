<template>
   <div class="d-flex flex-column h-100">
       <Navbar class="flex-shrink-0" />

       <div class="container-fluid flex-grow-1">
           <div class="container h-100">
               <slot/>
           </div>
       </div>

       <Footer class="mt-auto" v-if="!this.$page.component.startsWith('Profile')"/>
   </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";
import Footer from "../Shared/Footer.vue";

export default {
    components: {Footer, Link, Navbar},
    methods: {
        logout() {
            this.$inertia.delete(route('logout'))
        }
    }
}
</script>
