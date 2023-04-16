<template>
    <form @submit.prevent="submit">
        <label for="test-category-select" class="form-label">Choose category:</label>
        <select id="test-category-select" class="form-select"
                :class="{'is-invalid': quizCategorySelectionForm.errors.category_id }"
                name="category"
                v-model="quizCategorySelectionForm.category_id"
                aria-label="Default select example">
            <option value=""></option>
            <option v-for="{id, name} in availableCategories" :value="id">
                {{ name }}
            </option>
        </select>
        <div v-if="quizCategorySelectionForm.errors.category_id" :class="{'invalid-feedback': quizCategorySelectionForm.errors.category_id }">
            {{ quizCategorySelectionForm.errors.category_id }}
        </div>

        <div v-if="quizCategorySelectionForm.category_id" class="mt-3">
            <label for="test-category-select" class="form-label">Choose test:</label>
            <select id="test-category-select" class="form-select"
                    :class="{'is-invalid': quizCategorySelectionForm.errors.test_id }"
                    name="category"
                    v-model="quizCategorySelectionForm.test_id"
                    aria-label="Default select example">
                <option v-for="{id, description} in filteredAvailableTests" :value="id">
                    {{ description }}
                </option>
            </select>
        </div>
        <div class="text-center my-4">
            <button class="btn btn-dark" type="submit" :disabled="!quizCategorySelectionForm.category_id || !quizCategorySelectionForm.test_id">Start</button>
        </div>
    </form>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    name: "TestCategorySelector",
    props: ['availableCategories', 'availableTests'],
    data() {
      return {
          quizCategorySelectionForm: useForm({
              category_id: null,
              test_id: null,
          })
      }
    },
    computed: {
        filteredAvailableTests: function () {
            return (this.availableTests && this.availableTests.length)
                    ? this.availableTests.filter(test => test.category_id === this.quizCategorySelectionForm.category_id)
                    : [];
        }
    },
    methods: {
        submit: function () {
            this.quizCategorySelectionForm.post('test/' + this.quizCategorySelectionForm.category_id, {
                data: {
                    'test_id': this.quizCategorySelectionForm.test_id
                },
                onSuccess: () => this.handleEmit(),
            });
        },
        handleEmit: function () {
            this.$emit('setQuizState', 'process')
        }
    },
}
</script>
