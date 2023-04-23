<template>
    <div class="article"  ref="article">
        <Head>
            <title>{{ article.name }}</title>
        </Head>

        <Breadcrumb v-if="breadcrumbs" :breadcrumbs="breadcrumbs.breadcrumbs" />

        <div class="row">
            <div :class="`col${ headingIds.length ? '-lg-9' : null }`">
                <h1 class="mb-3">{{ article.name }}</h1>

                <p v-html="parsedText"></p>
            </div>
            <div class="col-md-3 headings-content" v-if="headingIds.length">
                <button class="d-lg-none btn btn-secondary fw-bold border-0" @click="headingsContentActive = !headingsContentActive">Содержание</button>

                <div class="position-sticky headings-content-body mt-2 p-3 rounded-1" style="top: 15px;" v-if="headingsContentActive">
                    <h5 class="pt-0 pb-2 border-bottom border-2 border-dark">На этой странице</h5>
                    <nav id="navbar-example3" class="flex-column align-items-stretch pe-4">
                        <nav class="nav nav-pills flex-column">
                            <a class="nav-link fw-semibold text-secondary text-sm ps-1 py-1" v-for="id in headingIds"
                               :href="`#${id}`">
                                {{ stringUpperFirstLetter(id.slice(3)).split('-').join(' ') }}
                            </a>
                        </nav>
                    </nav>
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

import utilityMixins from "../../mixins/utility-mixins";
const md = new MarkdownIt().use(markdownItGithubHeadings, {
    prefix: 'ac-',
    enableHeadingLinkIcons: false
});

md.renderer.rules.image = (tokens, idx, options, env, self) => {
    const token = tokens[idx];
    const src = token.attrs[token.attrIndex('src')][1];
    const alt = token.content;
    const style = 'display: block; margin: 0 auto; width: 50%; height: auto;';
    const className = 'my-custom-class';
    return `<img src="${src}"  alt="${alt}" style="${style}" class="${className}">`;
};

export default {
    components: {Head, Link, Breadcrumb},
    props: ['article', 'breadcrumbs'],
    mixins: [utilityMixins],
    data() {
        return {
            readingTime: 4,
            time: 0,
            intervalId: null,
            pageLoadTime: Date.now(),
            isActive: true,
            hasScrolled: false,
            headingIds: [],
            headingsContentActive: true

        };
    },
    computed: {
        parsedText () {
            return md.render(this.article.description)
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

        if (window.innerWidth < 992) {
            this.headingsContentActive = false;
        }

        window.addEventListener('resize', () => {
            if (window.innerWidth >= 992) {
                this.headingsContentActive = true
            }
        })
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
