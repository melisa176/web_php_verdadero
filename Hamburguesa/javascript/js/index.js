const contenedorTarjetas = document.getElementById("productos-container");

/** Crea las tarjetas de productos teniendo en cuenta la lista en comida.js */
function crearTarjetasProductosInicio(productos){
  productos.forEach(producto => {
    const nuevaComida = document.createElement("div");
    nuevaComida.classList = "tarjeta-producto";
    nuevaComida.innerHTML = `
      <div class="tarjeta-contenido">
        <img src="./img/${producto.id}.png" alt="${producto.nombre}" class="imagen-producto">
        <div class="informacion-producto">
          <h3>${producto.nombre}</h3>
          <p class="descripcion">${producto.descripcion}</p>
          <p class="precio">S/ ${producto.precio}</p>
          <button>Agregar al pedido</button>
        </div>
      </div>
    `;
    
    contenedorTarjetas.appendChild(nuevaComida);
    nuevaComida.getElementsByTagName("button")[0].addEventListener("click",() => agregarAlCarrito(producto));
  });
}

crearTarjetasProductosInicio(comida);
