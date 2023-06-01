<template>
    <Head>
        <title>Home Page</title>
    </Head>
    <div class="mb-3 mb-lg-3">
        <div class="container-fluid">
            <div class="row my-5 align-items-center">
                <div class="col-12 col-md-4 offset-md-1">
                    <SliderCube :items="iotArticlesThumbnails"/>
                </div>
                <div class="d-none d-md-block col-md-6 position-relative">
                    <img class="w-100 d-block" src="/images/arduino-examples.png" alt="arduino example">
                </div>
            </div>
        </div>
        <ContentContainer class="py-1 py-lg-4">
            <div class="pb-4 mb-3">
                <h1 class="display-4 mb-3 fw-bold text-dark fw-semibold">Дарси муосир оид ба системахои <span class="fw-bold" style="color: #00979d">Arduino</span> ва <span class="fw-bold" style="color: #00979d">Raspberry Pi</span></h1>
                <p class="fs-5">
                    Аз асосҳо то мавзӯъҳои пешрафта бо тавзеҳоти оддӣ, вале муфассал.
                </p>
            </div>
            <div id="tutorial-map-nav-container" class="position-sticky top-0 bg-white">
                <nav id="tutorial-map-nav" class="navbar py-0 border-bottom">
                    <ul class="nav">
                        <li class="nav-item" v-for="({name, slug}, index) in $page.props.shared.categories">
                            <a class="nav-link rounded-0 d-flex flex-column px-2 me-1 me-lg-3" :href="`#scroll-spy-heading-${slug}`">
                                <small class="d-block text-uppercase mb-1">Қисми {{ index + 1 }}</small>
                                <span class="d-block">{{ name }}</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row mt-4 mb-5">
                <div class="col col-lg-9">
                    <TutorialsList/>
                </div>
            </div>

            <BooksList />
        </ContentContainer>

        <MovingIconsSetContainer />
        <Transition>
            <InfoPanel v-if="isInfoPanelOpen" />
        </Transition>
    </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import Navbar from "../Shared/Navbar.vue";
import Accordion from "../Shared/Accordion.vue";
import TutorialsList from "./Tutorial/TutorialsList.vue";
import HomePageLayout from "../Layouts/HomePageLayout.vue";
import ContentContainer from "../Shared/ContentContainer.vue";
import MovingIconsSetContainer from "../Shared/MovingIcons/MovingIconsSetContainer.vue";
import InfoPanel from "../Shared/InfoPanel/InfoPanel.vue";
import {EMITTER_EVENT_NAMES} from "../constants/index";
import SliderCube from "../Shared/Slider/SliderCube.vue";
import BooksList from "@/Shared/BooksList.vue";

export default {
    layout: HomePageLayout,
    components: {
        BooksList,
        SliderCube,
        InfoPanel, MovingIconsSetContainer, ContentContainer, TutorialsList, Accordion, Navbar, Head, Link},
    props: {
        iotArticlesThumbnails: Array
    },
    data() {
        return {
            hasReachedTarget: null,
            tutorialListHeadings: {},
            firstLoad: true,
            isInfoPanelOpen: false,
        }
    },
    mounted() {
        // Устанавливаем обработчик события "info-panel" для открытия/закрытия информационной панели
        this.emitter.on(EMITTER_EVENT_NAMES['info-panel'], isInfoPanelOpen => {
            this.isInfoPanelOpen = isInfoPanelOpen;
        });

        // Получаем ссылки на необходимые элементы
        const $tutorialMapNav = document.getElementById('tutorial-map-nav');
        const $scrollSpyHeadings = document.querySelectorAll('[id^="scroll-spy-heading-"]');
        const $tutorialListContainer = document.querySelectorAll('.tutorials-list-container');

        // Вызываем функцию scrollSpyCheck для инициализации пользовательского интерфейса на основе начальной позиции прокрутки
        this.scrollSpyCheck($tutorialMapNav, $scrollSpyHeadings, $tutorialListContainer);

        // Добавляем слушателя события прокрутки, если есть несколько заголовков scrollSpyHeadings
        if ($scrollSpyHeadings.length > 1) {
            window.onscroll = () => this.scrollSpyCheck($tutorialMapNav, $scrollSpyHeadings, $tutorialListContainer);
        }
    },
    computed: {
        getTutorialMapNavLink() {
            // Возвращаем функцию, которая принимает параметр 'id'
            return function (id) {
                // Используем document.querySelector для поиска элемента с 'href', начинающимся с указанного 'id'
                return document.querySelector(`[href^="#${id}"]`);
            };
        }
    },
    methods: {
        scrollSpyCheck(tutorialMapNav, scrollSpyHeadings, tutorialListContainer) {
            // Получаем значения смещения для tutorialMapNav и всего документа
            const tutorialMapNavOffsetTop = tutorialMapNav.getBoundingClientRect().top;
            const documentBodyOffsetTop = document.body.getBoundingClientRect().top;

            // Перебираем scrollSpyHeadings и обновляем пользовательский интерфейс в зависимости от позиции прокрутки
            scrollSpyHeadings.forEach((item, index) => {
                const scrollSpyHeadingOffsetTop = Math.floor(item.getBoundingClientRect().top);
                if (this.firstLoad && index === 0) {
                    // Устанавливаем первый заголовок активным при первой загрузке
                    this.tutorialListHeadings[item.id] = true;
                    this.firstLoad = scrollSpyHeadings.length === 1; // Обновляем флаг firstLoad
                } else {
                    // Определяем, находится ли заголовок в требуемом диапазоне прокрутки
                    this.tutorialListHeadings[item.id] = scrollSpyHeadingOffsetTop <= 60 && scrollSpyHeadingOffsetTop - 60 >= (tutorialListContainer[index].getBoundingClientRect().height) * -1;
                }
                // Включаем или отключаем CSS-класс 'reached' у ссылки в навигации по карте учебника
                this.getTutorialMapNavLink(item.id).classList[this.tutorialListHeadings[item.id] ? 'add' : 'remove']('reached');
            });

            // Проверяем, достигла ли текущая позиция прокрутки цели
            this.hasReachedTarget = window.scrollY >= tutorialMapNavOffsetTop - documentBodyOffsetTop || window.pageYOffset >= tutorialMapNavOffsetTop - documentBodyOffsetTop;
        },
    },
    watch: {
        isInfoPanelOpen(value) {
            // Устанавливаем свойство overflow стиля body в 'visible' или 'hidden' в зависимости от значения isInfoPanelOpen
            document.body.style.overflow = !value ? 'visible' : 'hidden';
        }
    }
}
</script>

<style lang="scss">
#tutorial-map-nav-container {
    z-index: 100;
    border-width: 3px !important;
    border-color: rgba(0, 151, 157, 22%) !important;

    #tutorial-map-nav {
        border-width: 2px !important;
        border-color: rgba(0, 151, 157, 22%) !important;
    }

    .nav-link {
        margin-bottom: -2px;
        color: #313130;

        small {
            font-size: 12px;
        }

        span {
            font-weight: 500;
            font-size: 16px;
            line-height: 24px;
            letter-spacing: 1px;

            @media screen and (max-width: 576px) {
                font-size: 14px;
                line-height: 22px;
            }
        }

        &.reached {
            border-bottom: 2px solid #00979d;
            color: #00979d;
        }
    }
}
</style>
