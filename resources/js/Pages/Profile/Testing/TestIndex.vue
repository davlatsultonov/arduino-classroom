<template>
    <div class="row justify-content-center">
        <div class="col-5">
            <h1 class="mb-5 text-center">Test yourself</h1>
            <TestCategorySelector
                v-if="quizState === 'start'"
                :quiz-state="quizState"
                @set-quiz-state="(state) => quizState = state"
            />
            <TestBox v-else-if="quizState === 'process'"
                     @test-state-changed="handleTestStateChange"
                     :tests="Object.entries(filteredTests)"
                     :handle-quiz-result="handleQuizResult"
            />
            <TestResultBox v-else-if="quizState === 'finish'"
                           :correctAnswersCount="correctAnswersCount"
                           :showQuizResults="showQuizResults"
                           :quiz-results="quizResults"
                           :handle-quiz-result="handleQuizResult"
                           :filtered-tests-length="Object.keys(filteredTests).length"
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
        tests: Array,
    },
    data() {
        return {
            quizState: 'start',
            quizResults: null,
            showQuizResults: false,
            correctAnswersCount: null,
        }
    },
    computed: {
        filteredTests: function () {
            if (!(this.tests && this.tests.length)) return null;

            const result = {};

            this.tests.forEach((test, index, array) => {
                if (!result.hasOwnProperty(test.question)) {
                    result[test.question] = array
                        .filter(item => item.question === test.question)
                        .map(({
                          answer,
                          is_correct,
                          test_question_id,
                          test_answer_id
                      }) => ({answer, is_correct, test_question_id, test_answer_id}))
                }
            })

            return result;
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
                    quizResults: this.quizResults.map(({test_question_id, test_answer_id}) => {
                        return {
                            test_question_id, test_answer_id, 'user_id': this.$page.props.auth.user.id
                        }
                    })
                }
            })
        }
    }
}
</script>

<style scoped>

</style>
