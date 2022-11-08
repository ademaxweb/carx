import { createRouter, createWebHistory} from "vue-router"

const router = createRouter({
    history: createWebHistory(),
    routes: [
        {
            name: 'index',
            path: '/',
            meta: {requiresAuth: false, forbiddenAuth: false},
            component: ()=>import('./views/Home.vue')
        },
        {
            name: 'store',
            path: '/store',
            meta: {requiresAuth: false, forbiddenAuth: false},
            component: ()=>import('./views/Store.vue')
        },
        {
            name: 'cars.info',
            path: '/cars/:id',
            meta: {requiresAuth: false, forbiddenAuth: false},
            component: ()=>import('./views/Car.vue')
        },
        {
            name: 'auth.login',
            path: '/login',
            meta: {requiresAuth: false, forbiddenAuth: true},
            component: ()=>import('./views/Login.vue')
        },
        {
            name: 'auth.signup',
            path: '/signup',
            meta: {requiresAuth: false, forbiddenAuth: true},
            component: ()=>import('./views/Signup.vue')
        },
        {
            name: 'user.profile',
            path: '/user/:id',
            meta: {requiresAuth: true, forbiddenAuth: false},
            component: ()=>import('./views/Profile.vue')
        },
        {
            name: 'roulettes',
            path: '/roulettes',
            meta: {requiresAuth: false, forbiddenAuth: false},
            component: ()=>import('./views/Roulettes.vue')
        },
        {
            name: 'roulette',
            path: '/roulette/:id',
            meta: {requiresAuth: false, forbiddenAuth: false},
            component: ()=>import('./views/Roulette.vue')
        },


        {
            name: 'admin.cars.create',
            path: '/cars/create',
            meta: {requiresAuth: true, forbiddenAuth: false},
            component: ()=>import('./views/Admin/CreateCar.vue')
        },
        {
            name: 'admin.roulettes.create',
            path: '/roulettes/create',
            meta: {requiresAuth: true, forbiddenAuth: false},
            component: ()=>import('./views/Admin/CreateRoulette.vue')
        },


        {
            name: 'not_found',
            path: '/404',
            meta: {requiresAuth: false, forbiddenAuth: false},
            component: ()=>import('./views/Home.vue')
        }
    ]
})

router.beforeEach((to, from, next) => {
    const access_token = localStorage.getItem('access_token')

    // console.log(to.meta);

    if (to.meta.requiresAuth && !access_token) return next({name: 'auth.login'})
    if (to.meta.forbiddenAuth && access_token) return next({name: from.name || 'user.profile'})


    return next()
})

export default router
