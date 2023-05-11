<template>
    <template v-if="quizState">
        <TestCategorySelector
            v-if="quizState === 'start'"
            @set-quiz-state="(state) => quizState = state"
            :current-article-test-settings="currentArticleTestSettings"
        />
        <TestBox v-else-if="quizState === 'process'"
                 @test-state-changed="handleTestStateChange"
                 :current-test-questions="currentTest.test_questions"
                 :handle-quiz-result="handleQuizResult"
        />
        <TestResultBox v-else-if="quizState === 'finish'"
                       :correctAnswersCount="correctAnswersCount"
                       :showQuizResults="showQuizResults"
                       :quiz-results="quizResults"
                       :handle-quiz-result="handleQuizResult"
                       :filtered-tests-length="currentTest.test_questions.length"
        />
    </template>
    <div v-else class="alert alert-info text-center">
        Ҳанӯз ягон санҷиш вуҷуд надорад...
    </div>
</template>

<script>
import TestResultBox from "./TestResultBox.vue";
import TestCategorySelector from "./TestCategorySelector.vue";
import TestBox from "./TestBox.vue";

export default {
    name: "TestBody",
    components: {TestBox, TestCategorySelector, TestResultBox},
    props: {
        currentTest: Object,
        currentArticleTestSettings: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            quizState: '',
            quizResults: null,
            showQuizResults: false,
            correctAnswersCount: null,
        }
    },
    created() {
        if (this.$page.props.shared.availableCategories?.length) this.quizState = 'start';
        if (this.currentTest) this.quizState = 'process';
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
                if (confirm('Оё шумо мехоҳед тағироти ҷории худро нигоҳ доред?')) {
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
