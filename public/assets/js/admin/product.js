document.addEventListener('DOMContentLoaded', function () {    
    listProduct();
});

const frmProducts = document.querySelector('#frmProducts');
const imageInput = document.getElementById('fileImg');

if (frmProducts) {
    frmProducts.addEventListener('submit', saveProduct);
}

async function saveProduct(event) {
    event.preventDefault();

    const formData = new FormData(frmProducts);

    try {
        const res = await fetch(`${APP.BASE_URL}${APP.ENDPOINTS.producto.add}`, {
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
    fetch(`${APP.BASE_URL}${APP.ENDPOINTS.producto.list}`)        
        .then(res => res.json())
        .then(data => tblProducts(data.products))
        .catch(error => console.log(error))
}

async function downloadExcelProducts() {
    try {
        const response = await fetch(
            `${APP.BASE_URL}${APP.ENDPOINTS.producto.download}`,
            { method: 'POST' }
        );

        if (!response.ok) {
            throw new Error(`No se pudo generar el Excel (HTTP ${response.status})`);
        }

        const blob = await response.blob();
        const url = URL.createObjectURL(blob);

        const link = document.createElement('a');
        link.href = url;
        link.download = 'productos.xlsx';
        document.body.appendChild(link);
        link.click();
        link.remove();

        URL.revokeObjectURL(url);
    } catch (error) {
        console.error(error);
        window.flashy.error('No se pudo descargar el archivo de productos.');
    }
}

function tblProducts(data) {

    $(document).on('click', '.img-producto', function () {
        $('#modalImagenProducto').modal('show');
        $('#imagenProductoModal').attr('src', $(this).data('imagen'));
    });
    
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
                render: data => `<img 
                    src="${APP.BASE_URL}/uploads/${data}"
                    class="cursor-pointer img-producto" 
                    width="30" height="30"
                    title="Vizualizar la Imagen"
                    data-imagen="${APP.BASE_URL}/uploads/${data}"
                >`
            },
            { title: 'Precio', data: 'precio'},
            { title: 'Stock', data: 'stock'},
            // { title: 'acciones', data: 'acciones'},
        ]
    })

    tbl.rows.add(data).draw();
}