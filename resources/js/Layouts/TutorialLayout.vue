<template>
    <div>
        <Navbar class="flex-shrink-0"/>
        <div class="container">
            <div class="row">
                <div class="col-3">
                    <SidebarMenu :tutorials="tutorials"/>
                </div>
                <div class="col-9">
                    <slot>Main content</slot>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import SidebarMenu from "../Shared/SidebarMenu.vue";
import Navbar from "../Shared/Navbar.vue";

export default {
    name: "TutorialLayout",
    components: {Navbar, SidebarMenu},
    props: ['tutorials']
}
</script>

<style scoped>

</style>
