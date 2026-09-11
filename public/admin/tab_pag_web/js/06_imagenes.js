const imagenMethods = {
  verImagenes(id) {
    this.itemActual = id;
    bloquearUI('Cargando imágenes...');
    axios.get(`${this.apphost}/xoxo/reg_img/listar`, { params: { id } })
      .then(r => {
        this.imagenes = r.data.data || [];
        this.$nextTick(() => {
          this.activarDragImagenes();
        });
        $('#modalImagenes').modal('show');
      })
      .finally(() => desbloquearUI());
  },

  activarDragImagenes() {
    const vm = this;
    $('#contenedorImagenes').sortable({
      items: '.img-item',
      update: function () {
        let orden = [];
        $('#contenedorImagenes .img-item').each(function (index) {
          orden.push({
            id: $(this).data('id'),
            orden: index + 1
          });
        });

        fetch(vm.apphost + '/xoxo/reg_img/ordenar', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ orden })
        })
        .then(r => r.json())
        .then(() => {
          vm.verImagenes(vm.itemActual);
        });
      }
    });
  },

  abrirSubirImagen() {
    this.preview = null;
    const input = document.getElementById('fileImg');
    if (input) input.value = '';

    $('#modalImagenes').modal('hide');
    $('#modalSubirImagen').modal('show');
  },

  previewImg(e) {
    if (e.target.files && e.target.files[0]) {
      this.preview = URL.createObjectURL(e.target.files[0]);
    }
  },

  guardarImagen() {
    const file = $('#fileImg')[0].files[0];
    if (!file) {
      return apprise('Selecciona una imagen');
    }

    let f = new FormData();
    f.append('file', file);
    f.append('item', this.itemActual);

    bloquearUI('Subiendo imagen...');

    setTimeout(() => {
      axios.post(`${this.apphost}/xoxo/reg_img/crear`, f)
        .then(() => {
          $('#modalSubirImagen').modal('hide');
          this.verImagenes(this.itemActual);
        })
        .catch(() => {
          apprise('Error al subir imagen');
        })
        .finally(() => desbloquearUI());
    }, 50);
  },

  abrirPegarImagen() {
    this.urlImagenPegar = '';
    $('#modalImagenes').modal('hide');
    setTimeout(() => {
      $('#modalPegarImagen').modal('show');
    }, 200);
  },

  guardarImagenDesdeURL() {
    if (!this.urlImagenPegar) {
      return apprise('Pega una URL válida');
    }

    bloquearUI('Guardando URL...');
    axios.post(`${this.apphost}/xoxo/reg_img/crear_url`, {
      url: this.urlImagenPegar,
      item: this.itemActual
    })
    .then(() => {
      $('#modalPegarImagen').modal('hide');
      setTimeout(() => {
        this.verImagenes(this.itemActual);
      }, 200);
    })
    .finally(() => desbloquearUI());
  },

  copiarImagen(img) {
    navigator.clipboard.writeText(img.url_img)
      .then(() => apprise('Imagen copiada'))
      .catch(() => apprise('No se pudo copiar'));
  },

  eliminarImagen(img) {
    const self = this;
    apprise('¿Eliminar imagen?', { confirm: true }, ok => {
      if (!ok) return;
      bloquearUI('Eliminando imagen...');
      axios.post(`${self.apphost}/xoxo/reg_img/eliminar`, { id: img.pag_item_img_id })
        .then(() => self.verImagenes(self.itemActual))
        .catch(() => apprise('Error al eliminar'))
        .finally(() => desbloquearUI());
    });
  }
};