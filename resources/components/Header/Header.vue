<template>
    <header v-bind:class="{ scrolled: isScrolled }" class="left-0 right-0  w-full fixed top-0 z-50">
        <div class="flex my-[5px]  justify-between mx-auto max-w-[1720px] items-center">
                <Navbar />

            <Search label="поиск" />
            <button @click="toggleDark()"><img class="h-8 w-8" :src="isDark ? Moon : Sun" alt=""></button>
            <div v-if="user.nickname" class=" flex space-x-2 items-center">
                <router-link to="/profile">
                    <img
                        class="w-8 h-8 object-cover rounded-full"
                        :src="user.photo ? '/storage' +  user.photo : defaultAvatar"
                        alt=""
                    />
                </router-link>
                <button class=" hidden z-50 sm:block"  @click="auth.logout()">
                    выйти
                </button>

            </div>

        </div>
    </header>
</template>
<script setup>
import Sun from '@/assets/sun.svg';
import Moon from '@/assets/moon.svg';
import Search from "@/components/Search/Seach.vue";
import Navbar from "@/components/NavBar/Navbar.vue";
import { storeToRefs } from "pinia";
import defaultAvatar from "@/assets/user.jpg";
import { useUserStore } from "../../js/store/user";
import {useDark, useToggle} from "@vueuse/core";
import {useAuthStore} from "@/js/store/auth";
import {ref} from "vue";
const userStore = useUserStore();
const auth = useAuthStore();
let { user } = storeToRefs(userStore);

const isDark = useDark();
const toggleDark = useToggle(isDark);
</script>
<script>
export default {
    data() {
        return {
            isScrolled: false,
        }
    },
    mounted() {
        window.addEventListener('scroll', this.handleScroll)
    },
    updated() {
        window.addEventListener('scroll', this.handleScroll)
    },
    beforeDestroy() {
        window.removeEventListener('scroll', this.handleScroll)
    },
    methods: {
        handleScroll() {
            this.isScrolled = window.pageYOffset > 20
        }
    },
}
</script>
<style scoped>
header.scrolled {
    @apply bg-white dark:bg-black  text-white  ;
}
</style>
