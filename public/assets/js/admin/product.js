document.addEventListener('DOMContentLoaded', function () {    
    listProduct();
});

const URL_BASE = "http://localhost:8080";

const ENDPOINTS = {
    productos: '/productos/store',
    list:      '/productos/list'
};

const frmProducts = document.querySelector('#frmProducts');
const imageInput = document.getElementById('fileImg');

if (frmProducts) {
    frmProducts.addEventListener('submit', saveProduct);
}

async function saveProduct(event) {
    event.preventDefault();

    const formData = new FormData(frmProducts);

    try {
        const res = await fetch(`${URL_BASE}${ENDPOINTS.productos}`, {
            method: 'POST',
            body: formData
        });

        const data = await res.json();

        if (data.success) {
            window.flashy.success(data.message);
            frmProducts.reset();
        } else {
            const message = data.error
                ? Object.values(data.error).join('<br>')
                : 'Ocurrió un error al guardar el producto.';
            window.flashy.error(message);
        }
    } catch (error) {
        console.error(error);
        window.flashy.error('Ocurrió un error al guardar el producto.');
    }
}


function listProduct() {     
    fetch(`${URL_BASE}${ENDPOINTS.list}`)
        .then(res => res.json())
        .then(data => tblProducts(data.products))
        .catch(error => console.log(error))
}

function tblProducts(data) {
    console.log(data);
    
    let tbl = new DataTable('#tblProducts', {
        responsive: true,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        pageLength: 10,
        lengthMenu: [10, 25, 50, 100],
        scrollX: true,
        autoWidth: false,
        layout: {
            topStart: 'pageLength', // Selector de registros
            topEnd: 'search',       // Buscador superior
            bottomStart: 'info',    // Información inferior
            bottomEnd: 'paging'     // Paginación inferior
        },
        columns: [
            { title: 'Producto', data: 'producto'},
            { title: 'Categoria', data: 'categoria'},
            { title: 'Descripcion', data: 'descripcion',
                render: data => data.length > 20 ? data.substring(0, 50) + '...' : data
            },
            { title: 'Imagen', data: 'imagen',
                render: data => `<img src="${URL_BASE}/uploads/${data}" width="100">`
            },
            { title: 'Precio', data: 'precio'},
            { title: 'Stock', data: 'stock'},
            // { title: 'acciones', data: 'acciones'},
        ]
    })

    tbl.rows.add(data).draw();
}