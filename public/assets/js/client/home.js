$(document).ready(function() {

    console.log('hola');
    
  $("#searchInput").autocomplete({
    minLength: 2,
    delay: 300,
    appendTo: '.site-navbar__search',
    source: function(request, response) {      
    // console.log("Valor enviado al controlador:", request.term);      
    // console.log({'endpoind': `${APP.BASE_URL}${APP.ENDPOINTS.home.searchAll}`});
      $.ajax({
        url: `${APP.BASE_URL}${APP.ENDPOINTS.home.searchAll}`,
        type: "GET",
        dataType: "json",
        data: {
          search: request.term
        },
        success: function(data) {           
            console.log(data.search);
          response($.map(data.search, function(item) {
            return {
                label: item.producto + " (" + item.categoria + ")",
                value: item.producto,
                productId: item.idproducto,
                categoria: item.categoria
            };
          }));
        },
        error: function() {
          response([]); // Vacía la lista si la petición falla
        }
      });
    },

    focus: function(event, ui) {
      event.preventDefault();
    },

    select: function(event, ui) {
        $("#autocompleteList").val(ui.item.id);
        detailProduct(ui.item.productId);
    }
  });
});

async function detailProduct(productId) {    
    await fetch(`${APP.BASE_URL}${APP.ENDPOINTS.home.detailProduct}/${productId}`, {
        method: 'GET'
    });
}



let urlApi = "http://localhost:8080/home/cart/add";
let urlList = "http://localhost:8080/home/cart/list";
let urlDelete = "http://localhost:8080/home/cart/delete";

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

        const result = await res.json();

        if (result.success) {
            window.flashy.success(result.message);
            bootstrap.Offcanvas.getOrCreateInstance(document.getElementById('offcanvasRight')).show();
        } else {
            window.flashy.error(result.message);
        }
        
        
    } catch (error) {
        console.error('Ocurrió un error en el fetch:', error);
    }

    listCart();
}


async function listCart() {
    const res = await fetch(urlList);
    const data = await res.json();
    
    const contenedor = document.getElementById('cart-container');
    
    contenedor.innerHTML = '';

    if (data.itemsCart.length === 0) {
        contenedor.innerHTML = '<p>El carrito está vacío</p>';
        return;
    }

    data.itemsCart.forEach(function (item) {
        contenedor.innerHTML += `
            <div class="col-12">
                <div class="cart-item">
                    <img src="/uploads/${item.imagen}" class="cart-item__img" alt="${item.nombre}">
                    <button type="button" onclick="deleteCart(${item.id})" class="btn-close" aria-label="Close"></button>
                    <div class="cart-item__info">
                        <h5 class="cart-item__nombre" title="${item.nombre}">${item.nombre}</h5>
                        <p class="cart-item__precio">$${item.precio}</p>
                        <label>Cantidad</label>                    
                        <input type="number" value="${ item.cantidad }" class="cart-item__cantidad"/>
                    </div>
                </div>
            </div>
        `;
    });

    const totalElemento = document.getElementById('totalItemCart');
    if (totalElemento) {
        totalElemento.textContent = `$${data.total}`;
    }

    const countItems = document.getElementById('countItemCart');
    if (countItems) {
        countItems.textContent = `${data.countItem}`;
    }
}

async function deleteCart(productId) {
    await fetch( `${urlDelete}/${productId}`,{
        method: 'DELETE',
    });
    
    listCart();
}

// async (params) => {}

document.addEventListener('DOMContentLoaded', function () {
    listCart();
});