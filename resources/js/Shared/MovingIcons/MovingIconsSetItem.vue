<template>
    <div class="moving-icons-set__item"  @click="handleMouseEnter" @mouseleave="handleMouseLeave">
        <img :src="src" :alt="alt" >
    </div>
</template>

<script>
import {EMITTER_EVENT_NAMES} from "../../constants";

export default {
    name: "MovingIconsSetItem",
    props: ['src', 'alt'],
    data() {
        return {
            clickCount: 0
        }
    },
    methods: {
        // Обработчик события mouseenter
        handleMouseEnter(e) {
            // Увеличиваем счетчик кликов
            ++this.clickCount;
            const target = e.target;
            if (target.tagName === 'IMG') {
                // Добавляем CSS-класс 'active' родительскому элементу, если цель - изображение
                target.parentElement.classList.add('active');
            } else {
                // Добавляем CSS-класс 'active' целевому элементу
                target.classList.add('active');
            }

            if (this.clickCount >= 2) {
                // Активируем панель информации Arduino при достижении определенного количества кликов
                this.handleArduinoInfoPanelActivation();
            }
        },
        // Обработчик события mouseleave
        handleMouseLeave(e) {
            // Остановка всплытия события
            e.stopPropagation();
            // Удаляем CSS-класс 'active' с целевого элемента
            e.target.classList.remove('active');
            // Сбрасываем счетчик кликов
            this.resetClick();
        },
        // Активирует панель информации Arduino
        handleArduinoInfoPanelActivation() {
            // Излучает событие для активации панели информации Arduino
            this.emitter.emit(EMITTER_EVENT_NAMES['info-panel'], true);
            // Сбрасываем счетчик кликов
            this.resetClick();
        },
        // Сбрасывает счетчик кликов в 0
        resetClick() {
            this.clickCount = 0;
        }
    }
}
</script>

<style scoped lang="scss">
.moving-icons-set__item {
    display: flex;
    align-items: center;
    justify-content: center;
    min-width: 100px;
    border-radius: 100%;
    height: 100px;
    padding: 0 15px;
    opacity: 0.009;
    cursor: pointer;
    border: 1px solid transparent;
    transition: all 100ms linear;

    &:hover {
        opacity: 0.09;
    }

    &.active {
        border-color: #000;
        opacity: 1;

        img {
            transform: rotate(30deg)
        }

        &:active {
            transform: scale(0.8);
        }
    }


    img {
        width: 60px;
        height: 60px;
        user-select: none;
        animation-delay: -30s;
        transition: transform 200ms ease-in;
    }
}
</style>
