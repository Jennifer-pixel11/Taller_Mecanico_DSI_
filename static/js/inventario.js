 function filtrar() {
      const q = document.getElementById('q').value.toLowerCase();
      document.querySelectorAll('#tabla-inventario tbody tr').forEach(tr=>{
        tr.style.display = tr.innerText.toLowerCase().includes(q) ? '' : 'none';
      });
    }
    function previewFile(input, imgId) {
      const file = input.files[0];
      const img = document.getElementById(imgId);
      if (!img) return;
      if (file) {
        const r = new FileReader();
        r.onload = e => img.src = e.target.result;
        r.readAsDataURL(file);
      }
    }
    function previewSelect(sel, imgId) {
      const img = document.getElementById(imgId);
      if (!img) return;
      img.src = sel.value || '';
    }
    function toggleImagenFuente() {
      const modo = document.querySelector('input[name="modo_imagen"]:checked').value;
      document.getElementById('bloqueSubir').style.display   = (modo==='subir')?'block':'none';
      document.getElementById('bloqueGaleria').style.display = (modo==='galeria')?'block':'none';
    }

document.querySelector('form').addEventListener('submit', function (e) {
  let valido = true;

  // Validar nombre del producto (debe estar presente)
const nombre = document.querySelector('input[name="nombre"]');
const nombreValido = nombre.value.trim() !== '';
toggleValidation(nombre, nombreValido, 'Campo obligatorio. Ingrese el nombre del producto.');

// Validar descripción del producto (debe estar presente)
const descripcion = document.querySelector('textarea[name="descripcion"]');
const descripcionValida = descripcion.value.trim() !== '';
toggleValidation(descripcion, descripcionValida, 'Campo obligatorio. Ingrese una descripción del producto.');

// Validar cantidad de productos (debe ser un número mayor a 0)
const cantidad = document.querySelector('input[name="cantidad"]');
const cantidadValida = cantidad.value.trim() !== '' && parseInt(cantidad.value) > 0;
toggleValidation(cantidad, cantidadValida, 'Campo obligatorio. Ingrese una cantidad mayor a 0.');

// Validar cantidad mínima (debe ser un número mayor o igual a 0)
const cantidadMinima = document.querySelector('input[name="cantidad_minima"]');
const cantidadMinimaValida = cantidadMinima.value.trim() !== '' && parseInt(cantidadMinima.value) >= 0;
toggleValidation(cantidadMinima, cantidadMinimaValida, 'Campo obligatorio. Ingrese una cantidad mínima mayor o igual a 0.');

// Validar precio (debe ser un número positivo con hasta 2 decimales)
const precio = document.querySelector('input[name="precio"]');
const precioValido = precio.value.trim() !== '' && parseFloat(precio.value) > 0;
toggleValidation(precio, precioValido, 'Campo obligatorio. Ingrese un precio válido mayor a 0.');

// Validar proveedor (debe estar presente)
const proveedor = document.querySelector('select[name="id_proveedor"]');
const proveedorValido = proveedor.value.trim() !== '';
toggleValidation(proveedor, proveedorValido, 'Campo obligatorio. Seleccione un proveedor.');

  // Si algún campo es inválido, no se envía el formulario
  if (!nombreValido || !nombreContactoValido || !telefonoValido || !correoElectronicoValido || !direccionValida || !rubroValido) {
    e.preventDefault(); // Detiene el envío del formulario
  }

  // Función que aplica clases y muestra mensaje personalizado
  function toggleValidation(input, isValid, mensaje) {
    let feedback = input.nextElementSibling;
    // Si el siguiente elemento no es feedback, buscar dentro del padre
    if (!feedback || !feedback.classList.contains('invalid-feedback')) {
      feedback = input.parentElement.querySelector('.invalid-feedback');
    }
    if (!isValid) {
      input.classList.add('is-invalid');
      input.classList.remove('is-valid');
      if (feedback) feedback.textContent = mensaje;
      valido = false;
    } else {
      input.classList.remove('is-invalid');
      input.classList.add('is-valid');
      if (feedback) feedback.textContent = '';
    }
  }
});

