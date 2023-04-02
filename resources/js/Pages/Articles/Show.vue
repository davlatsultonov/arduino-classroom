<template>
    <div class="markdown-content">
        <Head>
            <title>Article</title>
        </Head>

        <div class="row justify-content-center ">
            <div class="col-md-8">
                <h2 class="mb-3">{{ article.name }}</h2>

                <p v-html="parsedText"></p>
            </div>
        </div>
    </div>
</template>
<script>
import {Head, Link} from "@inertiajs/inertia-vue3";
import MarkdownIt from 'markdown-it'
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
    components: {Head, Link},
    props: ['article'],
    computed: {
        parsedText () {
            return md.render(this.article.description)
        }
    }
}
</script>
