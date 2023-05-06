<template>
    <Comment v-for="comment in comments" :comment="comment" :replies="comment.replies" :article-id="articleId" />
</template>

<script>
import Comment from "./Comment.vue";

export default {
    name: "CommentsDisplay",
    components: {Comment},
    props: {
        articleId: Number,
        comments: {
            type: Array,
            default() {
                return []
            }
        }
    }
}
</script>
