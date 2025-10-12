document.querySelector('form').addEventListener('submit', function (e) {
	let valido = true;

	// Validar nombre
	const nombre = document.querySelector('input[name="nombre"]');
	const nombreValido = nombre.value.trim() !== '';
	toggleValidation(nombre, nombreValido, 'Campo obligatorio. Ingrese el nombre del proveedor.');

	// Validar nombre_contacto
	const nombre_contacto = document.querySelector('input[name="nombre_contacto"]');
	const nombreContactoValido = nombre_contacto.value.trim() !== '';
	toggleValidation(nombre_contacto, nombreContactoValido, 'Campo obligatorio. Ingrese el nombre de contacto.');

	// Validar teléfono (solo números, mínimo 7 dígitos)
	const telefono = document.querySelector('input[name="telefono"]');
	const telefonoValido = /^\d{7,}$/.test(telefono.value.trim());
	toggleValidation(telefono, telefonoValido, 'Campo obligatorio. Ingrese un teléfono válido (solo números, mínimo 7 dígitos).');

	// Validar correo electrónico
	const correo_electronico = document.querySelector('input[name="correo_electronico"]');
	const correoValido = /^\S+@\S+\.\S+$/.test(correo_electronico.value.trim());
	toggleValidation(correo_electronico, correoValido, 'Campo obligatorio. Ingrese un correo electrónico válido.');

	// Validar dirección
	const direccion = document.querySelector('input[name="direccion"]');
	const direccionValida = direccion.value.trim() !== '';
	toggleValidation(direccion, direccionValida, 'Campo obligatorio. Ingrese la dirección.');

	// Validar rubro
	const rubro = document.querySelector('input[name="rubro"]');
	const rubroValido = rubro.value.trim() !== '';
	toggleValidation(rubro, rubroValido, 'Campo obligatorio. Ingrese el rubro.');

	if (!nombreValido || !nombreContactoValido || !telefonoValido || !correoValido || !direccionValida || !rubroValido) {
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
