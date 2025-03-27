import Dashboard from '@/pages/index.vue';
import Login from '@/pages/login.vue';
import { setupLayouts } from 'virtual:generated-layouts'
import { createRouter, createWebHistory } from 'vue-router'
import routes from '~pages'
import { canNavigate } from '@layouts/plugins/casl'
import { isUserLoggedIn } from './utils';

const router = createRouter({
  history: createWebHistory(import.meta.env.BASE_URL),
  routes: [
    // {
    //   path: '/',
    //   redirect: to => {
    //     const userRole = JSON.parse(localStorage.getItem('userDepartment') || '{}').value;
    //     console.log(userRole, 'ROLES'); // Debugging the userRole value
        
    //     if (userRole === 'Admin') {
    //       return { name: 'index' };
    //     }
    //     if (userRole === 'Bureau of Collection') {
    //       // Redirect to the appropriate route for Bureau of Collection
    //       return { name: 'buco' };
    //     }
        
    //     return { name: 'login', query: to.query };
    //   },
    // },
    {
      path: '/login',
      name: 'Login',
      component: Login,
      beforeEnter: (to, from, next) => {
      const isLoggedIn = isUserLoggedIn()
        if (isLoggedIn) {
          next('/');
        } else {
          next();
        }
      }
    },

    ...setupLayouts(routes).map(route => {
      return {
        ...route,
        meta: { requiresAuth: true }
      }
    }),

    {
      path: '/',
      component: Dashboard,
      beforeEnter: (to, from, next) => {
      const isLoggedIn = isUserLoggedIn()
        if (!isLoggedIn) {
          next('/login');
        } else {
          next();
        }
      },
    },
  ],
});

// Add a navigation guard to check for the auth token on all routes
router.beforeEach((to, from, next) => {
  const isLoggedIn = isUserLoggedIn()
  if (to.matched.some((record) => record.meta.requiresAuth) && !isLoggedIn) {
    next('/login');
  } else {
    next();
  }
});

// Docs: https://router.vuejs.org/guide/advanced/navigation-guards.html#global-before-guards

export default router
