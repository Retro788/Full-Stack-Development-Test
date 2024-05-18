<template>
  <TransitionRoot as="template" :show="show">
    <Dialog as="div" class="relative z-10" @close="show = false">
      <TransitionChild as="template" enter="ease-out duration-300" enter-from="opacity-0" enter-to="opacity-100"
                       leave="ease-in duration-200" leave-from="opacity-100" leave-to="opacity-0">
        <div class="fixed inset-0 bg-black bg-opacity-70 transition-opacity"/>
      </TransitionChild>

      <div class="fixed z-10 inset-0 overflow-y-auto">
        <div class="flex items-end sm:items-center justify-center min-h-full p-4 text-center sm:p-0">
          <TransitionChild as="template" enter="ease-out duration-300"
                           enter-from="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
                           enter-to="opacity-100 translate-y-0 sm:scale-100" leave="ease-in duration-200"
                           leave-from="opacity-100 translate-y-0 sm:scale-100"
                           leave-to="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95">
            <DialogPanel
              class="relative bg-white rounded-lg text-left overflow-hidden shadow-xl transform transition-all sm:my-8 sm:max-w-[700px] sm:w-full">
              <Spinner v-if="loading"
                       class="absolute left-0 top-0 bg-white right-0 bottom-0 flex items-center justify-center"/>
              <header class="py-3 px-4 flex justify-between items-center">
                <DialogTitle as="h3" class="text-lg leading-6 font-medium text-gray-900">
                  {{ user.id ? `Update user: "${props.user.name}"` : 'Create new User' }}
                </DialogTitle>
                <button
                  @click="closeModal()"
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
                </button>
              </header>
              <form @submit.prevent="onSubmit">
                <div class="bg-white px-4 pt-5 pb-4">
                  <CustomInput class="mb-2" v-model="user.name" label="Name"/>
                  <CustomInput class="mb-2" v-model="user.email" label="Email"/>
                  <CustomInput type="password" class="mb-2" v-model="user.password" label="Password"/>
                  <CustomInput type="checkbox" v-model="user.is_admin" label="¿Es Administrador?"/>

                </div>
                <footer class="bg-gray-50 px-4 py-3 sm:px-6 sm:flex sm:flex-row-reverse">
                  <v-btn color="indigo" @click="onSubmit" class="mt-3 ml-3 sm:mt-0 sm:w-auto sm:text-sm" outlined>
                    Submit
                  </v-btn>
                  <v-btn @click="closeModal" class="mt-3 ml-3 sm:mt-0 sm:w-auto sm:text-sm" outlined>
                    Cancel
                  </v-btn>
                </footer>
              </form>
            </DialogPanel>
          </TransitionChild>
        </div>
      </div>
    </Dialog>
  </TransitionRoot>
</template>

<script setup>
  import { computed, defineEmits, ref, onUpdated } from 'vue';
  import { Dialog, DialogPanel, DialogTitle, TransitionChild, TransitionRoot } from '@headlessui/vue';
  import store from "../../store/index";
  import Spinner from "../core/Spinner.vue";
  import CustomInput from "../core/CustomInput.vue";

  const props = defineProps({
    modelValue: Boolean,
    user: {
      required: true,
      type: Object,
    }
  });

  const emit = defineEmits(['update:modelValue', 'close']);

  const user = ref({
    id: props.user.id,
    name: props.user.name,
    email: props.user.email,
    is_admin: props.user.is_admin !== undefined ? props.user.is_admin : false,
  });
  console.log(user.value);
  const loading = ref(false);

  const show = computed({
    get: () => props.modelValue,
    set: (value) => emit('update:modelValue', value)
  });

  onUpdated(() => {
    user.value = {
      id: props.user.id,
      name: props.user.name,
      email: props.user.email,
    };
  });

  function closeModal() {
    show.value = false;
    emit('close');
  }

  function onSubmit() {
    loading.value = true;
    console.log("Valor de is_admin:", user.value.is_admin);
    if (user.value.id) {
      store.dispatch('updateUser', user.value)
        .then(response => {
          loading.value = false;
          if (response.status === 200) {
            // TODO show notification
            store.dispatch('getUsers');
            closeModal();
          }
        });
    } else {
      store.dispatch('createUser', user.value)
        .then(response => {
          loading.value = false;
          if (response.status === 201) {
            // TODO show notification
            store.dispatch('getUsers');
            closeModal();
          }
        })
        .catch(err => {
          loading.value = false;
          console.log(err);
        });
    }
  }
</script>


<style scoped>

</style>