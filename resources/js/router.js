const index = () => import('./components/product/index.vue') ;
const  Login =()=> import('./components/Login.vue');
const  Register =()=> import('./components/Register.vue');
const  storProduct =()=> import('./components/product/StoreProduct.vue');
const  Order =()=>import('./components/Order/index');

const  App =()=> import('./components/App.vue');

export const routes = [


    {
        name: 'Register',
        path: '/Register',
        component: Register
    },
    {
        name: 'Login',
        path: '/Login',
        component: Login
    },
    {
        name: 'index',
        path: '/index',
        component: index
    },
    {
        name: 'Store Product',
        path: '/storeProduct',
        component: storProduct
    },
    {
        name: 'Orders',
        path: '/Orders',
        component: Order
    },
]
