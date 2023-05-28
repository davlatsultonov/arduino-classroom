<template>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-12 col-lg-10">
                <slot />
            </div>
        </div>
    </div>
</template>

<script>
export default {
    name: "ContentContainer"
}
</script>

<style>
.container, .container-fluid {
    position: relative; z-index: 1
}
</style>
