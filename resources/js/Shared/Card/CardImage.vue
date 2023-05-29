<template>
    <div
        :style="{
           ...cardImageStyles(image)
         }">
        <slot />
    </div>
</template>

<script>
export default {
    name: "CardImage",
    props: ['image', 'imageHeight'],
    computed: {
        // Возвращает стили для изображения карточки
        cardImageStyles() {
            return (img) => {
                return {
                    backgroundImage: `url('${this.cardImage(img)}')`,
                    backgroundSize: 'cover',
                    backgroundPosition: 'center',
                    backgroundRepeat: 'no-repeat',
                    height: this.imageHeight ? this.imageHeight + 'px' : null,
                };
            };
        }
    },
    methods: {
        // Возвращает путь к изображению карточки
        cardImage(img) {
            let result = img;

            result = !result ? '/images/photo_placement_wide.jpg' : '/storage/' + result;

            return result;
        },
    }
}
</script>

<style scoped>

</style>
