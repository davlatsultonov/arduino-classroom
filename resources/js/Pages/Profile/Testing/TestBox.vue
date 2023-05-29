<template>
    <div v-if="currentQuestionsLength">
        <div class="border p-4 rounded-bottom">
            <h5 class="mb-4">
                {{ currentQuestionText }}
            </h5>
            <div class="list-group mb-3">
                <button class="list-group-item list-group-item-action" v-for="answer in currentQuestionAnswers"
                        :class="{
                            'list-group-item-primary': answer.id === currentTestAnswer?.id
                        }"
                        @click="() => handleAnswerChoice(answer)">
                    {{ answer.answer }}
                </button>
            </div>
           <div :class="`d-flex justify-content-${isFirstQuestion ? 'end' : 'between'}`">
               <button v-if="!isFirstQuestion" class="btn btn-outline-danger" @click="handleRestart">Бозоғоз</button>

               <button
                   :disabled="!proceed"
                   class="btn btn-success"
                   @click="nextQuestion"
               >Идома</button>
           </div>
        </div>
        <slot name="test-range"></slot>
    </div>
    <div v-else class="alert alert-info text-center">
        Чизе барои нишон додан нест
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "TestBox",
    props: [
        'handleQuizState',
        'currentQuestionIndex',
        'incrementCurrentQuestionIndex',
        'currentQuestionText',
        'currentQuestionAnswers',
        'currentQuestionsLength'
    ],
    components: {Link},
    data() {
        return {
            currentTestAnswer: null,
            chosenTestAnswerId: null,
            proceed: false
        }
    },
    computed: {
        /**
         * Проверяет, является ли текущий вопрос первым.
         */
        isFirstQuestion() {
            return this.currentQuestionIndex === 0;
        },
    },
    methods: {
        /**
         * Обработка перезапуска текущего теста.
         */
        handleRestart() {
            // Сброс текущих значений и сигнализация о перезапуске теста
            this.currentTestAnswer = null;
            this.chosenTestAnswerId = null;
            this.proceed = false;
            this.$emit('onCurrentTestRestart');
        },
        /**
         * Обработка выбора ответа на вопрос.
         */
        handleAnswerChoice(currentTestAnswer) {
            // Установка текущего выбранного ответа и флага для продолжения
            this.currentTestAnswer = currentTestAnswer;
            this.proceed = true;
        },
        /**
         * Переход к следующему вопросу.
         */
        nextQuestion() {
            if (!this.proceed) return; // Если не выбран ответ, выходим из функции

            this.proceed = true; // Устанавливаем флаг для продолжения
            this.incrementCurrentQuestionIndex(); // Увеличиваем индекс текущего вопроса

            // Эмитируем событие с передачей информации о выбранном ответе
            this.$emit('onAnswerToQuestion', {
                question: this.currentQuestionText,
                correctAnswer: this.currentQuestionAnswers.find(answer => answer.is_correct).answer,
                ...this.currentTestAnswer,
            });

            // Если достигнут последний вопрос, меняем состояние квиза на 'result'
            if (this.currentQuestionIndex === this.currentQuestionsLength - 1) {
                this.handleQuizState('result');
            }
        },
    },
}
</script>
