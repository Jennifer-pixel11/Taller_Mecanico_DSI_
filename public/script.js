
async function cargarVehiculos() {
  const res = await fetch('controller/VehiculoController.php?action=list');
  const vehiculos = await res.json();
  const tbody = document.getElementById('vehiculos-body');
  tbody.innerHTML = '';
  vehiculos.forEach(v => {
    tbody.innerHTML += `
      <tr>
        <td>${v.placa}</td>
        <td>${v.cliente}</td>
        <td>${v.marca}</td>
        <td>${v.modelo}</td>
      </tr>`;
  });
}

document.getElementById('register-form').addEventListener('submit', async function (e) {
  e.preventDefault();
  const formData = new FormData(e.target);
  await fetch('controller/UsuarioController.php?action=register', {
    method: 'POST',
    body: formData
  });
  alert('Usuario registrado');
  e.target.reset();
});

document.getElementById('login-form').addEventListener('submit', async function (e) {
  e.preventDefault();
  const formData = new FormData(e.target);
  const res = await fetch('controller/UsuarioController.php?action=login', {
    method: 'POST',
    body: formData
  });
  const result = await res.text();
  if (result === 'ok') {
    window.location.href = 'main.html';
  } else {
    alert('Credenciales incorrectas');
  }
});
