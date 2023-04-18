<template>
    <div class="row justify-content-center d-flex align-items-center h-100">
        <div class="col-5">
            <h1 class="mb-5 text-center">Test yourself</h1>
            <TestCategorySelector
                v-if="quizState === 'start'"
                :available-categories="availableCategories"
                :available-tests="availableTests"
                :quiz-state="quizState"
                @set-quiz-state="(state) => quizState = state"
            />
            <TestBox v-else-if="quizState === 'process'"
                     @test-state-changed="handleTestStateChange"
                     :current-test="currentTest"
                     :handle-quiz-result="handleQuizResult"
            />
            <TestResultBox v-else-if="quizState === 'finish'"
                           :correctAnswersCount="correctAnswersCount"
                           :showQuizResults="showQuizResults"
                           :quiz-results="quizResults"
                           :handle-quiz-result="handleQuizResult"
                           :filtered-tests-length="currentTest.test_questions.length"
            />
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
import TestBox from "./TestBox.vue";
import TestCategorySelector from "./TestCategorySelector.vue";
import TestResultBox from "./TestResultBox.vue";

export default {
    name: "TestIndex",
    components: {TestResultBox, TestCategorySelector, TestBox, Link},
    props: {
        data: Array,
        currentTest: Object,
        availableTests: Array,
        availableCategories: Array
    },
    data() {
        return {
            quizState: 'start',
            quizResults: null,
            showQuizResults: false,
            correctAnswersCount: null,
        }
    },
    methods: {
        handleTestStateChange: function ([quizState, quizResults]) {
            this.quizState = quizState;
            this.quizResults = quizResults;
            this.correctAnswersCount = this.countCorrectAnswers(quizResults);
        },
        countCorrectAnswers: (answers) => answers.reduce((acc, curr) => curr.is_correct ? ++acc : acc, 0),
        handleQuizResult: function (quizState) {
            if (quizState === 'reset') {
                this.quizState = 'start';
            }

            if (quizState === 'start') {
                if (confirm('Сохранить тякущие изменения?')) {
                    this.saveQuizResult()
                }

                this.quizState = 'start';
            }

            if (quizState === 'finish') {
                this.saveQuizResult();
                this.quizState = 'finish';
            }
        },
        saveQuizResult: function () {
            this.$inertia.visit('/profile/test', {
                method: 'post',
                data: {
                    quizResults: this.quizResults.map(({id, test_question_id}) => ({
                        test_question_id, test_answer_id: id, 'user_id': this.$page.props.shared.auth.userId
                    }))
                }
            })
        }
    }
}
</script>
