const URL_BASE = "http://localhost:8080";

const ENDPOINTS = {
    productos: '/productos/store'
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