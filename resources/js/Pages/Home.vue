<template>
    <Head>
        <title>Home Page</title>
    </Head>
    <div class="my-3 my-lg-5">
        <ContentContainer>
            <div class="row">
                <div class="col-12 order-1 order-lg-0 col-lg-6">
                    <h2 class="mb-3 fw-bold">Дарси Муосир Оид Ба Arduino</h2>
                    <p class="fs-5">
                        Аз асосҳо то мавзӯъҳои пешрафта бо тавзеҳоти оддӣ, вале муфассал.
                    </p>
                </div>
                <div class="col-12 col-lg-6 d-flex justify-content-end align-items-start">
                    <div
                        class="d-inline-flex justify-content-end mt-2 mb-4 mb-lg-5 small badge text-dark border border-secondary fw-semibold rounded-1"
                    >
                        Охирин навсозӣ 9 майи 2023
                    </div>

                    <!--                <div class="input-group">
                                        <input type="text" class="form-control" placeholder="Дар дастур ҷустуҷӯ кунед" aria-describedby="button-addon2">
                                        <button class="btn btn-dark font-monospace" type="button" id="button-addon2">Ҷустуҷӯ</button>
                                    </div>-->
                </div>
            </div>
            <div class="row">
                <div class="col mt-4 mb-3 mb-lg-5">
                    <h5 class="mb-3 fw-bold">Мундариҷа</h5>
                    <p>Курси асосӣ аз 2 қисм иборат аст, Ки JavaScript-ро ҳамчун забони барномасозӣ ва таҷрибаи браузер фаро мегиранд. Инчунин як силсилаи иловагии мақолаҳои мавзӯӣ мавҷуданд.</p>
                </div>
            </div>
            <div id="tutorial-map-nav-container" class="position-sticky top-0 bg-white">
                <nav id="tutorial-map-nav" class="navbar py-0 border-bottom">
                    <ul class="nav">
                        <li class="nav-item">
                            <a class="nav-link rounded-0 d-flex flex-column px-2 me-1 me-lg-3" href="#scroll-spy-heading-1">
                                <small class="d-block text-uppercase mb-1">Қисми 1</small>
                                <span class="d-block">Системаи Arduino</span>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link rounded-0 d-flex flex-column px-2 me-1 me-lg-3" href="#scroll-spy-heading-1">
                                <small class="d-block text-uppercase mb-1">Қисми 2</small>
                                <span class="d-block">Хонаи доно созед</span>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <div class="row mt-4 mb-5">
                <div class="col col-lg-9">
                    <h5 id="scroll-spy-heading-1" class="mt-3">Системаи Arduino</h5>
                    <div class="tutorials-list-container">
                        <TutorialsList :tutorials="$page.props.shared.tutorials"/>
                    </div>
                </div>
            </div>
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
import {EMITTER_EVENT_NAMES} from "../constants";

export default {
    layout: HomePageLayout,
    components: {InfoPanel, MovingIconsSetContainer, ContentContainer, TutorialsList, Accordion, Navbar, Head, Link},
    data() {
        return {
            hasReachedTarget: null,
            tutorialListHeadings: {},
            firstLoad: true,
            isInfoPanelOpen: false,
        }
    },
    mounted() {
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
                const offsetTop = Math.floor(item.getBoundingClientRect().top);
                if (this.firstLoad && index === 0) {
                    // Устанавливаем первый заголовок активным при первой загрузке
                    this.tutorialListHeadings[item.id] = true;
                    this.firstLoad = scrollSpyHeadings.length === 1; // Обновляем флаг firstLoad
                } else {
                    // Определяем, находится ли заголовок в требуемом диапазоне прокрутки
                    this.tutorialListHeadings[item.id] = offsetTop < 100 && offsetTop >= (tutorialListContainer[index].getBoundingClientRect().height - 40) * -1;
                }
                // Включаем или отключаем CSS-класс 'reached' у ссылки в навигации по карте учебника
                this.getTutorialMapNavLink(item.id).classList[this.tutorialListHeadings[item.id] ? 'add' : 'remove']('reached');
            });

            // Проверяем, достигла ли текущая позиция прокрутки цели
            this.hasReachedTarget = window.scrollY >= tutorialMapNavOffsetTop - documentBodyOffsetTop || window.pageYOffset >= tutorialMapNavOffsetTop - documentBodyOffsetTop;

            // Включаем или отключаем CSS-класс в зависимости от того, достигнута цель или нет
            tutorialMapNav.classList[this.hasReachedTarget ? 'remove' : 'add']('border-bottom');
        },
    },
    watch: {
        isInfoPanelOpen(value) {
            document.body.style.overflow = !value ? 'visible' : 'hidden'
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
