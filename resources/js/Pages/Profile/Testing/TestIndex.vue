<template>
    <div class="row justify-content-center mt-5 h-100">
        <div class="col-6" v-if="!currentTest">
            <h1 class="mb-3">Санҷиши дониш</h1>
            <p>
                Дар ин саҳифа шумо метавонед дониши худро дар бораи системаҳои Аруино Ва Raspberry Pi санҷед
            </p>
        </div>
        <div :class="`col-${currentTest ? 8 : 6}`">
            <div class="mb-5" v-if="currentTest">
                <Link :href="route('profile.test.index')" class="btn btn-outline-dark">Саҳифаи санҷишӣ</Link>
            </div>
            <TestBody :currentTest="currentTest" />
        </div>
    </div>
</template>

<script>
import TestBody from "./TestBody.vue";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "TestIndex",
    components: {Link, TestBody},
    props: {
        currentTest: Object
    },
}
</script>
