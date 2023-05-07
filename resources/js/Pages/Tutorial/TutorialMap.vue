<template>
    <div class="modal fade" id="tutorial-map" tabindex="-1" aria-labelledby="tutorial-map" aria-hidden="true">
        <div class="modal-dialog modal-fullscreen">
            <div class="modal-content">
                <div class="modal-header shadow-sm">
                    <div class="container d-flex justify-content-end">
                        <button type="button" class="btn btn-outline-light" data-bs-dismiss="modal">
                            <img src="/images/close-icon.svg" width="15" alt="close icon">
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="container">
                        <template v-if="Object.keys(tutorials).length">
                            <div class="my-4" v-for="(tutorial, key) in tutorials">
                                <h4 class="border-bottom pb-3 fw-bold">{{ key }}</h4>
                                <div class="row">
                                    <div class="col" v-for="(chunkItem, chunkItemIndex) in chunkItems(tutorial)">
                                        <ul class="list-group mt-2">
                                            <li class="list-group-item list-group-item-action p-0 border-0 rounded-2 "
                                                v-for="(link, itemIndex) in chunkItem"
                                                data-bs-dismiss="modal"
                                            >
                                                <Link
                                                    :class="[
                                                  'fw-semibold text-decoration-none p-1 px-2 d-block w-100 text-dark small',
                                                  currentPageUrl === link.slug ? 'active' : null
                                              ]"

                                                    :href="'/tutorial/' + link.slug"
                                                >{{ itemIndex + 1 + (chunkItemIndex * chunkSize) }}. {{ link.name }}
                                                </Link>
                                            </li>
                                        </ul>
                                    </div>
                                </div>

                            </div>
                        </template>
                        <div v-else class="d-flex align-items-center justify-content-center">
                            No tutorials.
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</template>

<script>
import {Link} from '@inertiajs/inertia-vue3';

export default {
    name: "TutorialMap",
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
            chunkSize: 3
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
.modal-header {
    z-index: 500;
}
</style>
