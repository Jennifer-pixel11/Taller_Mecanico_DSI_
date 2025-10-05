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

