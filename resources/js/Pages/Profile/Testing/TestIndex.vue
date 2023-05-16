<template>
    <div class="row justify-content-center mt-5 h-100">
        <div class="col-6" v-if="!currentTest">
            <h1 class="mb-3">Санҷиши дониш</h1>
            <p>
                Дар ин саҳифа шумо метавонед дониши худро дар бораи системаҳои Аруино Ва Raspberry Pi санҷед
            </p>
        </div>
        <div :class="`col-${currentTest ? 8 : 6}`">
            <h5 class="text-muted">Бахши интихобшуда: <b>{{ currentTest?.sub_category.name }}</b></h5>
            <h6 v-if="currentTest" class="mb-4 text-muted">Санҷиши дониш дар мавзуи: <b>"{{ currentTest?.description }}"</b></h6>
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
