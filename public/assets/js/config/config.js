const APP = {
    BASE_URL: window.location.origin,

    ENDPOINTS: {
        // add categorias

        producto: {
            add:  '/productos/store',
            list: '/productos/list',
            download: '/productos/download'
        },

        user: {
            login:  '/user/login',
            signup: '/user/signup'
        }, 

        pruebas: {
            cargue: '/pruebas/cargue'    
        }
    }
};

window.APP = APP;