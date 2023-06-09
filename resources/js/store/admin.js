import { defineStore } from "pinia";
import {ref} from "vue";

export const useAdminStore = defineStore("admin", {
    state: () => ({
        admin: ref({}),
        videosForAdmin: ref({}),
        users: ref({}),
    }),
    actions: {
        async fetchAdmin() {
            if(!localStorage.getItem('user_token')) {
                return;
            }
            const res = await axios.get("/api/user/me",
                {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('user_token')}`
                    }
                }
            );
            const admin = res.data.data;
            if(admin.role) {
                this.admin = admin;
            } else {
                return
            }
        },
        async getVideoAll() {
            const res = await axios.get('/api/videos');
            this.videosForAdmin = res.data.data;
        },
        async getUserAll() {
            const res = await axios.get('/api/all-users',{
                headers: {
                    'Authorization': `Bearer ${localStorage.getItem('user_token')}`
                }
            });
            this.users = res.data.data;
        },
        async createAdmin(user) {
            await axios.post(`/api/videos/@${user}/make-admin`, {
                _method: 'PUT',
            },
                {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('user_token')}`
                    }
                }
                )
        },
        async createCategoy(category) {
            await axios.post(`/api/categories`, {
               ...category
            },{
                headers: {
                    'Content-type': 'multipart/form-data',
                    'Authorization': `Bearer ${localStorage.getItem('user_token')}`
                }
            })
        },
        async moderateVideo(videoId) {
            const video = await axios.post(`/api/videos/${videoId}/moderate`, {
                _method: 'PUT',
            },
                {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('user_token')}`
                    }
                }
                )
        },
        async changeStatus(videoId, status) {
            console.log(videoId, status);
            const video = await axios.post(`/api/videos/${videoId}/ban`, {
                    _method: 'PUT',
                    ban_status: status,
                },
                {
                    headers: {
                        'Authorization': `Bearer ${localStorage.getItem('user_token')}`
                    }
                }
            )
        }
    }
});
