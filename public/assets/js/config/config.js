const APP = {
    BASE_URL: window.location.origin,

    ENDPOINTS: {
        // add productos, categorias
        user: {
            login:  '/user/login',
            signup: '/user/signup'
        }
    }
};

window.APP = APP;