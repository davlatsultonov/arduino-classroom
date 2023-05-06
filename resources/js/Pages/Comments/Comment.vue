<template>
    <div
        class="comment-block pt-3"
        :class="[small ? 'my-1' : 'my-4 border-top']"
        :style="{
            marginLeft: leftIndent(comment.parent_id)
        }">

        <div class="d-flex align-items-start gap-3">
            <div class="d-flex align-items-center justify-content-center text-bg-light border text-dark rounded rounded-4"
                 :style="{
                    height: (small ? 40 : 60) + 'px',
                    width: (small ? 40 : 60) + 'px'
                 }">
                <span :class="[small ? 'fs-5' : 'fs-3']">{{ comment.user.name[0].toUpperCase() }}</span>
            </div>
            <div class="flex-grow-1">
                <h5 class="fw-semibold mb-1 d-flex align-items-center comment-block__user-name">
                    {{ comment.user.name }} <span class="text-secondary small ms-3" v-if="parentName">
                    <img src="/images/reply-icon.svg" class="comment-block__parent-name" width="13" alt="reply icon">{{ parentName }}
                </span>
                </h5>
                <div class="mb-2" style="font-size: 12px;">{{ formattedCommentCreationDate }}</div>
                <p class="text-secondary small mb-2">{{ comment.body }}</p>
                <button
                    class="btn btn-outline-dark btn-sm py-0 rounded-pill"
                    style="font-size: 12px"
                    @click="showReplySection = !showReplySection"
                >reply</button>
                <form
                    class="mt-3"
                    @submit.prevent="submit"
                    v-if="$page.props.shared.auth && showReplySection"
                >
                    <div class="form-group">
                        <textarea
                            type="text"
                            name="body"
                            class="form-control"
                            v-model="commentReplyForm.body"
                            placeholder="Ба шарҳ ҷавоб додан..."
                            :style="{
                                height: '50px',
                                resize: 'none',
                                fontSize: '14px'
                            }"
                        ></textarea>
                        <input type="hidden" name="article_id" v-model="commentReplyForm.article_id"/>
                        <input type="hidden" name="parent_id" v-model="commentReplyForm.parent_id"/>
                    </div>
                    <div class="form-group mt-3 d-flex justify-content-end">
                        <input type="submit" class="btn btn-sm btn-outline-dark" :value="`Ба ${comment.user.name} ҷавоб диҳед`"/>
                    </div>
                </form>
            </div>
        </div>

        <div class="my-2" v-if="replies.length">
            <div v-for="(sub_comment, index) in replies" :key="index">
                <Comment
                    v-bind="{
                        small: true,
                        articleId: articleId,
                        comment: sub_comment,
                        replies: sub_comment.replies,
                        parentName: comment.user.name,
                        firstBranch: !(comment.parent_id && sub_comment.parent_id)
                      }"
                />
            </div>
        </div>
    </div>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";
import moment from 'moment/min/moment-with-locales';

export default {
    name: "Comment",
    props: {
        firstBranch: {
            type: Boolean,
            default() {
                return false
            }
        },
        parentName: {
            type: String,
            default() {
                return ''
            }
        },
        articleId: {
            type: Number,
            required: true,
        },
        comment: {
            type: Object,
            required: true,
        },
        replies: {
            type: Array,
            default: () => [],
        },
        small: {
            type: Boolean,
            default: () => false,
        }
    },
    data() {
        return {
            commentReplyForm: useForm({
                body: null,
                article_id: this.articleId,
                parent_id: this.comment.id
            }),
            showReplySection: false,
        }
    },
    computed: {
        formattedCommentCreationDate() {
            moment.locale('tg');
            return moment(this.comment.created_at).fromNow();
        },
        leftIndent() {
            return (parentId) => {
                let result = 0;

                if (parentId) {
                    result = this.firstBranch ? '75px' : '50px';
                }

                return result
            }
        }
    },
    methods: {
        submit() {
            this.commentReplyForm.post('/comments', {
                onSuccess: () => {
                    this.commentReplyForm.reset();
                    this.showReplySection = false;
                },
                preserveScroll: true,
            });
        }
    }
}
</script>


<style scoped lang="scss">
.comment-block {

    &__user-name {
        color: #178589;
    }

    &__parent-name {
        padding-bottom: 3px;
        padding-right: 3px;
    }
}
</style>
