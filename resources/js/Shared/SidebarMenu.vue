<template>
    <div class="accordion position-sticky" style="top: 15px;">
        <div class="accordion-item border-0" v-for="(item, key, index) in tutorials">
            <h2 class="accordion-header" :id="accordionId(index, 'heading')">
                <button :class="[
                            'accordion-button fw-bold py-2 px-0 border-bottom rounded-0',
                            isEqualToCurrentPage(item) ? '' : 'collapsed'
                        ]"
                        type="button"
                        data-bs-toggle="collapse"
                        :data-bs-target="'#' + accordionId(index, 'collapse')"
                        :aria-expanded="isEqualToCurrentPage(item)"
                        :aria-controls="accordionId(index, 'collapse')">
                    {{ key.toUpperCase() }}
                </button>
            </h2>
            <div :id="accordionId(index, 'collapse')"
                 :class="[
                     'accordion-collapse collapse',
                     isEqualToCurrentPage(item) ? 'show' : null
                 ]"
                 :aria-labelledby="accordionId(index, 'heading')"
            >
                <div class="accordion-body p-0 py-2">
                    <ul class="list-group">
                        <Link
                            :class="[
                                  'list-group-item list-group-item-action fw-semibold rounded-2 ps-3 py-1 border-0 small',
                                  currentPageUrl === link.slug ? 'active' : null
                              ]"
                            v-for="link in item"
                            :href="'/tutorial/' + link.slug"
                        >{{ link.name }}
                        </Link>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';

export default {
    name: "SidebarMenu",
    components: {Link},
    props: ['tutorials'],
    computed: {
        accordionId() {
            return function (index, type) {
                return `accordion-${type}-id-` + index
            }
        },
        currentPageUrl() {
            return this.$page.url.slice(this.$page.url.lastIndexOf('/') + 1);
        },
        isEqualToCurrentPage() {
            return function (articles) {
                return articles.some(article => article.slug === this.currentPageUrl);
            }
        }
    }
}
</script>

<style scoped lang="scss">
.accordion-button:not(.collapsed) {
    background-color: transparent;
    color: #00979d;
    box-shadow: none;
    border-color: #00979d;

    &::after {
        content: '';
        background-image: url("/public/images/arrow_down_blue.svg");
    }
}

.accordion-body .list-group-item.active {
    background-color: transparent;
    color: #00979d;
}
</style>
