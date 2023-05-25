<script>
import {defineComponent} from 'vue'
import {Swiper, SwiperSlide} from "swiper/vue";
import {Autoplay, EffectCube, Navigation, Pagination} from "swiper";
import 'swiper/css';
import 'swiper/css/effect-cube';
import 'swiper/css/pagination';
import 'swiper/css/navigation';

export default defineComponent({
    name: "SliderCube",
    components: {SwiperSlide, Swiper},
    props: {
        items: {
            type: Array,
            required: true,
            default() {
                return [
                    'https://docs.arduino.cc/static/73702ee121860fa04c7f6db5bc77183b/29114/circuit.png',
                    'https://docs.arduino.cc/static/f93a41a187e284b2bb22706bd1d25bf4/29114/circuit.png',
                    'https://docs.arduino.cc/static/9a466cac56df97bcee0389730c663f10/29114/circuit.png',
                ]
            }
        }
    },
    data() {
        return {
            modules: [EffectCube, Pagination, Navigation, Autoplay],
            cubeEffectOptions: {
                shadow: true,
                slideShadows: true,
                shadowOffset: 20,
                shadowScale: 0.94,
            },
            autoplayOptions: {
                delay: 2500,
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
        <swiper-slide v-for="item in items">
            <div :style="{ backgroundImage: `url(${item})` }" class="img rounded-4"></div>
        </swiper-slide>
    </swiper>
</template>

<style lang="scss">
.main-slider {
    width: 450px;
    height: 450px;
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
