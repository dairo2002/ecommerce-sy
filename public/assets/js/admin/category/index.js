
const URL_BASE = "http://127.0.0.1:8000";

const ENDPOINTS = {
    productos: '/categorias/create'
};

let txtCategory = document.getElementById('txtCategory');
let txtDiscount = document.getElementById('txtDiscount');
let txtStartDate = document.getElementById('txtStartDate');
let txtEndDate = document.getElementById('txtEndDate');

const data = {
    categoria: txtCategory,
    descuento: txtDiscount,
    fechainicio: txtStartDate,
    fechafin: txtEndDate,
}

fetch(`${URL_BASE}${ENDPOINTS.productos}`, {
    method: 'POST',
    headers: { 'Content-type': 'application/json' },
    body: data
})
    .then(res => res.json())
    .then(res => {
        if (res.success) {
            window.flashy.success(res.message);
        } else {
            const message = Object.values(res.error).join('<br>');
            window.flashy.error(message);
        }
    });
