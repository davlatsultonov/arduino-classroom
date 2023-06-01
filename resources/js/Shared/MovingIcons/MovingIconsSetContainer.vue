<template>
    <div class="d-none d-lg-block moving-icons-set-container pause">
        <MovingIconsSet/>
    </div>
</template>

<script>

import MovingIconsSet from "./MovingIconsSet.vue";

export default {
    name: "MovingIconsSetContainer",
    components: {MovingIconsSet}
}
</script>

<style lang="scss">
.moving-icons-set-container {
    position: fixed;
    z-index: 0;
    top: -150%;
    left: -50%;
}
</style>
