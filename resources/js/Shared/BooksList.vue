<script>
import {defineComponent} from 'vue'

export default defineComponent({
    name: "BooksList",
    data() {
        return {
            booksCovers: [
                {
                    cover: 'izuchaem-arduino',
                    book: 'IoT_как_ИНТРАНЕТ_вещей_с_Raspberry_Pi_и_MajorDoMo'
                },
                {
                    cover: 'iot',
                    book: 'Бокселл Джон - Изучаем Arduino. 65 проектов своими руками - 2022'
                },
                {
                    cover: 'elektronika.-sbornik-receptov',
                    book: 'Петин В.А. - Создание умного дома на базе Arduino - 2018'
                },
            ]
        }
    }
})
</script>

<template>
    <div class="row books-list gx-4">
        <h3 class="mb-4">Китобҳо барои омӯзиши иловагӣ</h3>
        <div class="col-6 col-lg-4 mb-4 mb-lg-0" v-for="{cover, book} in booksCovers">
            <div class="books-list__item border border-light">
                <a :href="`/books/${book}.pdf`" download>
                    <img :src="`/images/books-cover/${cover}.png`" alt="book-cover">
                </a>
            </div>
        </div>
    </div>
</template>

<style scoped lang="scss">
.books-list {

    &__item {
        width: 100%;
        height: 100%;

        img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
    }
}
</style>
