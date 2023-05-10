<template>
    <div class="row justify-content-center d-flex align-items-center h-100">
        <div class="col-5">
            <h1 class="my-5 text-center">Худро санҷед</h1>

            <TestBody :currentTest="currentTest" />
        </div>
    </div>
</template>

<script>
import TestBody from "./TestBody.vue";

export default {
    name: "TestIndex",
    components: {TestBody},
    props: {
        currentTest: Object
    },
}
</script>
