<template>
    <form @submit.prevent="submit">
        <label for="test-category-select" class="form-label">Категорияро интихоб кунед:</label>
        <select id="test-category-select" class="form-select"
                :class="{'is-invalid': quizCategorySelectionForm.errors.sub_category_id }"
                name="category"
                v-model="quizCategorySelectionForm.sub_category_id"
                aria-label="Default select example">
            <option value=""></option>
            <option v-for="{id, name} in $page.props.shared.availableCategories" :value="id">
                {{ name }}
            </option>
        </select>
        <div v-if="quizCategorySelectionForm.errors.sub_category_id" :class="{'invalid-feedback': quizCategorySelectionForm.errors.sub_category_id }">
            {{ quizCategorySelectionForm.errors.sub_category_id }}
        </div>

        <div v-if="quizCategorySelectionForm.sub_category_id" class="mt-3">
            <label for="test-category-select" class="form-label">Мақоларо интихоб кунед:</label>
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
            <button class="btn btn-dark"
                    type="submit"
                    :disabled="!quizCategorySelectionForm.sub_category_id || !quizCategorySelectionForm.test_id"
                    data-bs-dismiss="modal"
            >Оғоз кунед</button>
        </div>
    </form>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    name: "TestCategorySelector",
    props: {
        currentArticleTestSettings: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
      return {
          quizCategorySelectionForm: useForm({
              sub_category_id: null,
              test_id: null,
          })
      }
    },
    created() {
        if (Object.keys(this.currentArticleTestSettings).length > 1) {
            this.quizCategorySelectionForm.sub_category_id = this.currentArticleTestSettings.sub_category_id
            this.quizCategorySelectionForm.test_id = this.currentArticleTestSettings.test_id
        }
    },
    computed: {
        filteredAvailableTests: function () {
            return (this.$page.props.shared.availableTests && this.$page.props.shared.availableTests.length)
                    ? this.$page.props.shared.availableTests.filter(test => test.sub_category_id === this.quizCategorySelectionForm.sub_category_id)
                    : [];
        }
    },
    methods: {
        submit: function () {
            this.quizCategorySelectionForm.post('/profile/test/' + this.quizCategorySelectionForm.sub_category_id, {
                onSuccess: () => this.handleEmit(),
            });
        },
        handleEmit: function () {
            this.$emit('setQuizState', 'process')
        }
    },
}
</script>
