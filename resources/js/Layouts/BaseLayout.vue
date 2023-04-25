<template>
    <div class="d-flex flex-column h-100">
        <Navbar class="flex-shrink-0"/>

        <slot name="container"/>

        <slot name="footer" />
    </div>
</template>

<script>
import Navbar from "../Shared/Navbar.vue";

export default {
    name: "BaseLayout",
    components: {Navbar}
}
</script>

<style scoped>

</style>
