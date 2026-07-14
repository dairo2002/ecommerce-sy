const URL_BASE = "http://localhost:8080";

const ENDPOINTS = {
    categoria: "/categorias/add"
};

const frmProducts = document.querySelector('#frmCategory');
frmProducts.addEventListener('submit', create);

async function create(event) {
    event.preventDefault();

    const payload = {
        categoria: document.getElementById("txtCategory").value,
        descuento: document.getElementById("txtDiscount").value,
        fechainicio: document.getElementById("txtStartDate").value,
        fechafin: document.getElementById("txtEndDate").value
    };

    try {
        const response = await fetch(`${URL_BASE}${ENDPOINTS.categoria}`, {
            method: "POST",
            headers: {
                "Content-Type": "application/json"
            },
            body: JSON.stringify(payload)
        });

        const result = await response.json();


        if (result.success) {
            window.flashy.success(result.message);
        } else {
            window.flashy.error(result.message);
        }

    } catch (error) {
        console.error(error);
    }
}