<template>
    <div class="d-flex align-items-start gap-3" v-if="canLeaveComment">
        <div class="d-flex align-items-center justify-content-center text-bg-light border text-dark rounded rounded-4"
             style="height: 60px; width: 60px;">
            <span class="fs-3">{{ userName[0].toUpperCase() }}</span>
        </div>
        <form class="flex-grow-1" @submit.prevent="submit">
            <div class="form-group">
                <textarea
                    class="form-control"
                    :class="{
                        'is-invalid': commentForm.errors.body
                    }"
                    name="body"
                    v-model="commentForm.body"
                    :style="{
                        height: '100px',
                        resize: 'none'
                    }"
                    placeholder="Шарҳ илова кунед..."
                ></textarea>
                <input type="hidden" name="article_id"
                       v-model="commentForm.article_id"/>
                <div class="invalid-feedback">
                    {{ commentForm.errors.body }}
                </div>
            </div>

            <div class="form-group mt-3">
                <input type="submit" class="btn btn-light w-100" value="Шарҳ гузоштан"/>
            </div>
        </form>
    </div>
    <div class="alert alert-primary text-center" role="alert" v-else>
        Шумо бояд сабти ном шуда бошед, то дар сайт шарҳ диҳед.
    </div>
</template>

<script>
import {useForm} from "@inertiajs/inertia-vue3";

export default {
    name: "CommentAdd",
    props: {
        canLeaveComment: {
            type: Boolean,
            default() {
                return false
            }
        },
        userName: String,
        articleId: Number
    },
    data() {
        return {
            commentForm: useForm({
                body: null,
                article_id: this.articleId
            }),
        }
    },
    methods: {
        submit() {
            this.commentForm.post('/comments', {
                onSuccess: () => this.commentForm.reset(),
                preserveScroll: true,
            });
        }
    }
}
</script>
