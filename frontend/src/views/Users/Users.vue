<template>
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Users</h1>
      <button type="button"
              @click="showAddNewModal()"
              class="py-2 px-4 border border-transparent text-sm font-medium rounded-md text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500"
      >
        Add new User
      </button>
    </div>
    <UsersTable @clickEdit="editUser"/>
    <UserModal v-model="showUserModal" :user="userModel" @close="onModalClose"/>
  </template>
  
  <script setup>
  import { ref, computed, onMounted } from 'vue';
  import store from "../../store";
  import UsersTable from '../../components/Users/UsersTable.vue';
  import UserModal from '../../components/Users/UserModal.vue';

  const DEFAULT_USER = {
  id: '',
  title: '',
  description: '',
  image: '',
  price: ''
  }
  const userModel = ref({...DEFAULT_USER})
  const showUserModal = ref(false);

  const users = computed(() => store.state.users);

  const showAddNewModal = () => {
    showUserModal.value = true;
  };

  const editUser = (user) => {
    userModel.value = user;
    showUserModal.value = true;
  };

  function onModalClose() {
  userModel.value = {...DEFAULT_USER}
}

  </script>
  
  <style scoped>
  
  
  </style>