<template>
    <ul class="test-range w-75 px-0 mx-auto border rounded-5 mb-0">
        <li v-for="(n, index) in currentQuestions"
            class="d-inline-flex align-items-center justify-content-between test-range__item"
            :class="{
                'test-range__item-active': index === currentQuestionIndex,
                'test-range__item-fill': quizResults.find(answer => answer.test_question_id === n.id),
            }"
        >
            <span class="d-inline-flex border justify-content-center align-items-center">
                {{ index + 1 }}
            </span>
        </li>
    </ul>
</template>

<script>
export default {
    name: "TestsRange",
    props: ['currentQuestionIndex', 'currentQuestions', 'quizResults']
}
</script>

<style scoped lang="scss">
.test-range {
    display: flex;
    padding-top: 5px;
    padding-bottom: 5px;

    &__item {
        position: relative;
        overflow: hidden;
        padding: 0 8px;

        span {
            border-radius: 100%;
            width: 25px;
            height: 25px;
            font-size: 16px;
            background-color: #fff;
        }

        &:not(:last-of-type) {
            flex-grow: 1;

            &:after {
                content: "";
                position: absolute;
                top: 50%;
                left: 33px;
                width: 100%;
                height: 1px;
                background-color: #dee2e6;
                transform: translateY(-50%);
            }
        }

        &-active {

            span {
                background-color: #f8ab47 !important;
                color: #fff;
            }
        }

        &-fill {
            span, &::after {
                background-color: #6c6c6c !important;
                color: #fff;
            }
        }
    }
}
</style>
