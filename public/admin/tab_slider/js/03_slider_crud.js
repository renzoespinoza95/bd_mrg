const sliderMethods = {
  obtenerSliders() {
    fetch(this.apphost + '/slider/listar')
      .then(r => r.json())
      .then(data => {
        this.sliders = data.map(s => ({
          ...s,
          img_thumb: s.img
        }));
        this.$nextTick(() => {
          if ($.fn.DataTable.isDataTable('#tablaSliders')) {
            $('#tablaSliders').DataTable().destroy();
          }
          $('#tablaSliders').DataTable({
            language: (typeof dt_language !== 'undefined' ? dt_language : undefined),
            scrollX: true,
            dom: 'frtip',
            order: [[3, 'asc']]
          });
        });
      });
  },

  cambiarVisible(s) {
    const nuevoValor = s.is_visible == 1 ? 0 : 1;
    s.is_visible = nuevoValor;

    fetch(this.apphost + '/slider/actualizarVisible', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        slider_id: s.slider_id,
        is_visible: nuevoValor
      })
    })
    .then(r => r.json())
    .then(data => {
      if (!data.success) {
        s.is_visible = nuevoValor == 1 ? 0 : 1;
        apprise('No se pudo actualizar la visibilidad');
      }
    })
    .catch(() => {
      s.is_visible = nuevoValor == 1 ? 0 : 1;
      apprise('Error de conexión');
    });
  },

  cambiarGrupo(s) {
    fetch(this.apphost + '/slider/actualizarGrupo', {
      method: 'POST',
      headers: { 'Content-Type': 'application/json' },
      body: JSON.stringify({
        slider_id: s.slider_id,
        grupo: s.grupo
      })
    })
    .then(r => r.json())
    .then(data => {
      if (!data.success) {
        apprise('No se pudo actualizar el grupo');
      }
    })
    .catch(() => {
      apprise('Error de conexión');
    });
  },

  cambiarUrlImg(s) {
    const vm = this;
    apprise('Ingrese la nueva URL de la imagen:', { input: s.img || '' }, function(r) {
      if (r && r.trim() !== '') {
        const nuevaUrl = r.trim();
        bloquearUI('Actualizando URL de imagen...');

        fetch(vm.apphost + '/slider/actualizarUrlImg', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({
            slider_id: s.slider_id,
            img: nuevaUrl
          })
        })
        .then(res => res.json())
        .then(data => {
          desbloquearUI();
          if (data.success) {
            s.img = nuevaUrl;
            s.img_thumb = nuevaUrl;
            apprise('URL actualizada con éxito');
          } else {
            apprise('Error: ' + (data.error || 'No se pudo actualizar la URL'));
          }
        })
        .catch(err => {
          desbloquearUI();
          console.error(err);
          apprise('Error de red al actualizar URL');
        });
      }
    });
  },

  onFileChange(e, mode) {
    const file = e.target.files[0];
    if (!file) return;
    const reader = new FileReader();
    reader.onload = ev => {
      if (mode === 'crear') {
        this.nuevo.imgFile = file;
        this.nuevo.imgPreview = ev.target.result;
      } else {
        this.formulario.imgFile = file;
        this.formulario.imgPreview = ev.target.result;
      }
    };
    reader.readAsDataURL(file);
  },

  abrirModalCrear() {
    const mediodia = obtenerMediodiaHoy();
    this.nuevo = {
      imgFile: null,
      imgPreview: '',
      orden: 0,
      is_visible: 1,
      fecha_creacion: mediodia,
      fecha_fin: mediodia,
      neg_id: 0,
      descripcion: '',
      grupo: ''
    };
    $('#snCrearDescripcion').summernote('code', '');
    $('#modalCrearSlider').modal('show');
  },

  crearSlider() {
    const fc = new Date(this.nuevo.fecha_creacion);
    const ff = new Date(this.nuevo.fecha_fin);

    if (isNaN(fc.getTime()) || isNaN(ff.getTime())) {
      return apprise('Debes seleccionar fecha de creación y fecha fin válidas', { okBtn: 'Entendido' });
    }

    if (!this.nuevo.imgFile) {
      return apprise('Debes seleccionar una imagen para el slider', { okBtn: 'Entendido' });
    }

    const descripcion = $('#snCrearDescripcion').summernote('code');

    const formData = new FormData();
    formData.append('img', this.nuevo.imgFile);
    formData.append('orden', this.nuevo.orden);
    formData.append('is_visible', this.nuevo.is_visible);
    formData.append('fecha_creacion', this.nuevo.fecha_creacion);
    formData.append('fecha_fin', this.nuevo.fecha_fin);
    formData.append('neg_id', this.nuevo.neg_id);
    formData.append('grupo', this.nuevo.grupo);
    formData.append('descripcion', descripcion);

    bloquearUI('Subiendo imagen y guardando...');

    setTimeout(() => {
      fetch(this.apphost + '/slider/crear', {
        method: 'POST',
        body: formData
      })
      .then(r => r.json())
      .then(data => {
        desbloquearUI();
        if (data.success) {
          $('#modalCrearSlider').modal('hide');
          this.obtenerSliders();
          apprise('Slider creado', { okBtn: 'Ok' }, () => {
            window.location.reload();
          });
        } else {
          apprise('Error: ' + (data.error || 'Desconocido'));
        }
      })
      .catch(e => {
        desbloquearUI();
        apprise('Error de red');
        console.error(e);
      });
    }, 50);
  },

  actualizarDescripcion() {
    if (!this.formulario || !this.formulario.slider_id) {
      apprise('ID inválido');
      return;
    }

    let descripcion = $('#snEditarDescripcion').summernote('code');
    bloquearUI('Guardando descripción...');

    const formData = new FormData();
    formData.append('slider_id', this.formulario.slider_id);
    formData.append('descripcion', descripcion);

    axios.post(this.apphost + '/slider/actualizarDescripcion', formData)
      .then(res => {
        desbloquearUI();
        if (res.data && res.data.success) {
          apprise('Descripción actualizada correctamente');
          $('#modalEditarSlider').modal('hide');
          this.obtenerSliders();
        } else {
          apprise('Error: ' + (res.data.error || 'Error desconocido'));
        }
      })
      .catch(() => {
        desbloquearUI();
        apprise('Error de conexión');
      });
  },

  abrirModalEditar(s) {
    let fc = s.fecha_creacion;
    let ff = s.fecha_fin;
    if (fc && fc.length === 10) fc += 'T12:00';
    if (ff && ff.length === 10) ff += 'T12:00';

    this.formulario = { 
      ...s, 
      fecha_creacion: fc,
      fecha_fin: ff,
      imgFile: null, 
      imgPreview: s.img_thumb 
    };

    $('#modalEditarSlider').modal('show');

    setTimeout(() => {
      $('#snEditarDescripcion').summernote('code', s.descripcion || '');
    }, 200);
  },

  guardarEdicion() {
    const fc = new Date(this.formulario.fecha_creacion);
    const ff = new Date(this.formulario.fecha_fin);

    if (isNaN(fc.getTime()) || isNaN(ff.getTime())) {
      return apprise('Debes seleccionar fechas válidas');
    }

    const formData = new FormData();
    formData.append('slider_id', this.formulario.slider_id);

    if (this.formulario.imgFile) {
      formData.append('img', this.formulario.imgFile);
    }

    const descripcion = $('#snEditarDescripcion').summernote('code');

    formData.append('orden', this.formulario.orden);
    formData.append('is_visible', this.formulario.is_visible);
    formData.append('fecha_creacion', this.formulario.fecha_creacion);
    formData.append('fecha_fin', this.formulario.fecha_fin);
    formData.append('neg_id', this.formulario.neg_id);
    formData.append('grupo', this.formulario.grupo || '');
    formData.append('descripcion', descripcion);

    bloquearUI('Actualizando slider...');

    setTimeout(() => {
      fetch(this.apphost + '/slider/editar', {
        method: 'POST',
        body: formData
      })
      .then(r => r.json())
      .then(data => {
        desbloquearUI();
        if (data.success) {
          $('#modalEditarSlider').modal('hide');
          this.obtenerSliders();
          apprise('Slider actualizado');
        } else {
          apprise('Error: ' + (data.error || 'Desconocido'));
        }
      })
      .catch(e => {
        desbloquearUI();
        apprise('Error de red');
        console.error(e);
      });
    }, 50);
  },

  activarDrag() {
    const vm = this;
    $('#sortable').sortable({
      handle: '.drag-handle',
      update: function () {
        let orden = [];
        $('#sortable tr').each(function (index) {
          orden.push({
            slider_id: $(this).data('id'),
            orden: index + 1
          });
        });

        fetch(vm.apphost + '/slider/ordenar', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ orden })
        })
        .then(r => r.json())
        .then(() => {
          vm.obtenerSliders();
        });
      }
    });
  },

  eliminarSlider(s) {
    apprise(`¿Eliminar slider #${s.slider_id}?`, { confirm: true }, r => {
      if (r) {
        fetch(this.apphost + '/slider/eliminar', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ slider_id: s.slider_id })
        }).then(() => {
          this.obtenerSliders();
        });
      }
    });
  },

  abrirModalDetalle(s) {
    fetch(this.apphost + '/slider/detalle/' + s.slider_id)
      .then(r => r.json())
      .then(data => {
        this.detalle = { ...data, img_thumb: data.img };
        $('#modalDetalleSlider').modal('show');
      });
  }
};