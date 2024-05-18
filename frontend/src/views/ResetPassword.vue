<template>
  <GuestLayout title="Set new password">
    <form class="mt-8 space-y-6" @submit.prevent="submitForm">
      <input type="hidden" name="remember" value="true"/>
      
      <!-- Agrega el campo de correo electrónico -->
      <div class="rounded-md shadow-sm -space-y-px">
        <div>
          <label for="email" class="sr-only">Email</label>
          <input v-model="email" id="email" name="email" type="email" required=""
                 class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-t-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                 placeholder="Email"/>
        </div>
      </div>

      <!-- Campos de contraseña -->
      <div class="rounded-md shadow-sm -space-y-px">
        <div>
          <label for="new-password" class="sr-only">New Password</label>
          <input v-model="password" id="new-password" name="password" type="password" required=""
                 class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                 placeholder="New Password"/>
        </div>
        <div>
          <label for="password-repeat" class="sr-only">Repeat Password</label>
          <input v-model="passwordConfirmation" id="password-repeat" name="password_repeat" type="password" required=""
                 class="appearance-none rounded-none relative block w-full px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-b-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm"
                 placeholder="Repeat Password"/>
        </div>
      </div>

      <div class="flex items-center justify-between">
        <div class="text-sm">
          <router-link :to="{name: 'login'}" class="font-medium text-indigo-600 hover:text-indigo-500">
            Go back to Login
          </router-link>
        </div>
      </div>

      <div>
        <button type="submit"
                class="group relative w-full flex justify-center py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500">
            <span class="absolute left-0 inset-y-0 flex items-center pl-3">
              <LockClosedIcon class="h-5 w-5 text-indigo-500 group-hover:text-indigo-400" aria-hidden="true"/>
            </span>
          Submit
        </button>
      </div>
    </form>
  </GuestLayout>
</template>
  
<script setup>
    import { useStore } from 'vuex';
    import { ref, computed } from 'vue';
    import { LockClosedIcon } from '@heroicons/vue/24/solid';
    import GuestLayout from "../components/GuestLayout.vue";
    import { useRoute } from 'vue-router';
    
    const store = useStore();
    const route = useRoute();
    const email = ref(''); // Declaración del campo de correo electrónico
    const password = ref('');
    const passwordConfirmation = ref('');

    // Obtener el token de la URL
    const token = computed(() => route.params.token);

    const submitForm = async () => {
        try {
          // Extrae el valor de la contraseña y del token antes de pasarlos a la acción 'resetPassword'
          await store.dispatch('resetPassword', { email: email.value, token: token.value, password: password.value, password_confirmation: passwordConfirmation.value });
          // Manejar el éxito: redirigir al usuario a una página de confirmación o mostrar un mensaje de éxito
        } catch (error) {
          console.error(error.message); // Manejar el error: mostrar un mensaje de error al usuario
        }
      };

</script>
