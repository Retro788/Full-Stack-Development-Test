<template>
    <div class="flex items-center justify-between mb-3">
      <h1 class="text-3xl font-semibold">Customers</h1>
    </div>
    <CustomersTable @clickEdit="editCustomer"/>
  </template>
  
  <script setup>
    import CustomersTable from '../../components/Users/CustomersTable.vue';
  </script>
  
  <style scoped>
  
  </style>