<template>
    <div class="article h-100"  ref="article">
        <Head>
            <title>{{ article.name }}</title>
        </Head>

        <div class="row h-100">
            <div class="col-md-2 headings-content text-bg-light" v-if="headingsContentActive">
                <div class="position-sticky headings-content-body rounded-1 pt-4 top-0" >
                    <h6>
                        <div class="text-secondary mb-1">Мавзӯъ:</div>
                    </h6>
                    <h5 class="mb-4 text-secondary">
                        <a class="nav-link fs-6 fw-semibold" :href="`#${article.slug}`">
                            {{ article.name }}
                        </a>
                    </h5>

                    <h6 class="text-secondary">Бахш</h6>
                    <div class="mb-4">
                        <p class="text-dark nav-link text-decoration-none">{{ article.sub_category.name }}</p>
                    </div>
                    <h6 class="pt-0 text-secondary">Дар ин саҳифа</h6>
                    <nav id="sidebar-nav" class="flex-column align-items-stretch">
                        <a class="nav-link pt-3"
                           :class="{
                                'ps-3': ['H3', 'H4', 'H5'].includes(item.tagName)
                           }"
                           v-for="item in headingIds" :href="`#${item.id}`"
                        >
                            {{ stringUpperFirstLetter(item.id.slice(3)).split('-').join(' ') }}
                        </a>
                    </nav>
                    <div class="mt-4 border-top py-3">
                        <a href="#comments" class="text-dark nav-link text-decoration-none">Шарҳҳо</a>
                    </div>
                </div>
            </div>
            <div :class="`col-lg-${headingsContentActive ? '10' : '12'}`">
                <div class="row justify-content-between pt-4">
                    <div class="col-1 ps-0 d-flex flex-column justify-content-start">
                        <button class="position-sticky btn btn-link headings-content-btn-toggle"
                                @click="headingsContentActive = !headingsContentActive"
                                :style="{
                                    top: '20px'
                                }"
                        >
                            <img src="/images/hamburger-menu.svg" width="20" alt="hamburger icon">
                        </button>

                        <button type="button"
                                :style="{
                                    top: '70px'
                                }"
                                class="position-sticky btn btn-link headings-content-btn-toggle"
                                data-bs-toggle="modal"
                                data-bs-target="#tutorial-map"
                                v-if="$page.component.startsWith('Tutorial')"
                        >
                            <img
                                data-bs-toggle="tooltip"
                                data-bs-title="Харитаи дарс"
                                data-bs-offset="0,10"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-placement="right"
                                @click="handleTooltipDispose"
                                src="/images/map-icon.png"
                                width="30"
                                alt="map icon">
                        </button>

                        <button type="button"
                                v-if="$page.props.shared.auth && hasCurrentArticleTests"
                                :style="{
                                    top: '120px'
                                }"
                                data-bs-toggle="modal"
                                data-bs-target="#test-modal"
                                class="position-sticky btn btn-link headings-content-btn-toggle"

                        >
                            <img
                                data-bs-toggle="tooltip"
                                data-bs-title="Худро бисанч"
                                data-bs-offset="0,10"
                                data-bs-custom-class="custom-tooltip"
                                data-bs-placement="right"
                                @click="handleTooltipDispose"
                                src="/images/test-icon.svg"
                                width="30"
                                alt="map icon">
                        </button>

                        <div class="modal fade" id="test-modal" tabindex="-1" role="dialog" aria-labelledby="test-modal" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                                <div class="modal-content">
                                    <div class="modal-body">
                                        <TestCategorySelector
                                            :external-settings="{
                                                sub_category_id: article.sub_category_id,
                                                test_id: getTestId
                                            }"
                                        />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <Link v-if="tutorialLinks?.prev?.url"
                              :href="tutorialLinks.prev.url"
                              data-bs-toggle="tooltip"
                              :data-bs-title="tutorialLinks.prev.title"
                              data-bs-placement="right"
                              data-bs-custom-class="custom-tooltip"
                              @click.native="handleTooltipDispose"
                              class="position-sticky top-50 btn btn-link page-pagination-btn rounded-0">
                            <img src="/images/arrow_left_single.svg" alt="arrow icon">
                        </Link>
                    </div>
                    <div class="col-7">
                        <div class="d-flex mb-5"
                             :class="`justify-content-${breadcrumbs ? 'between' : 'end'}`"
                        >
                            <Breadcrumb v-if="breadcrumbs" :breadcrumbs="breadcrumbs.breadcrumbs" />
                            <div class="border-bottom"
                                 data-bs-toggle="tooltip"
                                 data-bs-title="Охирин навсозӣ"
                                 data-bs-placement="bottom"
                                 data-bs-custom-class="custom-tooltip"
                            >
                                {{ formattedArticleUpdatedDate }}
                            </div>
                        </div>

                        <h1 :id="article.slug" class="mb-4">{{ article.name }}</h1>

                        <p v-html="parsedText"></p>

                        <div id="comments" class="d-flex align-items-center border-bottom w-100 mt-5 mb-3 pb-1 fw-bold">
                            Comments <div class="badge text-bg-dark ms-2">{{ article.comments_count  }}</div>
                        </div>


                        <div class="mt-4 mb-4">
                            <CommentAdd
                                :user-name="$page.props.shared.auth?.userName"
                                :article-id="article.id"
                                :can-leave-comment="$page.props.shared.auth !== null"
                            />
                        </div>

                        <div class="my-4">
                            <CommentDisplay
                                :comments="article.comments"
                                :article-id="article.id"
                            />
                        </div>

                    </div>
                    <div class="col-1 pe-0">
                        <button v-if="tutorialLinks?.next?.url"
                              data-bs-toggle="tooltip"
                              :data-bs-title="tutorialLinks.next.title"
                              data-bs-placement="left"
                              data-bs-custom-class="custom-tooltip"
                              @click="() => handleContinuationToNextArticle(tutorialLinks?.next?.url, tutorialLinks?.next?.isLast)"
                              class="float-end position-sticky top-50 btn btn-link page-pagination-btn rounded-0">
                            <img src="/images/arrow_right_single.svg" alt="arrow icon">
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <GoToTopBtn />
    </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import Breadcrumb from "../../Shared/Breadcrumb.vue";
import MarkdownIt from 'markdown-it';
import markdownItGithubHeadings from "markdown-it-github-headings";
import utilitiesMixin from "../../mixins/utilities-mixin";
import TutorialLayout from "../../Layouts/TutorialLayout.vue";
import moment from 'moment/min/moment-with-locales';
import tooltipMixin from "../../mixins/tooltip-mixin";
import CommentDisplay from "../Comments/CommentsDisplay.vue";
import CommentAdd from "../Comments/CommentAdd.vue";
import GoToTopBtn from "../../Shared/GoToTopBtn.vue";
import TestCategorySelector from "../Profile/Testing/TestCategorySelector.vue";
import { Fancybox } from "@fancyapps/ui";

// Cоздается экземпляр класса MarkdownIt и настраиваются его опции и правила рендеринга.
const md = new MarkdownIt().use(markdownItGithubHeadings, {
    prefix: 'ac-', // Префикс для идентификаторов заголовков
    enableHeadingLinkIcons: false // Отключение иконок для ссылок на заголовки
});

md.options.html = true; // Включение обработки HTML-тегов в Markdown

md.renderer.rules.image = (tokens, idx, options, env, self) => {
    // Переопределение правила рендеринга для тега изображения
    const token = tokens[idx];
    const src = token.attrs[token.attrIndex('src')][1]; // Получение значения атрибута src
    const alt = token.content; // Получение содержимого тега
    return `<a href="${src}" data-fancybox><img src="${src}"  alt="${alt}" class="d-block w-75 my-5 mx-auto border rounded shadow-sm"></a>`; // Возврат HTML-кода для изображения с заданными классами
};


export default {
    layout: TutorialLayout,
    components: {
        TestCategorySelector,
        GoToTopBtn, CommentAdd, CommentDisplay, Head, Link, Breadcrumb},
    props: ['article', 'breadcrumbs'],
    mixins: [utilitiesMixin, tooltipMixin],
    data() {
        return {
            readingTime: 4,
            time: 0,
            intervalId: null,
            pageLoadTime: Date.now(),
            isActive: true,
            hasScrolled: false,
            headingIds: [],
            headingsContentActive: true,
            url: '',
        };
    },
    computed: {
        tutorials() {
            return this.$page.props.shared.tutorials
        },
        parsedText() {
            // Возвращает отрендеренный Markdown текст статьи
            return md.render(this.article.description);
        },
        formattedArticleUpdatedDate() {
            // Форматирует дату обновления статьи в заданном формате
            moment.locale('tg'); // Устанавливает локаль для moment.js
            return moment(this.article.updated_at).format('LLLL');
        },
        formattedTime() {
            // Форматирует время в минуты и секунды на основе значения переменной time
            const minutes = Math.floor(this.time / 60000);
            const seconds = parseInt(((this.time % 60000) / 1000).toFixed(0));
            return {
                minutes,
                seconds
            };
        },
        auth() {
            // Возвращает значение свойства auth из общих свойств страницы
            return this.$page.props.shared.auth;
        },
        isNewArticle() {
            // Проверяет, является ли статья новой (не прочитанной)
            return this.auth?.read_articles.indexOf(this.article.id) === -1;
        },
        currentArticleTest() {
            return this.$page.props.shared.availableTests.find(item => item.description === this.article.name);
        },
        articles() {
            const articlesArr = []; // Создание пустого массива для статей
            const lastArticlesIndexes = []; // Создание пустого массива для индексов последних статей

            Object.values(this.tutorials).flat(1).forEach(sub_category => {
                // Перебор всех подкатегорий в объекте tutorials
                const articles = sub_category.articles; // Получение списка статей в текущей подкатегории
                const lastArticle = articles[articles.length - 1]; // Получение последней статьи в подкатегории

                lastArticlesIndexes.push(lastArticle); // Добавление индекса последней статьи в массив
                articlesArr.push(articles); // Добавление списка статей в массив
            });

            return [articlesArr.flat(1), lastArticlesIndexes]; // Возвращение массива статей и массива индексов последних статей
        },
        tutorialLinks() {
            const [articlesArr, lastArticlesIndexes] = this.articles; // Деструктуризация массива статей и массива индексов последних статей

            if (articlesArr.length < 2) return {}; // Если количество статей меньше 2, возвращается пустой объект

            const currentArticleIndex = articlesArr.findIndex(item => item.id === this.article.id); // Нахождение индекса текущей статьи в массиве
            const prevArticle = articlesArr[currentArticleIndex - 1]; // Получение предыдущей статьи
            const nextArticle = articlesArr[currentArticleIndex + 1] ?? articlesArr[0]; // Получение следующей статьи или первой статьи, если следующей нет
            const isFirst = currentArticleIndex === 0; // Проверка, является ли текущая статья первой

            return {
                prev: {
                    url: isFirst ? '/' : prevArticle.slug, // URL предыдущей статьи или главной страницы, если текущая статья первая
                    title: isFirst ? 'Домой' : prevArticle.name, // Заголовок предыдущей статьи или 'Домой', если текущая статья первая
                },
                next: {
                    url: nextArticle.slug, // URL следующей статьи
                    title: nextArticle.name, // Заголовок следующей статьи
                    isLast: this.currentArticleTest && lastArticlesIndexes.find(item => item.id === this.article.id) // Проверка, является ли текущая статья последней в списке последних статей
                }
            };
        },
        hasCurrentArticleTests() {
            // Проверяет, есть ли тесты для текущей статьи
            return this.$page.props.shared.availableTests.find(test => test.description === this.article.name);
        },
        getTestId() {
            // Возвращает идентификатор теста для текущей статьи
            return (this.$page.props.shared.availableTests.find(test => test.description === this.article.name))?.id;
        }
    },
    beforeUnmount() {
        // Выполняется перед удалением компонента
        this.stopScrollInit();
    },
    mounted() {
        Fancybox.bind("[data-fancybox]", {
            groupAll: true
        });

        // Находим все элементы, у которых id начинается с "ac-"
        document.querySelectorAll(`[id^="ac-"]`).forEach($item => {
            const $itemParent = $item.parentElement;

            // Добавляем классы к родительскому элементу $item
            // Если $itemParent является элементом H2, добавляем классы 'border-bottom', 'pb-2', 'mt-5'
            // В противном случае добавляем классы 'mt-4' и 'mb-3'
            [$itemParent.tagName === 'H2' ? ['border-bottom', 'pb-2', 'mt-5'] : ['mt-4'], 'mb-3'].flat(1).forEach(className => {
                $itemParent.classList.add(className);
            })

            // Добавляем объект с id и tagName в массив headingIds
            this.headingIds.push({
                id: $item.id,
                tagName: $itemParent.tagName
            })
        });

        // Проверяем, авторизован ли пользователь и является ли статья новой
        if (this.auth && this.isNewArticle) {
            // Устанавливаем интервал для обновления времени, если статья активна
            this.intervalId = setInterval(() => {
                if (this.isActive) {
                    this.time = Date.now() - this.pageLoadTime;
                }
            }, 1000);

            // Слушаем событие изменения видимости документа
            document.addEventListener("visibilitychange", () => {
                // Обновляем флаг активности в зависимости от видимости документа
                this.isActive = !document.hidden;
                if (this.isActive) {
                    this.pageLoadTime = Date.now() - this.time;
                }
            });

            // Находим элемент .footer
            const footer = document.querySelector(".footer");

            // Если элемент .footer найден, добавляем обработчик прокрутки
            if (footer) {
                window.addEventListener("scroll", this.throttle(() => {
                    this.handleScroll(footer);
                }, 1000));
            }
        }
    },
    methods: {
        handleContinuationToNextArticle(url, isLast) {
            if (!url) return;

            this.handleTooltipDispose()

            if (isLast && confirm('Ое шумо мехоҳед пеш аз гузаштан ба боби оянда дар ин бахш санҷиш гузаронед?')) {
                this.$inertia.get(route('profile.test.show', this.article.sub_category_id), {
                    sub_category_id: this.article.sub_category_id,
                    test_id: '*'
                });
            } else {
                this.$inertia.get(url);
            }
        },
        handleScroll(footer) {
            // Получаем позицию нижнего колонтитула относительно верхнего края окна просмотра, учитывая прокрутку
            const footerPosition = footer.getBoundingClientRect().top + window.scrollY;
            // Получаем значение прокрутки плюс высота окна просмотра
            const scrolled = window.scrollY + window.innerHeight;

            // Проверяем, достигла ли прокрутка нижней части страницы
            if (scrolled >= footerPosition) {
                // Проверяем, выполняются ли условия для выполнения дальнейших действий
                if (this.formattedTime.minutes >= this.readingTime && !this.hasScrolled) {
                    // Используем Inertia.js для отправки POST-запроса и обновления страницы
                    this.$inertia.visit(this.$page.url, {
                        method: 'post',
                        preserveScroll: true,
                        preserveState: true,
                        data: {
                            id: this.article.id
                        }
                    });

                    // Устанавливаем флаг hasScrolled в значение true
                    this.hasScrolled = true;
                    // Останавливаем инициализацию прокрутки
                    this.stopScrollInit();
                }
            }
        },
        stopScrollInit() {
            // Удаляем обработчик прокрутки
            window.removeEventListener("scroll", this.handleScroll);
            // Очищаем интервал, если он был установлен
            clearInterval(this.intervalId);
        },
        throttle(fn, wait) {
            let throttled = false;
            return function(...args) {
                if (!throttled) {
                    // Выполняем функцию
                    fn.apply(this, args);
                    // Устанавливаем флаг throttled в значение true
                    throttled = true;
                    setTimeout(() => {
                        // Сбрасываем флаг throttled после заданной задержки
                        throttled = false;
                    }, wait);
                }
            };
        }
    }
}
</script>

<style scoped lang="scss">
    #sidebar-nav {
        max-height: 55vh;
        height: 100%;
        overflow-y: auto;
    }

    .headings-content {

        .nav-link {
            font-size: 0.875rem;
            line-height: 1.3;
        }

        &-btn-toggle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 50px;
            height: 50px;
            border-radius: 100%;
            margin-left: 15px;

            &:hover {
                background-color: #eee;
            }
        }
    }

    .page-pagination-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        width: 80px;
        height: 80px;

        img {
            width: 40px;
        }

        &:hover {

            background-color: #eee;
        }
    }

    @media screen and (max-width: 992px) {
        .headings-content {
            position: fixed;
            bottom: 10px;
            left: 0;
            width: 100%;

            &-body, .btn {
                background-color: #00979d;
            }

            &, .nav-link {
                color: #fff !important;
            }
        }
    }
</style>
