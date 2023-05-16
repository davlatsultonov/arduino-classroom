<template>
    <div class="mb-5 border p-3">
        <p class="lead">
            Шумо аз {{ currentQuestionsLength }} ба <span class="fw-semibold">{{ correctAnswersCount }}</span> савол ҷавоби дуруст додед
        </p>
        <div v-if="showQuizResults">
            <ul class="list-group my-4" v-for="result in quizResults">
                <li class="list-group-item fw-semibold">{{ result.question }}</li>
                <li :class="['list-group-item', `list-group-item-${result.is_correct ? 'success' : 'danger'}`]">
                    Ҷавоби шумо: <b>{{ result.answer }}</b>
                </li>
                <li v-if="result.correctAnswer !== result.answer" class="list-group-item list-group-item-light">
                    Ҷавоби дуруст: <b>{{ result.correctAnswer }}</b>
                </li>
            </ul>
        </div>

        <div class="btn-group" role="group">
            <button v-if="!showQuizResults" class="btn btn-outline-primary" @click="showQuizResults = true">Натиҷаҳо</button>
            <Link class="btn btn-outline-danger" :href="route('profile.test.index')"  @click="() => handleQuizState('start')">Санҷиши нав</Link>
            <Link :href="route('profile.index')"  @click="() => handleQuizState('finish')" class="btn btn-outline-dark">Анҷоми санҷиш</Link>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "TestResultBox",
    components: {Link},
    props: ['currentQuestionsLength', 'quizResults', 'handleQuizState'],
    data() {
        return {
            showQuizResults: false,
        }
    },
    computed: {
        correctAnswersCount() {
            return this.quizResults.reduce((acc, curr) => curr.is_correct ? ++acc : acc, 0)
        }
    }
}
</script>
