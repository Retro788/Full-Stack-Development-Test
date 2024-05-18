
  export function setUser(state, user) {
    state.user.data = user;
  }
  
  export function setToken(state, token) {
    state.user.token = token;
    if (token) {
      sessionStorage.setItem('TOKEN', token);
    } else {
      sessionStorage.removeItem('TOKEN')
    }
  }
  
  export function setUsers(state, [loading, data = null]) {
  
    if (data) {
      state.users = {
        ...state.users,
        data: data.data,
        links: data.meta?.links,
        page: data.meta.current_page,
        limit: data.meta.per_page,
        from: data.meta.from,
        to: data.meta.to,
        total: data.meta.total,
      }
    }
    state.users.loading = loading;
  }
  export function showToast(state, message) {
    state.toast.show = true;
    state.toast.message = message;
  }
  
  export function hideToast(state) {
    state.toast.show = false;
    state.toast.message = '';
  }
  

  export function setCustomers(state, [loading, data = null]) {

    if (data) {
      state.customers = {
        ...state.customers,
        data: data.data,
        links: data.meta?.links,
        page: data.meta.current_page,
        limit: data.meta.per_page,
        from: data.meta.from,
        to: data.meta.to,
        total: data.meta.total,
      }
    }
    state.products.loading = loading;
  }