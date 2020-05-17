function page(path) {
    return () => import(/* webpackChunkName: '' */ `../pages/${path}`).then(m => m.default || m)
}

export default [
    {path: '/', name: 'welcome', component: page('welcome.vue')},
    {path: '/login', name: 'login', component: page('auth/login.vue')},
    {path: '/home', name: 'home', component: page('home.vue')},
    {path: '/pool-records', name: 'poolRecords', component: page('pool-records/index.vue')},
    {path: '/pool-records/:id', name: 'poolRecordShow', component: page('pool-records/show.vue')},
    {
        path: '/settings',
        component: page('settings/index.vue'),
        children: [
            {path: '', redirect: {name: 'customer_types.index'}},
            {path: 'customer-types', name: 'customer_types.index', component: page('settings/customer-types/index.vue')},
            {path: 'password', name: 'settings.password', component: page('settings/password.vue')}
        ]
    },

    {path: '*', component: page('errors/404.vue')}
]
