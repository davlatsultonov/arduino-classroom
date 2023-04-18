<template>
    <div v-if="currentTest">
        <div>
            <p>
                {{ currentQuestion }}
            </p>
            <div class="list-group mb-3">
                <button class="list-group-item list-group-item-action" v-for="answer in currentQuestionAnswers"
                        @click="() => nextQuestion(answer)">
                    {{ answer.answer }}
                </button>
            </div>
        </div>
        <div class="d-flex align-items-center justify-content-between">
            <Link class="btn btn-outline-danger" :href="route('profile.test.index')" @click="() => handleQuizResult('reset')">Restart</Link>
            <div class="badge text-bg-dark">
                <span class="fw-bold">{{ currentQuestionIndex + 1 }}</span> of {{ currentQuestionsLength }}
            </div>
        </div>
    </div>
    <div v-else>
        Nothing to show
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "TestBox",
    props: ['currentTest', 'handleQuizResult'],
    components: {Link},
    data() {
        return {
            currentQuestionIndex: 0,
            quizResult: []
        }
    },
    computed: {
        currentQuestionsLength: function () {
            return this.currentTest.test_questions.length
        },
        currentQuestion: function () {
            return this.currentTest.test_questions[this.currentQuestionIndex].question
        },
        currentQuestionAnswers: function () {
            return this.currentTest.test_questions[this.currentQuestionIndex].test_answers
        },
    },
    methods: {
        nextQuestion: function (currentTestAnswer) {
            this.quizResult.push({
                question: this.currentQuestion,
                ...currentTestAnswer
            })

            ++this.currentQuestionIndex;

            if (this.currentQuestionIndex === this.currentQuestionsLength) {
                this.$emit('testStateChanged', ['finish', this.quizResult])
            }

        }
    }
}
</script>
