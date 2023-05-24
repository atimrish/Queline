import {defineStore} from "pinia";
import {ref} from "vue";
const url = "";

export const useVideoStore = defineStore("videoStore", {
    state: () => ({
        video: ref({}),
        categories: ref([{}]),
        currentVideo: ref({}),
    }),
    getters: {

    },
    actions: {
        async getVideoUser(nickname) {
            const res = await axios.get(`/api/@${nickname}/videos`);
            this.video =  res.data;
        },
        async getAllVideo() {
            const res = await axios.get('/api/videos');
            this.video = res.data;
        },
        async getVideo() {
            const res = await axios.get('/api/videos/hash');
            this.currentVideo = res.data;
        },
        async getCommentsVideo() {
            const res = await axios.get('/api/videos/hash/comments');
            this.currentVideo.comments = res.data;
        },
        async getCategories() {
            const res = await axios.get('/api/categories');
            const category =  res.data.data;
            console.log(category);
            this.categories =  category;
        },
        async getVideoByCategory() {
            const res = await axios.get('/api/videos/hash/comments');
            this.currentVideo.comments = res.data;
        },

    }
})
