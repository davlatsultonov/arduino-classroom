<script>
import {defineComponent} from 'vue'
import {Swiper, SwiperSlide} from "swiper/vue";
import {Autoplay, EffectCube, Pagination} from "swiper";
import 'swiper/css';
import 'swiper/css/effect-cube';
import 'swiper/css/pagination';

export default defineComponent({
    name: "SliderCube",
    components: {SwiperSlide, Swiper},
    props: {
        items: {
            type: Array,
            required: true
        }
    },
    data() {
        return {
            modules: [EffectCube, Pagination, Autoplay],
            cubeEffectOptions: {
                shadow: true,
                slideShadows: true,
                shadowOffset: 20,
                shadowScale: 0.94,
            },
            autoplayOptions: {
                delay: 3500,
                disableOnInteraction: false,
                pauseOnMouseEnter: true
            }
        }
    }
})
</script>

<template>
    <swiper
        class="main-slider"
        :cubeEffect="cubeEffectOptions"
        :autoplay="autoplayOptions"
        :effect="'cube'"
        :grabCursor="true"
        :modules="modules"
        :loop="true"
        :pagination="true">
        <swiper-slide v-for="{image, slug} in items">
            <a :href="'tutorials/' + slug" :style="{ backgroundImage: `url(/storage/${image})` }" class="d-block img rounded-4"></a>
        </swiper-slide>
    </swiper>
</template>

<style lang="scss">
.main-slider {
    width: 490px;
    height: 490px;
    overflow: visible;

    .swiper-slide .img {
        height: 100%;
        width: 100%;
        background-position: center;
        background-repeat: no-repeat;
        background-size: contain;
        background-color: #fff;
        border: 2px solid #00979d;
    }

    &.swiper-3d {

        .swiper-slide-shadow-left {
            background-image: linear-gradient(to left, rgba(0, 151, 157, .5), rgba(0, 0, 0, 0));
        }

        .swiper-slide-shadow-right {
            background-image: linear-gradient(to right, rgba(0, 151, 157, .5), rgba(0, 0, 0, 0));
        }
    }

    .swiper-slide-shadow {
        background: rgba(0, 151, 157, 15%);
    }

    .swiper-pagination-bullet-active {
        background: rgba(0, 151, 157, 1);
    }
}

</style>
