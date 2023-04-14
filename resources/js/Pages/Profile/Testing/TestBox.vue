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
        <div class="d-flex align-items-center justify-content-between">
            <Link class="btn btn-outline-danger" :href="route('profile.test.index')" @click="() => handleQuizResult('reset')">Restart</Link>
            <div class="badge text-bg-dark">
                <span class="fw-bold">{{ currentQuestionIndex + 1 }}</span> of {{ tests.length }}
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";
export default {
    name: "TestBox",
    props: ['tests', 'handleQuizResult'],
    components: {Link},
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
            }
        }
    },
    methods: {
        nextQuestion: function (currentTestAnswer) {
            this.quizResult.push({
                question: this.currentTest.question,
                ...currentTestAnswer
            })

            ++this.currentQuestionIndex;

            if (this.currentQuestionIndex === this.tests.length) {
                this.$emit('testStateChanged', ['finish', this.quizResult])
            }

        }
    }
}
</script>

<style scoped>
</style>
