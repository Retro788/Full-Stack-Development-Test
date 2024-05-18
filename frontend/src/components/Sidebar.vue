<template>
    <div class="min-w-[160px] w-[160px] transition-all bg-blue-700 text-white py-4 px-2">
      <!-- Links de la barra lateral -->
      <router-link :to="{name: 'app.dashboard'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
        <span class="mr-2 text-gray-300">
          <HomeIcon class="w-5"/>
        </span>
        <span class="text-xs">
          Dashboard
        </span>
      </router-link>

      <router-link :to="{name: 'app.users'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
        <span class="mr-2 text-gray-300">
          <UsersIcon class="w-5"/>
        </span>
        <span class="text-xs">
          Users
        </span>
      </router-link>

      <router-link :to="{name: 'app.customers'}" class="flex items-center p-2 rounded transition-colors hover:bg-black/30">
        <span class="mr-2 text-gray-300">
          <UserGroupIcon class="w-5"/>
        </span>
        <span class="text-xs">
          Customers
        </span>
      </router-link>

      <!-- Contenedor para los botones de GitHub y Portfolio -->
      <div class="mt-4">
        <a href="https://github.com/Retro788" target="_blank" rel="noopener noreferrer" class="block py-2 px-3 rounded-md text-white text-center my-2 transition-colors hover:bg-black/30">
          <svg height="16" aria-hidden="true" viewBox="0 0 16 16" version="1.1" width="16" class="inline-block align-middle mr-1 fill-current text-white transition-colors hover:text-gray-300">
            <path d="M8 0c4.42 0 8 3.58 8 8a8.013 8.013 0 0 1-5.45 7.59c-.4.08-.55-.17-.55-.38 0-.27.01-1.13.01-2.2 0-.75-.25-1.23-.54-1.48 1.78-.2 3.65-.88 3.65-3.95 0-.88-.31-1.59-.82-2.15.08-.2.36-1.02-.08-2.12 0 0-.67-.22-2.2.82-.64-.18-1.32-.27-2-.27-.68 0-1.36.09-2 .27-1.53-1.03-2.2-.82-2.2-.82-.44 1.1-.16 1.92-.08 2.12-.51.56-.82 1.28-.82 2.15 0 3.06 1.86 3.75 3.64 3.95-.23.2-.44.55-.51 1.07-.46.21-1.61.55-2.33-.66-.15-.24-.6-.83-1.23-.82-.67.01-.27.38.01.53.34.19.73.9.82 1.13.16.45.68 1.31 2.69.94 0 .67.01 1.3.01 1.49 0 .21-.15.45-.55.38A7.995 7.995 0 0 1 0 8c0-4.42 3.58-8 8-8Z"></path>
          </svg>
          GitHub
        </a>

        <a href="https://retro-dev-io.vercel.app" target="_blank" rel="noopener noreferrer" class="block py-2 px-3 rounded-md text-white text-center my-2 transition-colors hover:bg-black/30">
          Portfolio
        </a>
      </div>
    </div>
  </template>

  <script setup>
  import { HomeIcon, UserGroupIcon, UsersIcon } from '@heroicons/vue/24/outline'
  </script>

  <style scoped>
  /* Estilos locales específicos de la barra lateral */
  </style>
