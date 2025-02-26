//SECCIÓN PARA MOSTRAR LA INFORMACIÓN DEL CARRITO
document.addEventListener('DOMContentLoaded', () => {
const btnCart = document.querySelector('.container-cart-icon');
const containerCartProducts = document.querySelector('.container-cart-products');
console.log("Hola");
btnCart.addEventListener('click', () => {
    containerCartProducts.classList.toggle('hidden-cart');
});
});
/*-----------*/
const cartInfo=document.querySelector('.cart-products')
const rowProduct=document.querySelector('.row-product')


//Lista de todos los contenedores de productos

const productsList= document.querySelectorAll('.container-juegos')

//Variable de arreglos de Productos

let allProducts = []

const valorTotal = document.querySelector('.total-pagar')
const countProducts = document.querySelector('#contador-productos')
const cartEmpty = document.querySelector('.cart-empty');
const cartTotal = document.querySelector('.cart-total');


//  Enlace hacia formulario metodoPago
cartEmpty.innerHTML = `<a href="metodoPago.html" class="username">Pagar Ya</a>`;

productsList.forEach(section => {
    section.addEventListener('click', e=> {
    if(e.target.classList.contains('btn-add-cart')){
        const product = e.target.parentElement;

        const infoProduct ={
            quantity: 1,
            title: product.querySelector('h2').textContent,
            price: product.querySelector('p').textContent,
        };

        const exits= allProducts.some(
            product => product.title === infoProduct.title
            );
        
        if (exits){
            const products = allProducts.map(product => {
                if(product.title === infoProduct.title){
                    product.quantity++;
                    return product
                }else{
                    return product
                }
            });
            allProducts = [...products];
        } else{
                allProducts=[...allProducts, infoProduct];
            }
        
        showHTML();
    }
});


} );

rowProduct.addEventListener('click', e =>{
	
	console.log('´Check if it enters here 1');
	console.log(e.target);
	console.log(e.target.classList);

    if(e.target.classList.contains('icono-x')){
        const product = e.target.parentElement;
        const title = product.querySelector('.titulo-producto-carrito').textContent;

        allProducts = allProducts.filter(
			product => product.title !== title
			);
 
        console.log('´Check if it enters here 2');

        showHTML();
    }

});


//Función para mostrar html
 const showHTML = () => {

    if (!allProducts.length) {
		cartEmpty.classList.remove('hidden');
		rowProduct.classList.add('hidden');
		cartTotal.classList.add('hidden');
	} else {
		cartEmpty.classList.add('hidden');
		rowProduct.classList.remove('hidden');
		cartTotal.classList.remove('hidden');
	}
        //Limpiar HTML
        rowProduct.innerHTML = '';

        let total = 0;
        let totalOfProducts = 0;

        allProducts.forEach((product, index) => {
            const containerProduct = document.createElement('div');
            containerProduct.classList.add('cart-product');

            containerProduct.innerHTML = `
    	<div class="info-cart-product">
        <span class="cantidad-producto-carrito">${product.quantity}</span>
        <p class="titulo-producto-carrito">${product.title}</p>
        <span class="precio-producto-carrito">${product.price}</span>
        <input type="hidden" id="title-${index}" name="title-${index}" value="${product.title}">
    	</div>
    	<svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="icono-x">
    	<path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
    	</svg>
    	`;

            rowProduct.append(containerProduct);

            total = total + parseFloat(product.quantity * product.price.slice(0, -1));
            totalOfProducts = totalOfProducts + product.quantity;

        });
        valorTotal.innerText = `${total}€`;
        countProducts.innerText = totalOfProducts;
        
        //Crear un nuevo div 
        const newDiv = document.createElement('div');

        // Set the innerHTML of the new div to contain the input field
        newDiv.innerHTML = `
        <input type="hidden" id="totalItems" name="totalItems" value="${totalOfProducts}">
        `;
        countProducts.appendChild(newDiv); 

    };

    document.addEventListener('DOMContentLoaded', () => {
        const cartEmpty = document.querySelector('.cart-empty');
    
        // Escucha el clic en el enlace "Pagar Ya"
        cartEmpty.addEventListener('click', () => {
            console.log("Se hizo clic en el enlace 'Pagar Ya'");
            // Formatea la información del carrito
            const resumen = allProducts.map(product => `${product.quantity}x ${product.title}`).join(', ');
            
            // Actualiza el valor del campo resumenPedido en el formulario
            const resumenPedidoInput = document.querySelector('input[name="resumenPedido"]');
            console.log(resumenPedidoInput);
            if (resumenPedidoInput) {
                resumenPedidoInput.value = resumen;
            } else {
                console.error("No se encontró el elemento input[name='resumenPedido']");
            }
        });
    });
    
    

/*-----------------------------------------*/



// Función para mostrar una sección específica y ocultar las demás
function mostrarSeccion(seccionId) {
    // Oculta todas las secciones excepto la seleccionada
    document.querySelectorAll('section').forEach(seccion => {
        if (seccion.id === seccionId) {
            // Si la sección está oculta, la muestra; de lo contrario, la oculta
            seccion.style.display = (seccion.style.display === 'none') ? 'block' : 'none';
            
            // Desplaza la ventana para que la sección sea visible si se está mostrando
            if (seccion.style.display === 'block') {
                seccion.scrollIntoView({ behavior: 'smooth' });
            }
        } else {
            seccion.style.display = 'none';
        }
    });

    // Ocultar los carruseles si la sección actual es diferente de "Quiénes somos"
    var carruselVideojuegos = document.querySelector('.carrusel-container-videojuegos');
    var carruselMesa = document.querySelector('.carrusel-container-mesa');
    var tabla = document.querySelector('.tabla');
    if (seccionId !== 'quienes-somos') {
        carruselVideojuegos.style.display = 'none';
        carruselMesa.style.display = 'none';
        tabla.style.display = 'none';
    } else { // De lo contrario, se muestran
        carruselVideojuegos.style.display = 'block';
        carruselMesa.style.display = 'block';
        tabla.style.display = 'block';
    }
}

// Función para mostrar un mensaje de bienvenida después de un inicio de sesión exitoso
document.addEventListener("DOMContentLoaded", function() {
    // Verifica si hay un parámetro de consulta que indique un inicio de sesión exitoso
    const urlParams = new URLSearchParams(window.location.search);
    const loginSuccess = urlParams.get('login');
    const username = urlParams.get('user');

    if (loginSuccess === 'success' && username) {
        // Muestra el mensaje de bienvenida en el encabezado
        const mensajeBienvenida = document.createElement("span");
        mensajeBienvenida.textContent = "Bienvenido, " + username + "!";
        mensajeBienvenida.id = "mensaje-bienvenida";

        // Busca el encabezado y agrega el mensaje de bienvenida
        const header = document.querySelector('header');
        header.appendChild(mensajeBienvenida);

        // Crea el botón "Cerrar Sesión"
        const cerrarSesionButton = document.createElement("button");
        cerrarSesionButton.textContent = "Cerrar Sesión";
        cerrarSesionButton.id = "cerrar-sesion-button";

        // Agrega el evento click al botón para redirigir a la página de inicio de sesión
        cerrarSesionButton.addEventListener("click", function() {
            window.location.href = "http://localhost/proyectodaw/registro-usuario.html";
        });

        // Agrega el botón "Cerrar Sesión" al encabezado
        header.appendChild(cerrarSesionButton);

        // Crea el botón "Perfil"
        const perfilButton = document.createElement("button");
        perfilButton.textContent = "Mi Perfil";
        perfilButton.id = "perfil-button";

        // Agrega el evento click al botón para redirigir al perfil del usuario
        perfilButton.addEventListener("click", function() {
            window.location.href = "http://localhost/proyectodaw/perfil-usuario.php";
        });

        // Agrega el botón "Perfil" al encabezado
        header.appendChild(perfilButton);
    }
});
