<template>
    <div class="bg-white p-4 rounded-lg shadow animate-fade-in-down">
      <div class="flex justify-between border-b-2 pb-3">
        <div class="flex items-center">
          <span class="whitespace-nowrap mr-3">Per Page</span>
            <select @change="getUsers(null)" v-model="perPage"
                    class="appearance-none relative block w-24 px-3 py-2 border border-gray-300 placeholder-gray-500 text-gray-900 rounded-md focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 focus:z-10 sm:text-sm">
                <option value="5">5</option>
                <option value="10">10</option>
                <option value="20">20</option>
                <option value="50">50</option>
                <option value="100">100</option>
            </select>
        </div>
      </div>
        <table class="table-auto w-full">
            <thead>
                <tr>
                    <TableHeaderCell field="id" :sort-field="sortField" :sort-direction="sortDirection"
                                     @click="sortUsers('id')">
                      ID
                    </TableHeaderCell>
                    <TableHeaderCell field="name" :sort-field="sortField" :sort-direction="sortDirection"
                                     @click="sortUsers('email')">
                      Name
                    </TableHeaderCell>
                    <TableHeaderCell field="email" :sort-field="sortField" :sort-direction="sortDirection"
                                     @click="sortUsers('email')">
                      Email
                    </TableHeaderCell>
                    <TableHeaderCell field="created_at" :sort-field="sortField" :sort-direction="sortDirection"
                                     @click="sortUsers('created_at')">
                      Create Date
                    </TableHeaderCell>
                    <TableHeaderCell field="actions">
                      Actions
                    </TableHeaderCell>
                </tr>
            </thead>
            <tbody v-if="users.loading || !users.data.length">
                <tr>
                  <td colspan="6">
                    <Spinner v-if="users.loading"/>
                    <p v-else class="text-center py-8 text-gray-700">
                      There are no users
                    </p>
                  </td>
                </tr>
            </tbody>
            <tbody v-else>
                <tr v-for="(user, index) of users.data">
                    <td class="border-b p-2 ">{{ user.id }}</td>
                    <td class="border-b p-2 ">
                        {{ user.name }}
                    </td>
                    <td class="border-b p-2 max-w-[200px] whitespace-nowrap overflow-hidden text-ellipsis">
                      {{ user.email }}
                    </td>
                    <td class="border-b p-2">
                      {{ user.created_at }}
                    </td>
                    <td class="border-b p-2 ">
                        <Menu as="div" class="relative inline-block text-left">
                          <div>
                            <MenuButton
                              class="inline-flex items-center justify-center w-full justify-center rounded-full w-10 h-10 bg-black bg-opacity-0 text-sm font-medium text-white hover:bg-opacity-5 focus:bg-opacity-5 focus:outline-none focus-visible:ring-2 focus-visible:ring-white focus-visible:ring-opacity-75"
                            >
                              <Bars4Icon
                                class="h-5 w-5 text-indigo-500"
                                aria-hidden="true"/>
                            </MenuButton>
                          </div>
                      
                          <transition
                            enter-active-class="transition duration-100 ease-out"
                            enter-from-class="transform scale-95 opacity-0"
                            enter-to-class="transform scale-100 opacity-100"
                            leave-active-class="transition duration-75 ease-in"
                            leave-from-class="transform scale-100 opacity-100"
                            leave-to-class="transform scale-95 opacity-0"
                          >
                            <MenuItems
                              class="absolute z-10 right-0 mt-2 w-32 origin-top-right divide-y divide-gray-100 rounded-md bg-white shadow-lg ring-1 ring-black ring-opacity-5 focus:outline-none"
                            >
                            <div class="px-1 py-1">
                              <MenuItem v-slot="{ active }">
                                <button
                                  :class="[
                                    active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                  ]"
                                  @click="editUser(user)"
                                >
                                  <PencilIcon
                                    :active="active"
                                    class="mr-2 h-5 w-5 text-indigo-400"
                                    aria-hidden="true"
                                  />
                                  Edit
                                </button>
                              </MenuItem>
                              <MenuItem v-slot="{ active }">
                                <button
                                  :class="[
                                    active ? 'bg-indigo-600 text-white' : 'text-gray-900',
                                    'group flex w-full items-center rounded-md px-2 py-2 text-sm',
                                  ]"
                                  @click="deleteUser(user)"
                                >
                                <TrashIcon
                                    :active="active"
                                    class="mr-2 h-5 w-5 text-indigo-400"
                                    aria-hidden="true"
                                  />
                                  Delete
                                </button>
                              </MenuItem>
                            </div>
                            </MenuItems>
                          </transition>
                        </Menu>
                    </td>
                </tr>
            </tbody>
        </table>
    </div>
  </template>

<script>
import { computed, onMounted, ref, defineEmits } from "vue";
import store from "../../store";
import { USERS_PER_PAGE } from "../../constants";
import UserModal from "./UserModal.vue";
import Spinner from "../../components/core/Spinner.vue";
import { Menu, MenuButton, MenuItem, MenuItems } from "@headlessui/vue";
import { Bars4Icon, PencilIcon, TrashIcon } from '@heroicons/vue/24/solid';
import TableHeaderCell from "../core/Table/TableHeaderCell.vue";

export default {
  name: 'UsersTable',
  components: {
    UserModal,
    TableHeaderCell,
    Bars4Icon,
    PencilIcon,
    TrashIcon,
    Spinner,
    Menu,
    MenuButton,
    MenuItem,
    MenuItems
  },
  data() {
    return {
      perPage: ref(USERS_PER_PAGE),
      search: ref(''),
      users: computed(() => store.state.users),
      sortField: ref('updated_at'),
      sortDirection: ref('desc'),
      showUserModal: ref(false)
    };
  },
  emits: ['clickEdit'],
  methods: {
    onMounted() {
      this.getUsers();
    },
    getForPage(ev, link) {
      ev.preventDefault();
      if (!link.url || link.active) {
        return;
      }
      this.getUsers(link.url);
    },
    getUsers(url = null) {
      store.dispatch("getUsers", {
        url,
        search: this.search.value,
        per_page: this.perPage.value,
        sort_field: this.sortField.value,
        sort_direction: this.sortDirection.value
      });
    },
    sortUsers(field) {
      if (field === this.sortField.value) {
        this.sortDirection.value = this.sortDirection.value === 'desc' ? 'asc' : 'desc';
      } else {
        this.sortField.value = field;
        this.sortDirection.value = 'asc';
      }
      this.getUsers();
    },
    showAddNewModal() {
      this.showUserModal.value = true;
    },
    deleteUser(user) {
      if (!confirm(`Are you sure you want to delete the user?`)) {
        return;
      }
      store.dispatch('deleteUser', user)
        .then(res => {
          // TODO Show notification
          this.getUsers();
        });
    },
    editUser(p) {
      this.$emit('clickEdit', p);
    }
  },
  mounted() {
    this.onMounted();
  }
};
</script>


<style scoped>
/* Your component styles go here */
</style>
