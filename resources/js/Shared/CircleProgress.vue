<template>
    <div class="circle-progress mx-auto" :style="{width:size+'px',height:size+'px'}" :data-pct="progressNumber" data-pct-subtitle="хол">
        <svg :width="size" :height="size" :viewPort="'0 0 '+ size + ' ' + size" version="1.1" xmlns="http://www.w3.org/2000/svg">
            <circle class="ring" :stroke="ringColor" :r="r" :cx="size/2" :cy="size/2" :stroke-width="strokeWidth" fill="none">
            </circle>
            <circle class="progress_circle" :stroke="progressColor" :r="r" :cx="size/2" :cy="size/2" :stroke-width="strokeWidth" fill="none" :stroke-dasharray="dasharray" :stroke-dashoffset="dashoffset"></circle>
        </svg>
    </div>
</template>
<script>
export default {
    name: "circle-progress",
    data() {
        return {};
    },
    props: {
        size: {
            type: Number,
            default: 60
        },
        percentage: {
            type: Number,
            default: 0,
            validator: val => {
                return val <= 100;
            }
        },
        strokeWidth: {
            type: Number,
            default: 10
        },
        ringColor: {
            type: String,
            default: "#E9EBEE"
        },
        progressColor: {
            type: String,
            default: "#00979d"
        },
        showNumber: {
            type: Boolean,
            default: true
        }
    },
    computed: {
        // Рассчитывает радиус окружности
        r() {
            return this.size / 2 - this.strokeWidth / 2;
        },
        // Рассчитывает значение dasharray для отображения прогресса
        dasharray() {
            return 2 * Math.PI * this.r;
        },
        // Рассчитывает значение dashoffset для отображения прогресса
        dashoffset() {
            return this.dasharray * (1 - this.percentage / 100);
        },
        // Рассчитывает числовое значение прогресса для отображения
        progressNumber() {
            return this.showNumber && parseInt(this.percentage);
        }
    }
};
</script>
<style lang="css" scoped>
.circle-progress {
    position: relative;
    text-align: center;
}
.circle-progress:after {
    content: attr(data-pct);
    font-size: 36px;
    width:100%;
    position: absolute;
    top: 45%;
    left: 50%;
    transform: translate3d(-50%, -50%, 0);
}
.circle-progress:before {
    content: attr(data-pct-subtitle);
    font-size: 14px;
    font-weight: bold;
    width:100%;
    position: absolute;
    top: 65%;
    left: 50%;
    transform: translate3d(-50%, -50%, 0);
}
.circle-progress svg {
    transform: rotate(-90deg);
}
.circle-progress .progress_circle {
    stroke-linecap: round;
    transition: stroke-dashoffset 1s linear;
}
.circle-percentage {
    font-size: 75%;
}
</style>
