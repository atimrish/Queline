<template>
    <div class="max-w-[1000px] border mx-auto my-20 bg-transparent  rounded-lg shadow-lg p-10">
    <div>

        <h2 class="mt-6 text-center  text-3xl ">
            Авторизация
        </h2>
        <p class="mt-2 text-center text-sm ">
            или
            <router-link
                :to="{ name: 'register' }"
                class="font-medium  hover:text-indigo-500"
            >
                Зарегестрируйтесь
            </router-link>
        </p>
    </div>
    <form class="mt-8 space-y-6" @submit="login">
        <Alert  v-if="errorMsg">
            {{ errorMsg }}
            <span
                @click="errorMsg = ''"
                class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]"
            >
        <svg
            xmlns="http://www.w3.org/2000/svg"
            class="h-6 w-6"
            fill="none"
            viewBox="0 0 24 24"
            stroke="currentColor"
        >
          <path
              stroke-linecap="round"
              stroke-linejoin="round"
              stroke-width="2"
              d="M6 18L18 6M6 6l12 12"
          />
        </svg>
      </span>
        </Alert>
        <input type="hidden" name="remember" value="true" />
        <div class="rounded-md shadow-sm -space-y-px">
            <div>
                <BaseInput  placeholder="email" class="w-full" label="email" v-model="email" type="email"/>
            </div>
            <div>
                <BaseInput minlength="8" placeholder="Пароль" class="w-full" label="Пароль" v-model="password" type="password"/>
            </div>
        </div>

<!--        <div class="flex items-center justify-between">-->
<!--            <div class="flex items-center">-->
<!--                <input-->
<!--                    id="remember-me"-->
<!--                    name="remember-me"-->
<!--                    type="checkbox"-->
<!--                    v-model="user.remember"-->
<!--                    class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded"-->
<!--                />-->
<!--                <label for="remember-me" class="ml-2 block text-sm text-gray-900">-->
<!--                    Remember me-->
<!--                </label>-->
<!--            </div>-->
<!--        </div>-->

        <div>
            <button
                type="submit"
                :disabled="loading.value"

                class="group bg-gray relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
                :class="{
          'cursor-not-allowed': loading,
          'hover:bg-indigo-500': loading,
        }"
            >
        <span class="absolute left-0 inset-y-0 flex items-center pl-3">
          <LockClosedIcon
              class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400"
              aria-hidden="true"
          />
        </span>
                <svg
                    v-if="loading"
                    class="animate-spin -ml-1 mr-3 h-5 w-5 text-white"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                >
                    <circle
                        class="opacity-25"
                        cx="12"
                        cy="12"
                        r="10"
                        stroke="currentColor"
                        stroke-width="4"
                    ></circle>
                    <path
                        class="opacity-75"
                        fill="currentColor"
                        d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"
                    ></path>
                </svg>
                Sign in
            </button>
        </div>
    </form>
    </div>
</template>

<script setup>
const isValidEmail = computed(() => {
    return loading.value ? (/^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/).test(email.value.toString()) : null;
});

const isStrongPassword = computed(() => {
    return loading.value ? password.value!=='' : null;
});

import { useRouter } from "vue-router";
import {computed, ref} from "vue";
import Alert from "../components/Alert/Alert.vue";
import BaseInput from "@/components/Input/BaseInput.vue";
import {useAuthStore} from "@/js/store/auth";
const email = ref("");
const password = ref("");
const router = useRouter();
const auth = useAuthStore();
let loading = ref(false);
const errorMsg = ref("");

function login(ev) {
    ev.preventDefault();
    loading.value = true;
    if (isValidEmail.value && isStrongPassword.value  ) {
        auth.signIn({
            email: email.value,
            password: password.value,
        });
    }
    loading.value = false;
    errorMsg.value = 'Такого пользователя не существует'
}
</script>
