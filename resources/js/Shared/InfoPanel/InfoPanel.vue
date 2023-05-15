<template>
    <div class="info-panel">
        <div class="row h-100">
            <div class="col-12 col-sm-8 col-md-6 col-lg-6 h-100 pe-sm-0">
                <div class="info-panel__content">
                    <div class="d-flex align-items-center info-panel__title">
                        <button class="btn btn-light text-uppercase ms-3 d-inline-flex align-items-center border-3"
                                style="border-color: rgba(41, 120, 130, 1)"
                                @click="handleInfoPanelClose">
                            <code class="fw-bold pt-1">ESC</code>
                            <span class="vr mx-2"></span>
                            Close
                        </button>
                        <button class="ms-2 btn btn-light text-uppercase d-inline-flex d-sm-none align-items-center border-3"
                                style="border-color: rgba(41, 120, 130, 1)"
                                @click="toggleSideBarInMobile = !toggleSideBarInMobile">
                            Open sidebar
                        </button>
                    </div>

                    <div class="mt-5 p-4">
                        <h2 class="mb-4 px-2 rounded text-uppercase" style="background-color: rgba(41, 120, 130, 1)">{{ currentSensor.name }}</h2>

                        <iframe
                                v-if="isUserOnline && currentSensor.youtube"
                                class="rounded info-panel__video"
                                :src="currentSensor.youtube"
                                title="YouTube video player"
                                frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share"
                                allowfullscreen></iframe>

                        <p style="text-align: justify" class="mt-4" v-html="parsedText"></p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-sm-4 col-md-6 col-lg-6 h-100 ps-0">
                <div class="info-panel__sidebar d-sm-block h-100" :class="{
                        'd-none': toggleSideBarInMobile
                    }">
                    <div class="info-panel__sidebar-overlay" @click="toggleSideBarInMobile = true"></div>

                    <div class="info-panel__sidebar-inner h-100">
                        <div v-for="(item, index) in sensors"
                             :class="{
                            'info-panel__item_active': index === activeId
                         }"
                             class="info-panel__item border-bottom" @click.stop="handleClick(index)">
                            <div
                                class="info-panel__item-img"
                                :style="{
                                backgroundImage: `url('storage/${item.image}')`
                            }"
                                alt="ultra-sound icon">
                            </div>

                            <h6 class="info-panel__item-title d-none d-lg-block">
                                {{ item.name }}
                            </h6>
                            <button
                                class="d-inline-flex align-items-center justify-content-center p-1 btn btn-light info-panel__item-btn border"
                                @click="initModel"
                                :disabled="index !== activeId"
                                v-if="isUserOnline && item.hasModel">
                                <img src="../../../../public/images/3d-model-icon.svg" width="20" alt="3d model icon">
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {EMITTER_EVENT_NAMES} from "../../constants";
import MarkdownIt from "markdown-it";

const md = new MarkdownIt()

export default {
    name: "InfoPanel",
    data() {
        return {
            activeId: 0,
            toggleSideBarInMobile: false
        }
    },
    computed: {
        isUserOnline() {
            return navigator.onLine
        },
        parsedText() {
            // Возвращает отрендеренный Markdown текст статьи
            return md.render(this.currentSensor.description);
        },
        sensors() {
            return this.$page.props.shared.sensors
        },
        currentSensor() {
            return this.sensors[this.activeId]
        }
    },
    methods: {
        log() {
            console.log(21)
        },
        handleClick(id) {
            this.activeId = id;
        },
        initModel() {
            alert('Model initialized');
        },
        handleInfoPanelClose() {
            this.emitter.emit(EMITTER_EVENT_NAMES['info-panel'], false);
        },
        handleEscKey(event) {
            if (event.key === 'Escape') {
                this.handleInfoPanelClose()
            }
        }
    },
    mounted() {
        document.addEventListener('keydown', this.handleEscKey);
    },
    beforeUnmount() {
        document.removeEventListener('keydown', this.handleEscKey);
    },
}
</script>

<style scoped lang="scss">
.info-panel {
    z-index: 9999;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(41, 120, 130, 1);

    &__title {
        position: fixed;
        top: 10px;
    }

    &__sidebar {
        position: relative;

        &-overlay {
            display: none;
            position: absolute;
            left: -100px;
            top: 0;
            bottom: 0;
            right: 0;
            background-color: rgba(0, 0, 0, 0.70);
        }

        &-inner {
            overflow-y: auto;
            overflow-x: hidden;
            display: grid;
            grid-template-columns: 1fr 1fr;
            background-color: #fff;

            @media screen and (max-width: 768px) {
                grid-template-columns: 1fr
            }
        }

        @media screen and (max-width: 576px) {
            position: fixed;
            top: 0;
            right: 0;
            left: 100px;
            z-index: 200;

            &-overlay {
                display: block;
                z-index: 1;
            }
        }
    }

    &__content {
        width: 100%;
        height: 100%;
        overflow-x: hidden;
        overflow-y: auto;
        color: #fff;
    }

    &__video {
        width: 100%;
        height: 400px;

        @media screen and (max-width: 1200px) {
            height: 300px;
        }

        @media screen and (max-width: 576px) {
            height: 250px;
        }
    }

    &__item {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        z-index: 2;
        cursor: pointer;
        width: 100%;
        min-height: 320px;
        overflow: hidden;

        &-img {
            width: 100%;
            height: 100%;
            background-repeat: no-repeat;
            background-size: cover;
            background-position: center;
        }

        &-title {
            position: absolute;
            top: 20px;
            left: 20px;
            text-transform: uppercase;
            color: white;
            transition: transform .3s ease;
            transform: translateY(-100px);
            font-weight: bold;
        }

        &-btn {
            position: absolute;
            top: 10px;
            right: 10px;

            img {
                width: 90%;
            }
        }

        &::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            bottom: 0;
            right: 0;
            background-color: rgba(44, 67, 68, 0.6);
            transition: background-color .2s ease-in-out;
        }

        &:hover {

            &::before {
                background-color: rgba(44, 67, 68, 0.4);
            }

            .info-panel__item-title {
                transform: translateY(0);
            }
        }


        &_active {

            &::before, &:hover::before {
                background-color: transparent;
            }

            .info-panel__item-title {
                opacity: 0;
            }
        }

        @media screen and (max-width: 1200px) {
            min-height: 250px;
        }

        @media screen and (max-width: 992px) {
            min-height: 200px;
        }
    }
}
</style>
