document.querySelector('form').addEventListener('submit', function (e) {
	let valido = true;

	// Eliminar alerta global previa
	let alertDiv = document.getElementById('cita-alert');
	if (alertDiv) alertDiv.remove();

	// Validar cliente
	const cliente = document.querySelector('select[name="cliente_id"]');
	const clienteValido = cliente && cliente.value !== '';
	toggleValidation(cliente, clienteValido, 'Debe seleccionar un cliente.');

	// Validar vehículo
	const vehiculo = document.querySelector('select[name="vehiculo_id"]');
	const vehiculoValido = vehiculo && vehiculo.value !== '';
	toggleValidation(vehiculo, vehiculoValido, 'Debe seleccionar un vehículo.');

	// Validar servicio
	const servicio = document.querySelector('select[name="servicio_id"]');
	const servicioValido = servicio && servicio.value !== '';
	toggleValidation(servicio, servicioValido, 'Debe seleccionar un servicio.');

	// Validar fecha
	const fecha = document.querySelector('input[name="fecha"]');
	const fechaValida = fecha && fecha.value !== '' && new Date(fecha.value) >= new Date();
	toggleValidation(fecha, fechaValida, 'Debe seleccionar una fecha válida. Debe ser hoy o futura.');

	// Validar hora
	const hora = document.querySelector('input[name="hora"]');
	const horaValida = hora && hora.value !== '';
	toggleValidation(hora, horaValida, 'Debe ingresar una hora.');

	// Validar descripción
	const descripcion = document.querySelector('textarea[name="descripcion"]');
	const descripcionValida = descripcion && descripcion.value.length >= 10;
	toggleValidation(descripcion, descripcionValida, 'La descripción debe tener al menos 10 caracteres.');

	if (!clienteValido || !vehiculoValido || !servicioValido || !fechaValida || !horaValida || !descripcionValida) {
		e.preventDefault();
		// Mostrar alerta global arriba del formulario
		const form = document.querySelector('form');
		const globalAlert = document.createElement('div');
		globalAlert.id = 'cita-alert';
		globalAlert.className = 'alert alert-danger border border-danger rounded text-center';
		globalAlert.textContent = 'Por favor corrija los errores antes de continuar.';
		form.parentElement.insertBefore(globalAlert, form);
	}

	function toggleValidation(input, isValid, mensaje) {
		let feedback = input ? input.nextElementSibling : null;
		if (!feedback || !feedback.classList.contains('invalid-feedback')) {
			feedback = input ? input.parentElement.querySelector('.invalid-feedback') : null;
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
