function bloquearUI(mensaje = 'Procesando...') {
  $.blockUI({
    message: '<h4 style="color:#fff;">' + mensaje + '</h4>',
    css: {
      border: 'none',
      padding: '15px',
      backgroundColor: '#000',
      borderRadius: '10px',
      opacity: 0.7,
      color: '#fff',
      zIndex: 2000
    },
    overlayCSS: {
      backgroundColor: '#000',
      opacity: 0.6,
      zIndex: 1999
    }
  });
}

function desbloquearUI() {
  $.unblockUI();
}

function obtenerMediodiaHoy() {
  const hoy = new Date();
  const yyyy = hoy.getFullYear();
  const mm = String(hoy.getMonth() + 1).padStart(2, '0');
  const dd = String(hoy.getDate()).padStart(2, '0');
  return `${yyyy}-${mm}-${dd}T12:00`;
}