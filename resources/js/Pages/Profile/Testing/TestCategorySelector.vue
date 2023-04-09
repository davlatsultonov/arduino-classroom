<template>
    <form @submit.prevent="submit">
        <label for="test-category-select" class="form-label">Choose category:</label>
        <select id="test-category-select" class="form-select" :class="{'is-invalid': quizCategorySelectionForm.errors.category_id }" name="category" v-model="quizCategorySelectionForm.category_id" aria-label="Default select example">
            <option v-for="{id, name} in availableTestCategories" :value="id">
                {{ name }}
            </option>
        </select>
        <div v-if="quizCategorySelectionForm.errors.category_id" :class="{'invalid-feedback': quizCategorySelectionForm.errors.category_id }">
            {{ quizCategorySelectionForm.errors.category_id }}
        </div>
        <div class="text-center my-4">
            <button class="btn btn-dark" type="submit">Start</button>
        </div>
    </form>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    name: "TestCategorySelector",
    data() {
      return {
          quizCategorySelectionForm: useForm({
              category_id: this.$page.props.availableTestCategories[0].id
          })
      }
    },
    computed: {
        availableTestCategories: function() {
            return this.$page.props.availableTestCategories
        }
    },
    methods: {
        submit: function () {
            this.quizCategorySelectionForm.post('test/' + this.quizCategorySelectionForm.category_id, {
                onSuccess: () => this.handleEmit(),
            });
        },
        handleEmit: function () {
            this.$emit('setQuizState', 'process')
        }
    },
}
</script>

<style scoped>

</style>
