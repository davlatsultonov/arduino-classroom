<template>
    <div class="h6 text-muted mb-0 fw-semibold d-flex align-items-center justify-content-between">
        <span class="text-muted border p-2">Бахш: <b class="text-dark">{{ subCategoryName }}</b></span>
        <slot name="controls"></slot>
    </div>
    <div class="d-flex ps-5">
        <div class="vr"></div>
    </div>
    <div class="h6 d-inline-block text-muted p-2 ps-2 mb-0 border">
        Мавзӯъ: <b class="text-dark">"{{ testName }}"</b>
    </div>
    <div class="d-flex ps-5">
        <div class="vr"></div>
    </div>
</template>

<script>
export default {
    name: "TestHeading",
    props: ['subCategoryName', 'testName']
}
</script>

<style scoped>

</style>
