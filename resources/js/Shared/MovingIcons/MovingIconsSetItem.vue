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
        handleMouseEnter(e) {
            ++this.clickCount;
            const target = e.target;
            if (target.tagName === 'IMG') target.parentElement.classList.add('active')
            else target.classList.add('active')

            if (this.clickCount >= 2) {
                this.handleArduinoInfoPanelActivation()
            }
        },
        handleMouseLeave(e) {
            e.stopPropagation();
            e.target.classList.remove('active');
        },
        handleArduinoInfoPanelActivation() {
            this.emitter.emit(EMITTER_EVENT_NAMES['info-panel'], true);
            this.clickCount = 0;
        },
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
