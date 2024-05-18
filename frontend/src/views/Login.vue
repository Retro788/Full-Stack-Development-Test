<template>
    <GuestLayout :class="themeClass" :title="title">
      <div class="absolute top-4 right-4 p-2 rounded-full" :class="switchContainerClass">
        <label for="theme-switch" class="mr-2 text-sm">{{ isDarkMode ? 'Dark Mode' : 'Light Mode' }}</label>
        <input id="theme-switch" type="checkbox" class="relative inline-flex items-center h-6 rounded-full w-11 transition-colors duration-300" :class="switchClass" v-model="isDarkMode" />
      </div>
      <form class="mt-8 space-y-6 login-form" :class="formClass" method="POST" @submit.prevent="login">
        <div v-if="errorMsg" class="flex items-center justify-between py-3 px-5 bg-red-500 text-white rounded">
          {{ errorMsg }}
          <span @click="errorMsg = ''" class="w-8 h-8 flex items-center justify-center rounded-full transition-colors cursor-pointer hover:bg-[rgba(0,0,0,0.2)]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
              <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
            </svg>
          </span>
        </div>

        <input type="hidden" name="remember" value="true"/>

        <div class="rounded-md shadow-sm -space-y-px">
          <div>
            <label for="email-address" class="sr-only">Email address</label>
            <input id="email-address" name="email" type="email" autocomplete="email" required v-model="user.email"
                   :class="inputClass"
                   placeholder="Email address"/>
          </div>
          <div>
            <label for="password" class="sr-only">Password</label>
            <input id="password" name="password" type="password" autocomplete="current-password" required v-model="user.password"
                   :class="inputClass"
                   placeholder="Password"/>
          </div>
        </div>

        <div class="flex items-center justify-between">
          <div class="flex items-center">
            <input id="remember-me" name="remember-me" type="checkbox" v-model="user.remember"
                   :class="checkboxClass"/>
            <label for="remember-me" :class="labelClass"> Remember me </label>
          </div>

          <div class="text-sm">
            <router-link :to="{name: 'requestPassword'}" :class="linkClass"> Forgot your password? </router-link>
          </div>
        </div>

        <div>
          <button type="submit" :disabled="loading" :class="buttonClass">
            <svg v-if="loading" class="animate-spin -ml-1 mr-3 h-5 w-5 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
              <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
              <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon :class="iconClass" aria-hidden="true"/>
            </span>
            Sign in
          </button>
        </div>
      </form>
      <div class="flex justify-center mt-16 space-x-4">
        <a href="https://github.com" target="_blank" class="flex items-center p-2 rounded transition-all bg-blue-700 text-white py-3 px-6 hover:bg-black/30">
          <svg class="w-5 h-5 mr-2" viewBox="0 0 16 16" fill="currentColor" xmlns="http://www.w3.org/2000/svg">
            <path d="M8 0c4.42 0 8 3.58 8 8a8.013 8.013 0 0 1-5.45 7.59c-.4.08-.55-.17-.55-.38 0-.27.01-1.13.01-2.2 0-.75-.25-1.23-.54-1.48 1.78-.2 3.65-.88 3.65-3.95 0-.88-.31-1.59-.82-2.15.08-.2.36-1.02-.08-2.12 0 0-.67-.22-2.2.82-.64-.18-1.32-.27-2-.27-.68 0-1.36.09-2 .27-1.53-1.03-2.2-.82-2.2-.82-.44 1.1-.16 1.92-.08 2.12-.51.56-.82 1.28-.82 2.15 0 3.06 1.86 3.75 3.64 3.95-.23.2-.44.55-.51 1.07-.46.21-1.61.55-2.33-.66-.15-.24-.6-.83-1.23-.82-.67.01-.27.38.01.53.34.19.73.9.82 1.13.16.45.68 1.31 2.69.94 0 .67.01 1.3.01 1.49 0 .21-.15.45-.55.38A7.995 7.995 0 0 1 0 8c0-4.42 3.58-8 8-8Z"/>
          </svg>
          <span>GitHub</span>
        </a>
        <a href="https://retro-dev-io.vercel.app" target="_blank" class="flex items-center p-2 rounded transition-all bg-blue-700 text-white py-3 px-6 hover:bg-black/30">
          <span>Portfolio</span>
        </a>
      </div>
    </GuestLayout>
  </template>

  <script setup>
  import { ref, computed } from 'vue'
  import { LockClosedIcon } from '@heroicons/vue/24/solid'
  import GuestLayout from "../components/GuestLayout.vue"
  import store from "../store"
  import router from "../router"
  import axiosClient from '../axios'

  let loading = ref(false)
  let errorMsg = ref("")

  const user = ref({
    email: '',
    password: '',
    remember: false
  })

  const isDarkMode = ref(false)

  const themeClass = computed(() => (isDarkMode.value ? 'bg-black text-white' : 'bg-blue-600 text-black'))
  const inputClass = computed(() => (isDarkMode.value ? 'bg-gray-800 text-white border-gray-600 placeholder-gray-400 focus:ring-blue-500 focus:border-blue-500' : 'bg-white text-black border-gray-300 placeholder-gray-500 focus:ring-blue-500 focus:border-blue-500'))
  const checkboxClass = computed(() => (isDarkMode.value ? 'h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-600 rounded' : 'h-4 w-4 text-blue-600 focus:ring-blue-500 border-gray-300 rounded'))
  const labelClass = computed(() => (isDarkMode.value ? 'ml-2 block text-sm text-white' : 'ml-2 block text-sm text-gray-900'))
  const linkClass = computed(() => (isDarkMode.value ? 'font-medium text-blue-500 hover:text-blue-400' : 'font-medium text-blue-600 hover:text-blue-500'))
  const buttonClass = computed(() => (isDarkMode.value ? 'group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-gray-800 hover:bg-gray-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-gray-500' : 'group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500'))
  const iconClass = computed(() => (isDarkMode.value ? 'h-5 w-5 text-gray-500 group-hover:text-gray-400' : 'h-5 w-5 text-blue-500 group-hover:text-blue-400'))
  const switchClass = computed(() => (isDarkMode.value ? 'bg-gray-600' : 'bg-gray-200'))
  const switchContainerClass = computed(() => (isDarkMode.value ? 'bg-gray-700 text-white' : 'bg-white text-black'))
  const formClass = computed(() => (isDarkMode.value ? 'bg-gray-800 border-gray-600 shadow-2xl' : 'bg-white border-blue-600 shadow-2xl'))

  function toggleTheme() {
    isDarkMode.value = !isDarkMode.value
  }

  function login() {
    loading.value = true
    store.dispatch('login', user.value)
      .then(() => {
        loading.value = false
        router.push({ name: 'app.dashboard' })
      })
      .catch(({ response }) => {
        loading.value = false
        errorMsg.value = response.data.message
      })
  }
  </script>

  <style scoped>
  .login-form {
    @apply p-4 border-2 rounded-md;
  }

  :global(body) {
    @apply bg-blue-600;
  }
  </style>
