let urlApi = "http://localhost:8080/home/cart/add";

function productAddCart(productId) {    
    getProductId(productId, 1);
}

async function getProductId(productId, quantity = 1) {
    
    try {
        const res = await fetch(urlApi, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json'
            },
            body: JSON.stringify({ 
                productId: productId,
                quantity: quantity
            }) 
        });

        console.log('res', res);
        

        // if (!res.ok) {
        //     if (window.flashy) {
        //         window.flashy.error('No se pudieron enviar los datos');
        //     }
        //     throw new Error(`Error en la petición: ${res.statusText}`);
        // }

        const data = await res.json();
        console.log(data);
        
        console.log('Datos recibidos del servidor:', data);

        if (window.flashy) {
            window.flashy.success('Producto agregado al carrito correctamente');
        }

    } catch (error) {
        console.error('Ocurrió un error en el fetch:', error);
    }
}