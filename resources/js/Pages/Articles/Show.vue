<template>
    <div class="article"  ref="article">
        <Head>
            <title>Article</title>
        </Head>

        <Breadcrumb :breadcrumbs="breadcrumbs.breadcrumbs" />

        <div class="row justify-content-center " >
            <div class="col-md-8">
                <h2 class="mb-3">{{ article.name }}</h2>

                <p v-html="parsedText"></p>
            </div>
        </div>
    </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import Breadcrumb from "../../Shared/Breadcrumb.vue";
import MarkdownIt from 'markdown-it';
const md = new MarkdownIt();

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
    data() {
        return {
            readingTime: 4,
            time: 0,
            intervalId: null,
            pageLoadTime: Date.now(),
            isActive: true,
            hasScrolled: false
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
            return this.$page.props.auth;
        },
        isNewArticle() {
            return this.auth.read_articles.indexOf(this.article.id) === -1
        }
    },
    beforeUnmount() {
        this.stopScrollInit();
    },
    mounted() {
        if (this.auth.check && this.isNewArticle) {
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
