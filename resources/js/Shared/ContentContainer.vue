<template>
    <div class="container" style="position: relative; z-index: 1">
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
