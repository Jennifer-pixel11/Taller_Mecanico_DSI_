document.querySelector('form').addEventListener('submit', function (e) {
    let valido = true;

  // Validar nombre completo (mínimo 2 palabras y cada una con al menos 2 letras)
  const nombre = document.getElementById('nombre');
  const palabras = nombre.value.trim().split(/\s+/);
  const nombreValido = palabras.length >= 2 && palabras.every(p => p.length >= 2);
  toggleValidation(nombre, nombreValido, 'Campo Obligatorio!. Ingrese al menos 2 nombres con mínimo 2 letras cada uno.');

  // Validar teléfono (mínimo 10 dígitos, solo números y algunos símbolos)
  const telefono = document.getElementById('telefono');
  const telefonoRegex = /^[\d\s\+\-\(\)]{8,}$/;
  const telefonoValido = telefonoRegex.test(telefono.value.trim());
  toggleValidation(telefono, telefonoValido, 'Campo Obligatorio!. Debe ingresar un teléfono válido (mínimo 8 caracteres).');

  // Validar correo electrónico
  const correo = document.getElementById('correo');
  const correoRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
  const correoValido = correoRegex.test(correo.value.trim());
  toggleValidation(correo, correoValido, 'Campo Obligatorio!. Ingrese un correo electrónico válido.');

  // Validar dirección (mínimo 10 caracteres)
  const direccion = document.getElementById('direccion');
  const direccionValido = direccion.value.trim().length >= 10;
  toggleValidation(direccion, direccionValido, 'Campo Obligatorio!. La dirección debe tener al menos 10 caracteres.');

  if (!nombreValido || !telefonoValido || !correoValido || !direccionValido) {
    e.preventDefault(); // Detiene el envío del formulario
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
