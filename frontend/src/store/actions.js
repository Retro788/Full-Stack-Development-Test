import axiosClient from "../axios";

export async function getCurrentUser({commit}, data) {
  const { data: data_1 } = await axiosClient.get('/user', data);
  commit('setUser', data_1);
  return data_1;
}

export async function login({commit}, data) {
  const { data: data_1 } = await axiosClient.post('/login', data);
  commit('setUser', data_1.user);
  commit('setToken', data_1.token);
  return data_1;
}

export async function logout({commit}) {
  const response = await axiosClient.post('/logout');
  commit('setToken', null);
  return response;
}



export async function getUsers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
  commit('setUsers', [true])
  url = url || '/users'
  const params = {
    per_page: state.users.limit,
  }
  try {
    const response = await axiosClient.get(url, {
      params: {
        ...params,
        search, per_page, sort_field, sort_direction
      }
    });
    commit('setUsers', [false, response.data]);
  } catch {
    commit('setUsers', [false]);
  }
}
export function forgotPassword({commit}, email) {
  return axiosClient.post('/forgot-password',  { email })
}

export function resetPassword({commit}, data) {
  return axiosClient.post('/reset-password', data)
}


export function createUser({commit}, user) {
  return axiosClient.post('/users', user)
}

export function updateUser({commit}, user) {
  return axiosClient.put(`/users/${user.id}`, user)
}
export function deleteUser({commit}, user) {
  return axiosClient.delete(`/users/${user.id}`)
}

export function getCustomers({commit, state}, {url = null, search = '', per_page, sort_field, sort_direction} = {}) {
}

export function getCustomer({commit}, id) {
  return axiosClient.get(`/customers/${id}`)
}

export function createCustomer({commit}, customer) {
  return axiosClient.post('/customers', customer)
}

export function updateCustomer({commit}, customer) {
  return axiosClient.put(`/customers/${customer.id}`, customer)
}

export function deleteCustomer({commit}, customer) {
  return axiosClient.delete(`/customers/${customer.id}`)
}





