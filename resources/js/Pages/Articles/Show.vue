<template>
    <div class="article h-100"  ref="article">
        <Head>
            <title>{{ article.name }}</title>
        </Head>

        <div class="row h-100">
            <div class="col-md-2 headings-content text-bg-light" v-if="headingsContentActive">
                <div class="position-sticky headings-content-body rounded-1 pt-4 top-0">
                    <h6 class="pt-0 text-secondary">Дар ин саҳифа</h6>
                    <nav id="navbar-example3" class="flex-column align-items-stretch">
                        <a class="nav-link pt-2" v-for="id in headingIds"
                           :href="`#${id}`">
                            {{ stringUpperFirstLetter(id.slice(3)).split('-').join(' ') }}
                        </a>
                    </nav>
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
                                        <TestBody
                                            :current-article-test-settings="{
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
                        <div class="d-flex mb-4"
                             :class="`justify-content-${breadcrumbs ? 'between' : 'end'}`"
                        >
                            <Breadcrumb v-if="breadcrumbs" :breadcrumbs="breadcrumbs.breadcrumbs" />
                            <div class="fst-italic"
                                 data-bs-toggle="tooltip"
                                 data-bs-title="Охирин навсозӣ"
                                 data-bs-placement="bottom"
                                 data-bs-custom-class="custom-tooltip"
                            >
                                {{ formattedArticleUpdatedDate }}
                            </div>
                        </div>

                        <h1 class="mb-4">{{ article.name }}</h1>

                        <p v-html="parsedText"></p>

                        <div class="d-flex align-items-center border-bottom w-100 mt-5 mb-3 pb-1 fw-bold">
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
                        <Link v-if="tutorialLinks?.next?.url"
                              :href="tutorialLinks.next.url"
                              data-bs-toggle="tooltip"
                              :data-bs-title="tutorialLinks.next.title"
                              data-bs-placement="left"
                              data-bs-custom-class="custom-tooltip"
                              @click.native="handleTooltipDispose"
                              class="float-end position-sticky top-50 btn btn-link page-pagination-btn rounded-0">
                            <img src="/images/arrow_right_single.svg" alt="arrow icon">
                        </Link>
                    </div>
                </div>
            </div>
        </div>
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
import TestIndex from "../Profile/Testing/TestIndex.vue";
import TestBody from "../Profile/Testing/TestBody.vue";
const md = new MarkdownIt().use(markdownItGithubHeadings, {
    prefix: 'ac-',
    enableHeadingLinkIcons: false
});

md.renderer.rules.image = (tokens, idx, options, env, self) => {
    const token = tokens[idx];
    const src = token.attrs[token.attrIndex('src')][1];
    const alt = token.content;
    const style = 'display: block; margin: 24px auto; width: 50%; height: auto;';
    const className = 'my-custom-class';
    return `<img src="${src}"  alt="${alt}" style="${style}" class="${className}">`;
};

export default {
    layout: TutorialLayout,
    components: {TestBody, TestIndex, CommentAdd, CommentDisplay, Head, Link, Breadcrumb},
    props: ['article', 'breadcrumbs', 'tutorials'],
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
        parsedText () {
            return md.render(this.article.description)
        },
        formattedArticleUpdatedDate() {
            moment.locale('tg');
            return moment(this.article.updated_at).format('LLLL');
        },
        formattedTime() {
            const minutes = Math.floor(this.time / 60000);
            const seconds = parseInt(((this.time % 60000) / 1000).toFixed(0));
            return {
                minutes, seconds
            };
        },
        auth() {
            return this.$page.props.shared.auth;
        },
        isNewArticle() {
            return this.auth?.read_articles.indexOf(this.article.id) === -1
        },
        tutorialLinks: function () {
            if (Object.values(this.tutorials).flat(1).length < 2) return {};
            const links = (Object.values(this.tutorials).flat()).map(tutorial => tutorial.slug);
            const indexOf = links.indexOf(this.article.slug);
            const isFirst = indexOf === 0;

            return {
                prev: {
                    url: isFirst ? '/' : links[indexOf - 1],
                    title: isFirst ? 'Домой' : Object.values(this.tutorials).flat()[indexOf - 1].name
                },
                next: {
                    url: links[indexOf + 1] ? links[indexOf + 1] : links[0],
                    title: Object.values(this.tutorials).flat()[links[indexOf + 1] ? indexOf + 1 : 0].name
                }
            }
        },
        hasCurrentArticleTests() {
            return this.$page.props.shared.availableTests.find(test => test.description === this.article.name)
        },
        getTestId() {
            return (this.$page.props.shared.availableTests.find(test => test.description === this.article.name))?.id
        }
    },
    beforeUnmount() {
        this.stopScrollInit();
    },
    mounted() {
        document.querySelectorAll(`[id^="ac-"]`).forEach(item => this.headingIds.push(item.id));

        if (this.auth && this.isNewArticle) {
            this.intervalId = setInterval(() => {
                if (this.isActive) {
                    this.time = Date.now() - this.pageLoadTime;
                }
            }, 1000);

            document.addEventListener("visibilitychange", () => {
                this.isActive = !document.hidden;
                if (this.isActive) {
                    this.pageLoadTime = Date.now() - this.time;
                }
            });

            const footer = document.querySelector(".footer");

            if (footer) {
                window.addEventListener("scroll", this.throttle(() => {
                    this.handleScroll(footer)
                }, 1000));
            }
        }
    },
    methods: {
        handleScroll(footer) {
            const footerPosition = footer.getBoundingClientRect().top + window.scrollY;
            const scrolled = window.scrollY + window.innerHeight;

            if (scrolled >= footerPosition) {
                if (this.formattedTime.minutes >= this.readingTime && !this.hasScrolled) {
                    this.$inertia.visit(this.$page.url, {
                        method: 'post',
                        preserveScroll: true,
                        preserveState: true,
                        data: {
                            id: this.article.id
                        }
                    })

                    this.hasScrolled = true;
                    this.stopScrollInit();
                }
            }
        },
        stopScrollInit() {
            window.removeEventListener("scroll", this.handleScroll);
            clearInterval(this.intervalId);
        },
        throttle(fn, wait) {
            let throttled = false;
            return function(...args){
                if(!throttled){
                    fn.apply(this,args);
                    throttled = true;
                    setTimeout(()=>{
                        throttled = false;
                    }, wait);
                }
            }
        }
    }
}
</script>

<style scoped lang="scss">
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
        height: 60px;

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
