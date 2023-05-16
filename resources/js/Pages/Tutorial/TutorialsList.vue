<template>
    <div class="tutorials-list-container" v-if="Object.keys(tutorials).length">
        <div v-for="(value, key, index) in tutorials" class="mb-3 pb-3">
            <div class="h3 mb-3" :id="`scroll-spy-heading-${$page.props.shared.categories[index].slug}`">{{ key }}</div>
            <div class="my-4" v-for="(item, index) in value">
                <div class="row">
                    <div class="h6 fw-semibold mb-2">
                        {{ item.name }}
                    </div>
                    <div class="col" v-for="(chunkItem, chunkItemIndex) in chunkItems(item.articles)">
                        <ul class="list-group mt-2 tutorial-list">
                            <li class="list-group-item px-0 py-1 border-0 d-flex align-items-start bg-transparent"
                                v-for="(link, itemIndex) in chunkItem"
                                data-bs-dismiss="modal"
                            >
                                <span class="text-dark font-monospace small mr-1">{{ index + 1 }}.{{ itemIndex + 1 + (chunkItemIndex * chunkSize) }}.</span>
                                <Link
                                    :class="[
                                  'text-decoration-none small font-monospace tutorial-list__link ps-1',
                                  currentPageUrl === link.slug ? 'active' : null
                              ]"

                                    :href="'/tutorials/' + link.slug"
                                >{{ link.name }}
                                </Link>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div v-else class="alert alert-info text-center mt-4">
        Дар айни замон ягон мақола вуҷуд надорад
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "TutorialsList",
    components: {Link},
    data() {
        return {
            chunkSize: 1
        }
    },
    computed: {
        tutorials() {
            return this.$page.props.shared.tutorials;
        },
        currentPageUrl() {
            return this.$page.url.slice(this.$page.url.lastIndexOf('/') + 1);
        },
        chunkItems() {
            return (items) => {
                const result = [];

                if (items.length > 9) {
                    this.chunkSize = Math.ceil(items.length / 3);
                } else {
                    this.chunkSize = Math.ceil(items.length / (items.length <= 3) ? 3 : 2);
                }


                if (this.chunkSize > 0) {
                    for (let i = 0; i < items.length; i += this.chunkSize) {
                        result.push(items.slice(i, i + this.chunkSize))
                    }
                }

                return result;
            }
        }
    }
}
</script>

<style scoped lang="scss">
.tutorial-list {


    &__link {
        color: #436ebd;

        &:hover {
            color: #c4433a;
            text-decoration: underline !important;
        }
    }
}
</style>
