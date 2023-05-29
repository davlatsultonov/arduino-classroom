<template>
    <div v-for="shuffledIconSource in shuffledIconSources" class="moving-icons-set animate">
        <div class="moving-icons-set__inner">
            <MovingIconsSetItem  v-for="(source, index) in shuffledIconSource" :src="source" :alt="iconNames[index]" />
        </div>
        <div class="moving-icons-set__inner">
            <MovingIconsSetItem  v-for="(source, index) in shuffledIconSource" :src="source" :alt="iconNames[index]" />
        </div>
    </div>
</template>

<script>
import MovingIconsSetItem from "./MovingIconsSetItem.vue";

export default {
    name: "MovingIconsSet",
    components: {MovingIconsSetItem},
    data() {
        return {
            iconNames: [
                '8-8-led-matrix-display-unit',
                '8-8-led-matrix-display',
                '9v-battery',
                'arduino-uno',
                'dc-motor',
                'digit-display',
                'jumper-wire',
                'laptop-with-arduino-ide',
                'lcd-display',
                'led-unit',
                'light-sensor',
                'moisture-sensor',
                'potentiometer',
                'push-button',
                'relay-module',
                'resistor-unit',
                'servo-horn',
                'servo',
                'shift-register',
                'sound-sensor',
                'stepper-motor',
                'temperature-sensor',
                'terminal-block-unit',
                'tilt-sensor',
                'touch-sensor',
                'transistor',
                'ultrasonic-distance-sensor',
                'usb-cable',
            ],
            iconSources: []
        }
    },
    computed: {
        shuffledIconSources() {
            let result = [];

            // Создает 20 случайных перестановок массива `iconSources`
            for (let i = 1; i <= 20; i++) {
                result.push(this.shuffle(this.iconSources.concat()));
            }

            return result;
        }
    },
    mounted() {
        // Загружает иконки после монтирования компонента
        Promise.all([
            ...this.iconNames.map(item => this.loadIcon(item))
        ]).then(sources => {
            // Сохраняет загруженные иконки в `iconSources`
            this.iconSources = sources;
        });
    },
    methods: {
        async loadIcon(iconName) {
            // Асинхронно загружает SVG-файл иконки из папки `public/images/ioticons`
            const { default: svg } = await import(`../../../../public/images/ioticons/${iconName}.svg`);
            return svg;
        },
        shuffle(array) {
            let currentIndex = array.length, randomIndex;

            // Пока остаются элементы для перестановки.
            while (currentIndex !== 0) {

                // Выбираем случайный индекс.
                randomIndex = Math.floor(Math.random() * currentIndex);
                currentIndex--;

                // И меняем его с текущим элементом.
                [array[currentIndex], array[randomIndex]] = [
                    array[randomIndex], array[currentIndex]
                ];
            }

            return array;
        }
    }
}
</script>

<style scoped lang="scss">
.moving-icons-set {
    position: relative;
    width: 100%;
    display: flex;
    white-space: nowrap;
    padding: 10px 0;
    transform: rotate(-30deg);

    &__inner {
        display: flex;
    }

    &__inner {
        animation: animate1 300s linear infinite;
        animation-delay: -300s;

        &:nth-child(2) {
            animation: animate2 300s linear infinite;
            animation-delay: -150s;
        }
    }

    &:nth-child(even) {

        .moving-icons-set__inner {
            animation: animate3 300s linear infinite;
            animation-delay: -300s;

            &:nth-child(2) {
                animation: animate4 300s linear infinite;
                animation-delay: -150s;
            }
        }
    }
}

@keyframes animate1 {
    0% {
        transform: translateX(100%);
    }
    100% {
        transform: translateX(-100%);
    }
}

@keyframes animate2 {
    0% {
        transform: translateX(0%);
    }
    100% {
        transform: translateX(-200%);
    }
}

@keyframes animate3 {
    0% {
        transform: translateX(-100%);
    }
    100% {
        transform: translateX(100%);
    }
}

@keyframes animate4 {
    0% {
        transform: translateX(-200%);
    }
    100% {
        transform: translateX(0%);
    }
}
</style>
