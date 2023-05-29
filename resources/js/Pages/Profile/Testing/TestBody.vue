<template>
    <div v-if="quizState">
        <TestHeading
            v-if="currentTest"
            :sub-category-name="currentTest.sub_category.name"
            :test-name="currentTest.description"
        >
            <template v-slot:controls
                      v-if="quizResults.length < currentQuestionsLength">
                <button
                    class="btn btn-sm btn-outline-dark fw-semibold ms-3"
                    @click="handleTestChoiceChangeModalActivation"
                >Санҷиши дигар
                </button>
            </template>
        </TestHeading>
        <TestCategorySelector
            v-if="quizState === 'start'"
            :handle-quiz-state="handleQuizState"
        />

        <TestBox
            v-else-if="quizState === 'process'"
            @on-current-test-restart="handleCurrentTestRestart"
            @on-answer-to-question="answerToQuestion"
            :handle-quiz-state="handleQuizState"
            :current-question-index="currentQuestionIndex"
            :increment-current-question-index="incrementCurrentQuestionIndex"
            :current-question-text="currentQuestionText"
            :current-question-answers="currentQuestionAnswers"
            :current-questions-length="currentQuestionsLength"
        >
            <template v-slot:test-range>
                <div class="mt-3">
                    <TestsRange
                        :current-question-index="currentQuestionIndex"
                        :current-questions="currentQuestions"
                        :quiz-results="quizResults"
                        :all-test-selected="currentQuestionsLength > 5"
                    />
                </div>
            </template>
        </TestBox>
        <TestResultBox v-else-if="quizState === 'result'"
                       :handle-quiz-state="handleQuizState"
                       :quiz-results="quizResults"
                       :current-questions-length="currentQuestionsLength"
        />
    </div>
    <div v-else class="alert alert-info text-center">
        Ҳанӯз ягон санҷиш вуҷуд надорад...
    </div>

    <div class="modal fade" id="test-choice-modal" tabindex="-1" role="dialog" aria-labelledby="test-choice-modal"
         aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-body">
                    <div v-if="(quizResults && quizResults.length >= 3) && !agreeToLoseData" class="d-flex flex-column">
                        <div class="alert alert-danger">
                            Шумо натиҷаи ҷории худро гум мекунед
                        </div>
                        <div class="btn-group-vertical">
                            <button class="btn btn-outline-secondary" @click="agreeToLoseData = true">Ман розӣ ҳастам
                            </button>
                        </div>
                    </div>

                    <div v-else class="d-flex flex-column justify-content-end">
                        <button class="btn btn-danger mb-4" @click="handleTestChoiceCancel">Бекор кардан</button>

                        <TestCategorySelector
                            @set-quiz-state="(state) => quizState = state"
                            :external-settings="anotherTestSettings"
                        />
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import TestResultBox from "./TestResultBox.vue";
import TestCategorySelector from "./TestCategorySelector.vue";
import TestBox from "./TestBox.vue";
import TestsRange from "./TestsRange.vue";
import {Modal} from "bootstrap";
import TestHeading from "./TestHeading.vue";
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "TestBody",
    components: {Link, TestHeading, TestsRange, TestBox, TestCategorySelector, TestResultBox},
    props: {
        currentTest: Object
    },
    data() {
        return {
            quizState: '',
            quizResults: [],
            testChoiceModal: null,
            agreeToLoseData: false,
            currentQuestionIndex: 0,
        }
    },
    created() {
        // Устанавливаем состояние в "start", если доступны категории
        if (this.$page.props.shared.availableCategories?.length) {
            this.quizState = 'start';
        }

        // Устанавливаем состояние в "process", если текущий тест существует
        if (this.currentTest) {
            this.quizState = 'process';
        }
    },
    computed: {
        /**
         * Возвращает настройки для другого теста в зависимости от текущего состояния квиза.
         */
        anotherTestSettings() {
            return this.quizState !== 'process' ? {} : {
                sub_category_id: this.currentTest.sub_category_id,
                test_id: this.currentTest.id,
                changedChoice: true,
            };
        },

        /**
         * Возвращает текущие вопросы теста.
         */
        currentQuestions() {
            return this.currentTest.test_questions;
        },

        /**
         * Возвращает текст текущего вопроса.
         */
        currentQuestionText() {
            return this.currentQuestions[this.currentQuestionIndex].question;
        },

        /**
         * Возвращает длину текущих вопросов.
         */
        currentQuestionsLength() {
            return this.currentQuestions.length;
        },

        /**
         * Возвращает ответы текущего вопроса.
         */
        currentQuestionAnswers() {
            return this.currentQuestions[this.currentQuestionIndex].test_answers;
        },
    },
    mounted() {
        // Инициализация модального окна выбора теста
        this.testChoiceModal = new Modal('#test-choice-modal');
    },
    methods: {
        /**
         * Обработка ответа на вопрос.
         */
        answerToQuestion(answer) {
            this.quizResults.push(answer);
        },

        /**
         * Увеличение индекса текущего вопроса.
         */
        incrementCurrentQuestionIndex() {
            ++this.currentQuestionIndex;
        },

        /**
         * Обработка перезапуска текущего теста.
         */
        handleCurrentTestRestart() {
            this.quizResults = [];
            this.currentQuestionIndex = 0;
        },

        /**
         * Обработка отмены выбора теста.
         */
        handleTestChoiceCancel() {
            this.agreeToLoseData = false;
            this.testChoiceModal.hide(true);
        },

        /**
         * Обработка активации модального окна выбора теста.
         */
        handleTestChoiceChangeModalActivation() {
            this.testChoiceModal.show(true);
        },

        /**
         * Обработка состояния квиза.
         */
        handleQuizState(quizState) {
            if (quizState === 'reset') {
                this.quizState = 'start';
            }

            if (quizState === 'process' || quizState === 'result') {
                this.quizState = quizState;
            }

            if (quizState === 'start') {
                if (confirm('Оё шумо мехоҳед тағироти ҷории худро нигоҳ доред?')) {
                    this.saveQuizResult();
                }

                this.quizState = 'start';
            }

            if (quizState === 'finish') {
                this.saveQuizResult();
                this.quizState = 'finish';
            }
        },

        /**
         * Сохранение результатов квиза.
         */
        saveQuizResult() {
            this.$inertia.visit('/profile/test', {
                method: 'post',
                data: {
                    quizResults: this.quizResults.map(({ id, test_question_id }) => ({
                        test_question_id,
                        test_answer_id: id,
                        'user_id': this.$page.props.shared.auth.userId,
                    })),
                },
            });
        },
    },
}
</script>

<style>
.v-enter-active,
.v-leave-active {
    transition: opacity 0.5s ease;
}

.v-enter-from,
.v-leave-to {
    opacity: 0;
}

</style>
