<template>
    <div class="w-[320px]">
        <VideoForAdmin
            :img="'/storage' + video.preview"
            :path="'/storage'+ video.path"
        />
        <div class="flex space-x-5">
            <div>
                <img @click="route.push(`/@${video.author.nickname}`)" :src="video.author.photo ? '/storage' + video.author.photo : defaultAvatar"  class="rounded-full object-cover w-[49px] h-[49px]" alt="">
            </div>
            <div class=" break-words w-[246px]">
                <h1>{{video.title}}</h1>
                <div>
                    <h1>{{video.author.nickname}}</h1>
                    <div>
                        <div>

                        </div>
                        <span>{{formatDate(video.created_at)}}</span>
                    </div>
                </div>
            </div>
        </div>

    </div>
</template>
<script setup>
import router from "@/js/route/index.js";

import VideoForAdmin from "@/components/Admin/VideoForAdmin.vue";
import formatDate from "@/js/helpler/date";
import defaultAvatar from "@/assets/user.jpg";
import route from "@/js/route/index.js";

const props = defineProps({
    video: Object,
});
</script>
