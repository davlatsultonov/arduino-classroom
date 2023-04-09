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
            <button class="btn btn-outline-danger" @click="() => this.$emit('setQuizState', 'start')">Restart</button>
            <Link :href="route('profile.index')" class="btn btn-dark">Finish</Link>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "TestResultBox",
    components: {Link},
    props: ['correctAnswersCount', 'showQuizResults', 'filteredTestsLength', 'quizResults']
}
</script>

<style scoped>

</style>
