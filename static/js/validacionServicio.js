document.querySelector('form').addEventListener('submit', function (e) {
	let valido = true;

	// Validar vehículo (debe estar seleccionado)
	const vehiculo = document.querySelector('select[name="vehiculo_id"]');
	const vehiculoValido = vehiculo.value.trim() !== '';
	toggleValidation(vehiculo, vehiculoValido, 'Campo Obligatorio!. Seleccione un vehículo.');

	// Validar descripción (mínimo 10 caracteres)
	const descripcion = document.querySelector('textarea[name="descripcion"]');
	const descripcionValido = descripcion.value.trim().length >= 10;
	toggleValidation(descripcion, descripcionValido, 'Campo Obligatorio!. La descripción debe tener al menos 10 caracteres.');

	// Validar fecha (debe estar seleccionada y no ser futura)
	const fecha = document.querySelector('input[name="fecha"]');
	const fechaValida = fecha.value.trim() !== '' && new Date(fecha.value) <= new Date();
	toggleValidation(fecha, fechaValida, 'Campo Obligatorio!. Seleccione una fecha válida (no futura).');

	// Validar costo (mayor a 0)
	const costo = document.querySelector('input[name="costo"]');
	const costoValido = costo.value.trim() !== '' && parseFloat(costo.value) > 0;
	toggleValidation(costo, costoValido, 'Campo Obligatorio!. El costo debe ser mayor a $0.00.');

	if (!vehiculoValido || !descripcionValido || !fechaValida || !costoValido) {
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
