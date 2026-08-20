const APP = {
    BASE_URL: window.location.origin,

    ENDPOINTS: {
        home: {
            searchAll: '/home/searchAll',
            detailProduct: '/home/detalle'
        },
        
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