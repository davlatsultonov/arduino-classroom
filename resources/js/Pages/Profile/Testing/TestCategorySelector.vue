<template>
    <form @submit.prevent="submit">
        <label for="test-category-select" class="form-label">Бахшро интихоб кунед:</label>
        <select id="test-category-select" class="form-select"
                :class="{'is-invalid': quizCategorySelectionForm.errors.sub_category_id }"
                name="category"
                v-model="quizCategorySelectionForm.sub_category_id"
                :disabled="externalSettings.test_id"
                aria-describedby="test-category-select-text-1"
                aria-label="Default select example">
            <option value=""></option>
            <option v-for="{id, name} in $page.props.shared.availableCategories" :value="id">
                {{ name }}
            </option>
        </select>
        <div id="test-category-select-text-1" class="form-text">
            Дар ин ҷо рӯйхати бахшҳо аз бобҳои <b>"Системаи Arduino"</b>, <b>"Системаи Raspberry Pi"</b> ва <b>"Тарҳрезии хонаи доно"</b> мавҷуд аст.
        </div>
        <div v-if="quizCategorySelectionForm.errors.sub_category_id" :class="{'invalid-feedback': quizCategorySelectionForm.errors.sub_category_id }">
            {{ quizCategorySelectionForm.errors.sub_category_id }}
        </div>

        <div v-if="quizCategorySelectionForm.sub_category_id" class="mt-3">
            <label for="test-category-select" class="form-label">Мақоларо интихоб кунед:</label>
            <select id="test-category-select" class="form-select"
                    aria-describedby="test-category-select-text-2"
                    :class="{'is-invalid': quizCategorySelectionForm.errors.test_id }"
                    name="category"
                    v-model="quizCategorySelectionForm.test_id"
                    :disabled="!externalSettings?.changedChoice && externalSettings?.test_id"
                    aria-label="Default select example">
                <option v-for="{id, description} in filteredAvailableTests" :value="id">
                    {{ description }}
                </option>
                <option value="*" class="fw-bold fst-italic">ҳамаи мақолаҳо</option>
            </select>
            <div id="test-category-select-text-2" class="form-text">
                Ҳангоми интихоби мақола, ба шумо саволҳо дар ин мавзӯъ дода мешаванд.
            </div>
            <div id="test-category-select-text-3" class="form-text">
                Шумо инчунин метавонед "ҳамаи мақолаҳо" - ро интихоб кунед. Ин ҳама саволҳоро дар бораи мақолаҳои бахши интихобшуда медиҳад
            </div>
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
        externalSettings: {
            type: Object,
            default() {
                return {}
            }
        },
        handleQuizState: Function
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
        // Проверяем наличие внешних настроек
        if (Object.keys(this.externalSettings).length > 1) {
            // Если настройки существуют, устанавливаем значения формы выбора категории и теста
            this.quizCategorySelectionForm.sub_category_id = this.externalSettings.sub_category_id;
            this.quizCategorySelectionForm.test_id = this.externalSettings.test_id;
        }
    },
    computed: {
        /**
         * Возвращает отфильтрованные доступные тесты, основываясь на выбранной подкатегории.
         */
        filteredAvailableTests() {
            return (this.$page.props.shared.availableTests && this.$page.props.shared.availableTests.length)
                ? this.$page.props.shared.availableTests.filter(test => test.sub_category_id === this.quizCategorySelectionForm.sub_category_id)
                : [];
        },
    },
    methods: {
        /**
         * Отправка данных формы выбора категории и теста.
         */
        submit() {
            this.quizCategorySelectionForm.get('/profile/test/' + this.quizCategorySelectionForm.sub_category_id, {
                onSuccess: () => this.handleQuizState('process'),
            });
        },
    },
}
</script>
