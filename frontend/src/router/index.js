import {createRouter, createWebHistory} from 'vue-router';
import Dashboard from '../views/Dashboard.vue';
import Login from '../views/Login.vue';
import RequestPassword from "../views/RequestPassword.vue";
import AppLayout from '../components/AppLayout.vue'
import ResetPassword from "../views/ResetPassword.vue";
import NotFound from "../views/NotFound.vue";
import store from "../store";
import Users from "../views/Users/Users.vue";
import Customers from "../views/Customers/Customers.vue";



const routes = [
  {
    path: '/',
    redirect: '/app'
  },
  {
    path: '/app',
    name: 'app',
    redirect: '/app/dashboard',
    component: AppLayout,
    meta: {
      requiresAuth: true
    },
    children: [
      {
        path: 'dashboard',
        name: 'app.dashboard',
        component: Dashboard
      },
      {
        path: 'users',
        name: 'app.users',
        component: Users
      },
      {
        path: 'customers',
        name: 'app.customers',
        component: Customers
      },
   
    ]
  },


    {
        path:    '/login',
        name:     'login',
        component: Login,
    },
    {
        path: '/request-password',
        name: 'requestPassword',
        component: RequestPassword,
        meta: {
          requiresGuest: true
        }
      },
      
      {
        path: '/reset-password/:token',
        name: 'resetPassword',
        component: ResetPassword,
        meta: {
          requiresGuest: true
        }
      },
      {
        path: '/:pathMatch(.*)',
        name: 'notfound',
        component: NotFound,
      }
];

const router = createRouter({
    history: createWebHistory(),
    routes,
    });


router.beforeEach((to, from, next) => {
  if (to.meta.requiresAuth && !store.state.user.token) {
    next({name: 'login'})
  } else if (to.meta.requiresGuest && store.state.user.token) {
    next({name: 'app.dashboard'})
  } else {
    next();
  }

})
export default router;
