<template>
    <div class="my-20 border shadow-lg p-10 rounded-lg max-w-[1000px] mx-auto">
        <div >

            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Зарегестируйтесь
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Или
                <router-link
                    to="/login"
                    name="login"
                    class="font-medium text-indigo-600 hover:text-indigo-500"
                >Авторизируйтесь</router-link
                >
            </p>
        </div>
        <Alert  v-if="errors">
            {{ errors }}
            <span
                @click="errors = ''"
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
        <form class="mt-8 space-y-6" @submit="register">
            <!--        <Alert v-if="Object.keys(errors).length" class="flex-col items-stretch text-sm">-->
            <!--            <div v-for="(field, i) of Object.keys(errors)" :key="i">-->
            <!--                <div v-for="(error, ind) of errors[field]  []" :key="ind">-->
            <!--                    * {{ error }}-->
            <!--                </div>-->
            <!--            </div>-->
            <!--        </Alert>-->

            <input type="hidden" name="remember" value="true" />
            <div class="rounded-md  -space-y-px">
                <div>
                    <BaseInput
                        placeholder="nickname"
                        class="w-full"
                        label="Nickname"
                        v-model="name"
                        type="text"
                    />
                </div>
                <div>
                    <BaseInput
                        placeholder="email"
                        class="w-full"
                        label="Email"
                        v-model="email"
                        type="email"
                    />
                </div>
                <div>
                    <BaseInput
                        minlength="8"
                        placeholder="Пароль"
                        class="w-full"
                        label="Пароль"
                        v-model="password"
                        type="password"
                    />
                </div>

                <div
                    class="text-red-500"
                    v-if="password != '' && password !== confirmPassword"
                >
                    Пароли не совпадают!
                </div>
                <div>
                    <BaseInput
                        minlength="8"
                        placeholder="confirmPassword"
                        class="w-full"
                        label="Подвердите пароль"
                        v-model="confirmPassword"
                        type="password"
                    />
                </div>
            </div>

            <div>
                <button
                    type="submit"
                    :disabled="loading || errors.value"
                    class="bg-green rounded-full px-20 py-2 mx-auto relative flex justify-center text-center text-white"
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
                    Sign up
                </button>
                {{ errors.value }}
            </div>
        </form>
    </div>

</template>

<script setup>
import { ref, watch, computed } from "vue";
import { useRouter } from "vue-router";
import Alert from "../components/Alert/Alert.vue";
import BaseInput from "@/components/Input/BaseInput.vue";
import { useAuthStore } from "@/js/store/auth";
const auth = useAuthStore();
const router = useRouter();

const name = ref("");
const email = ref("");
const password = ref("");
const confirmPassword = ref("");

const loading = ref(false);
let errors = ref("");

const isValidEmail = computed(() => {
    return loading.value
        ? /^[\w-\.]+@([\w-]+\.)+[\w-]{2,4}$/.test(email.value.toString())
        : null;
});

const isValidNickName = computed(() => {
    return loading.value ? name.value.length > 2 : null;
});

const isStrongPassword = computed(() => {
    return loading.value ? password.value !== "" : null;
});

const isPasswordConfirmed = computed(() => {
    return loading.value ? password.value === confirmPassword.value : null;
});

function register(ev) {
    ev.preventDefault();
    loading.value = true;
    errors.value='';
    if (
        isValidNickName.value &&
        isValidEmail.value &&
        isStrongPassword.value &&
        isPasswordConfirmed.value
    ) {
        auth.signUp({
            nickname: name.value,
            email: email.value,
            password: password.value,
            password_confirmation: confirmPassword.value,
        });
        if(!auth.user)         errors.value = "Пользователь с такой почтой уже существует";
    } else {
        errors.value = "Не все данные заполнены";
        console.log(
            isValidNickName.value,
            isStrongPassword.value,
            isPasswordConfirmed.value
        );
    }
    loading.value = false;
}
</script>
