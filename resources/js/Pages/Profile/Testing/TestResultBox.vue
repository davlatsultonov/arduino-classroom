<template>
    <div>
        <div>
            You have answered to {{ correctAnswersCount }} out of {{ filteredTestsLength }}
        </div>
        <div v-if="showQuizResults">
            <ul class="list-group my-4" v-for="result in quizResults">
                <li class="list-group-item">{{ result.question }}</li>
                <li :class="['list-group-item', `list-group-item-${result.is_correct ? 'success' : 'danger'}`]">
                    {{ result.answer }}
                </li>
            </ul>
        </div>

        <div class="btn-group mt-4" role="group">
            <button v-if="!showQuizResults" class="btn btn-outline-primary" @click="showQuizResults = true">Show
                my results
            </button>
            <Link class="btn btn-outline-danger" :href="route('profile.test.index')"  @click="() => handleQuizResult('start')">Restart</Link>
            <Link :href="route('profile.index')"  @click="() => handleQuizResult('finish')" class="btn btn-dark">Finish</Link>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "TestResultBox",
    components: {Link},
    props: ['correctAnswersCount', 'showQuizResults', 'filteredTestsLength', 'quizResults', 'handleQuizResult']
}
</script>

<style scoped>

</style>
