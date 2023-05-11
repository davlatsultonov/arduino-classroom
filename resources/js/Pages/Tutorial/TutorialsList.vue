<template>
    <template v-if="Object.keys(tutorials).length">
        <div class="my-4" v-for="(tutorial, key, index) in tutorials">
            <div class="row">
                <h6 class="fw-bold">{{ key }}</h6>

                <div class="col" v-for="(chunkItem, chunkItemIndex) in chunkItems(tutorial)">
                    <ul class="list-group mt-2 tutorial-list">
                        <li class="list-group-item px-0 py-1 border-0 d-flex align-items-start"
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
    </template>
    <div v-else class="alert alert-info text-center mt-4">
        Дар айни замон ягон мақола вуҷуд надорад
    </div>
</template>

<script>
import {Link} from "@inertiajs/inertia-vue3";

export default {
    name: "TutorialsList",
    components: {Link},
    props: {
        tutorials: {
            type: Object,
            default() {
                return {}
            }
        }
    },
    data() {
        return {
            chunkSize: 1
        }
    },
    computed: {
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


        &:hover {
            color: #c4433a;
        }
    }
}
</style>
