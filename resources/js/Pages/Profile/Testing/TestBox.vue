<template>
    <div>
        <div>
            <p>
                {{ currentTest.question }}
            </p>
            <div class="list-group mb-3">
                <button class="list-group-item list-group-item-action" v-for="currentTestAnswer in currentTest.answers" @click="() => nextQuestion(currentTestAnswer)">
                    {{ currentTestAnswer.answer }}
                </button>
            </div>
        </div>
        <button class="btn btn-dark" @click="restartTest">Restart</button>
    </div>
</template>

<script>
export default {
    name: "TestBox",
    props: ['tests', 'restartTest'],
    data() {
        return {
            currentQuestionIndex: 0,
            quizResult: []
        }
    },
    computed: {
        currentTest: function () {
            return {
                question: this.tests[this.currentQuestionIndex][0],
                answers: this.tests[this.currentQuestionIndex][1],
                is_correct: this.tests[this.currentQuestionIndex][3],
            }
        }
    },
    methods: {
        nextQuestion: function (currentTestAnswer) {
            this.quizResult.push({
                question: this.currentTest.question,
                answer: currentTestAnswer.answer,
                is_correct: currentTestAnswer.is_correct
            })

            ++this.currentQuestionIndex;

            if (this.currentQuestionIndex === this.tests.length) {
                this.$emit('testStateChanged', ['end', this.quizResult])
            }

        }
    }
}
</script>

<style scoped>
</style>
