<template>
    <div class="info-panel">
        <div class="info-panel__sidebar">
            <div v-for="(item, index) in panelData"
                 :class="{
                    'info-panel__item_active': index === activeId
                 }"
                 class="info-panel__item border-bottom" @click.stop="handleClick(index)">
                <img src="../../../../public/images/info-panel/ultra-sound.png" alt="ultra-sound icon">

                <button class="d-inline-flex align-items-center justify-content-center p-1 btn btn-light info-panel__item-btn border"
                        @click="initModel"
                        :disabled="index !== activeId"
                        v-if="item.hasModel">
                    <img src="../../../../public/images/3d-model-icon.svg" width="20" alt="3d model icon">
                </button>
            </div>
        </div>
        <div class="info-panel__content p-4 pl-5">
            <div class="mb-5 d-flex justify-content-end align-items-center">
                <span class="text-muted fw-semibold text-uppercase"><code class="px-2 fw-bold fs-6">ESC</code> to close</span>
                <button class="btn btn-light text-uppercase ms-3" @click="handleInfoPanelClose">
                    Close
                </button>
            </div>

            {{ panelData[activeId].content }}
        </div>
    </div>
</template>

<script>

import {EMITTER_EVENT_NAMES} from "../../constants";

export default {
    name: "InfoPanel",
    data() {
      return {
          activeId: 1,
          panelData: [
              {
                  id: 0,
                  imgSrc: '../../../../public/images/info-panel/ultra-sound.png',
                  content: 'Ultrasonic sensor for arduino',
                  hasModel: true
              },
              {
                  id: 1,
                  imgSrc: '../../../../public/images/info-panel/ultra-sound.png',
                  content: '13123',
                  hasModel: false
              },
              {
                  id: 2,
                  imgSrc: '../../../../public/images/info-panel/ultra-sound.png',
                  content: '234324',
                  hasModel: true
              },
              {
                  id: 3,
                  imgSrc: '../../../../public/images/info-panel/ultra-sound.png',
                  content: '13123',
                  hasModel: false
              },
              {
                  id: 4,
                  imgSrc: '../../../../public/images/info-panel/ultra-sound.png',
                  content: '435345345',
                  hasModel: false
              },
          ]
      }
    },
    computed: {
        imgSources() {
            return this.panelData.map(item => item.imgSrc)
        }
    },
    methods: {
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
    display: grid;
    grid-template-columns: 20% 1fr;
    z-index: 9999;
    position: fixed;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background-color: rgba(12, 12, 13, 0.95);

    &__sidebar {
        background-color: #fff;
        overflow-y: auto;
    }

    &__content {
        width: 100%;
        height: 100%;
        background-color: rgba(35, 78, 91, 0.70);
        color: #fff;
    }

    &__item {
        display: flex;
        align-items: center;
        justify-content: center;
        position: relative;
        cursor: pointer;
        width: 100%;
        height: 350px;

        img {
            width: 100%;
            user-select: none;
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

        &:hover::before {
            background-color: rgba(44, 67, 68, 0.4);
        }

        &_active {

            &::before, &:hover::before {
                background-color: transparent;
            }
        }
    }
}
</style>
