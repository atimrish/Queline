<template>
    <div class="w-full flex my-6">
        <div class="w-[62px] h-[62px] rounded-full bg-gray mr-6 overflow-hidden">
            <img :src="user.photo ? '/storage' + user.photo : defaultAvatar" alt="" class=" rounded-full w-[62px] h-[62px] object-cover">
        </div>
        <div class="text-start">
            <h4>{{ user.nickname }} &middot; <span>{{ formatDate(user.created_at) }}</span></h4>
            <div>{{ user.text }}</div>
            <div class="flex justify-between w-fit my-2 bg-gray rounded-full py-1 px-3">
                <CommentLike
                    :count="user.grades.likes.length"
                    @commentLike="setLike"
                    :is-graded="isLiked(user.grades.likes)"
                ></CommentLike>
                <div class="line-clamp-1 w-0.5 bg-white shrink-0"></div>
                <CommentDislike
                    :count="user.grades.dislikes.length"
                    @commentDislike="setDislike"
                    :is-graded="isDisliked(user.grades.dislikes)"
                ></CommentDislike>
            </div>
        </div>
    </div>
</template>
<script setup>
import {useVideoStore} from "@/js/store/video";
import formatDate from "@/js/helpler/date";
import CommentLike from "@/components/Comment/CommentLike.vue";
import CommentDislike from "@/components/Comment/CommentDislike.vue";
import {useRoute} from "vue-router";
import defaultAvatar from "@/assets/user.jpg";
import {ref} from "vue";

const props = defineProps({
    user: Object,
});
const route = useRoute();
const hash_id = route.params.hash_id;

const video = useVideoStore();

const liked = ref(false);
const disliked = ref(false);

const isLiked = (data) => {
    liked.value = Boolean(data.find(item => item.nickname === localStorage.getItem('nickname')))
    return Boolean(data.find(item => item.nickname === localStorage.getItem('nickname')))
}

const isDisliked = (data) => {
    disliked.value = Boolean(data.find(item => item.nickname === localStorage.getItem('nickname')))
    return Boolean(data.find(item => item.nickname === localStorage.getItem('nickname')))
}

const setLike = () => {
    if (liked.value) {
        video.deleteCommentGrade(props.user.id, hash_id)
    } else if (disliked.value) {
        video.changeCommentGrade(props.user.id, 1, hash_id)
    } else {
        video.setCommentGrade(props.user.id, 1, hash_id);
    }
}

const setDislike = () => {
    if (disliked.value) {
        video.deleteCommentGrade(props.user.id, hash_id)
    } else if (liked.value) {
        video.changeCommentGrade(props.user.id, 2, hash_id)
    } else {
        video.setCommentGrade(props.user.id, 2, hash_id);
    }
}



</script>
