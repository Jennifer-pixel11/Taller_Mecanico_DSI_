document.querySelector('form').addEventListener('submit', function (e) {
    let valido = true;

    // Validar placa salvadoreña: P123456 o P-123456
const placa = document.getElementById('placa');
const placaRegex = /^[A-Z]{1,2}-?\d{6}$/i;
const placaValida = placaRegex.test(placa.value.trim());
toggleValidation(placa, placaValida, 'Placa inválida. Ej: P123456 o P-123456');

 // Validar Cliente seleccionado
  const cliente = document.querySelector('select[name="cliente"]');
  const clienteValido = cliente.value !== '';
  toggleValidation(cliente, clienteValido, 'Debe seleccionar un cliente.');

// Validar marca (solo letras y espacios, mínimo 2 letras)
const marca = document.getElementById('marca');
const marcaRegex = /^[A-Za-zÁÉÍÓÚÜÑáéíóúüñ\s]{2,}$/;
const marcaValida = marcaRegex.test(marca.value.trim());
toggleValidation(marca, marcaValida, 'Marca inválida. Solo letras, mínimo 2 caracteres.');

// Validar línea/submodelo (letras, números, espacios, guiones y puntos; mínimo 2 caracteres)
const linea = document.getElementById('linea');
const lineaRegex = /^[A-Za-z0-9\s\-.]{2,}$/;
const lineaValida = lineaRegex.test(linea.value.trim());
toggleValidation(linea, lineaValida, 'Línea inválida. Ej: Corolla, F-150, Civic LX');

// Validar modelo (año entre 1990 y 2025, solo números)
const modelo = document.getElementById('modelo');
const modeloValido = /^\d{4}$/.test(modelo.value.trim()) &&
                     parseInt(modelo.value.trim()) >= 1990 &&
                     parseInt(modelo.value.trim()) <= 2025;
toggleValidation(modelo, modeloValido, 'Modelo inválido. Debe ser un año entre 1990 y 2025');
  
// Detener envío si algo es inválido
  if (!placaValida || !clienteValido || !marcaValida || !modeloValido) {
    e.preventDefault();
  }
  // Función que aplica clases y muestra mensaje personalizado
  function toggleValidation(input, isValid, mensaje) {
    const feedback = input.nextElementSibling;
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
