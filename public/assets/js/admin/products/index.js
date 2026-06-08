const URL_BASE = "http://127.0.0.1:8000";

const ENDPOINTS = {
    productos: '/productos/store'
};

const frmProducts = document.querySelector('#frmProducts');

const txtProduct = document.querySelector('#txtProduct');
const txtDescription = document.querySelector('#txtDescription');
const txtStock = document.querySelector('#txtStock');
const fileImg = document.querySelector('#fileImg');

frmProducts.addEventListener('submit', saveProduct);

async function saveProduct(event) {

    event.preventDefault();

    const formData = new FormData();

    formData.append('nombre', txtProduct.value);
    formData.append('descripcion', txtDescription.value);
    formData.append('stock', txtStock.value);
    formData.append('imagen', fileImg.files[0]);

    fetch(`${URL_BASE}${ENDPOINTS.productos}`, { method: 'POST', body: formData })
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            window.flashy.success(res.message);
        } else {        
            const message = Object.values(res.error).join('<br>');
            window.flashy.error(message);
        }
    });

}