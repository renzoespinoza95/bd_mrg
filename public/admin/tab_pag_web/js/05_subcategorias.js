const subcategoriaMethods = {
  abrirSubcategorias() {
    bloquearUI('Cargando subcategorías...');
    axios.get(`${this.apphost}/xoxo/reg_subcat/listar`)
      .then(r => {
        this.subcategorias = r.data.data || [];
        this.$nextTick(() => {
          if (!this.dtSubcat) {
            this.dtSubcat = $('#tablaSubcat').DataTable({
              language: (typeof dt_language !== 'undefined' ? dt_language : undefined),
              scrollX: true,
              dom: 'frtip',
              order: [[0, 'desc']]
            });

            const self = this;
            $('#tablaSubcat tbody')
              .on('click', '.editar-subcat', function () {
                const id = $(this).data('id');
                const row = self.subcategorias.find(x => x.subcat_pag_web_id == id);
                self.abrirEditarSubcat(row);
              })
              .on('click', '.eliminar-subcat', function () {
                const id = $(this).data('id');
                self.eliminarSubcat(id);
              });
          }

          this.dtSubcat.clear();
          this.subcategorias.forEach(s => {
            const vistaThumb = s.url_img 
              ? `<img src="${s.url_img}" style="max-width: 60px; max-height: 40px; border-radius: 3px; object-fit: cover;">`
              : `<span class="muted" style="font-size: 11px;">Sin img</span>`;

            this.dtSubcat.row.add([
              s.subcat_pag_web_id,
              vistaThumb,
              s.titulo,
              s.clave_txt || '',
              s.categoria || '',
              `
              <div class="btn-group">
                <button class="btn btn-warning btn-small dropdown-toggle" data-toggle="dropdown">
                  Opciones <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right">
                  <li><a href="#" class="editar-subcat" data-id="${s.subcat_pag_web_id}">Editar</a></li>
                  <li><a href="#" class="eliminar-subcat" data-id="${s.subcat_pag_web_id}">Eliminar</a></li>
                </ul>
              </div>
              `
            ]);
          });

          this.dtSubcat.draw();
          $('#modalSubcategorias').modal('show');
        });
      })
      .finally(() => desbloquearUI());
  },

  abrirCrearSubcatDirecta() {
    this.subcatForm = {
      titulo: '',
      clave_txt: '',
      url_img: '',
      cat: this.catSeleccionada
    };
    $('#modalCrearSubcat').modal('show');
  },

  abrirCrearSubcat() {
    this.subcatForm = { 
      titulo: '', 
      clave_txt: '', 
      url_img: '', 
      cat: this.catSeleccionada || null 
    };
    $('#modalSubcategorias').modal('hide');
    setTimeout(() => {
      $('#modalCrearSubcat').modal('show');
    }, 200);
  },

  guardarSubcat() {
    if (!this.subcatForm.titulo) return apprise('Escribe el título');
    if (!this.subcatForm.cat) return apprise('Selecciona categoría');

    bloquearUI('Guardando subcategoría...');
    axios.post(`${this.apphost}/xoxo/reg_subcat/crear`, {
      titulo: this.subcatForm.titulo,
      clave_txt: this.subcatForm.clave_txt,
      url_img: this.subcatForm.url_img,
      cat_id: this.subcatForm.cat.cat_pag_web_id
    })
    .then(() => {
      $('#modalCrearSubcat').modal('hide');
      this.cargarTodo();
      setTimeout(() => {
        this.abrirSubcategorias();
      }, 300);
    })
    .finally(() => desbloquearUI());
  },

  abrirEditarSubcat(row) {
    bloquearUI('Cargando datos...');
    axios.get(`${this.apphost}/xoxo/reg_cat/listar`)
      .then(r => {
        this.categorias = r.data.data || [];
        this.subcatForm = {
          subcat_pag_web_id: row.subcat_pag_web_id,
          titulo: row.titulo,
          clave_txt: row.clave_txt || '',
          url_img: row.url_img || '',
          cat: null
        };

        const cat = this.categorias.find(c => c.cat_pag_web_id == row.cat_pag_web_id);
        if (cat) {
          this.$nextTick(() => {
            this.subcatForm.cat = cat;
          });
        }

        $('#modalSubcategorias').modal('hide');
        setTimeout(() => {
          $('#modalEditarSubcat').modal('show');
        }, 200);
      })
      .finally(() => desbloquearUI());
  },

  actualizarSubcat() {
    if (!this.subcatForm.titulo) return apprise('Escribe el título');
    if (!this.subcatForm.cat) return apprise('Selecciona categoría');

    bloquearUI('Actualizando subcategoría...');
    axios.post(`${this.apphost}/xoxo/reg_subcat/editar`, {
      subcat_pag_web_id: this.subcatForm.subcat_pag_web_id,
      titulo: this.subcatForm.titulo,
      clave_txt: this.subcatForm.clave_txt,
      url_img: this.subcatForm.url_img,
      cat_id: this.subcatForm.cat.cat_pag_web_id
    })
    .then(() => {
      $('#modalEditarSubcat').modal('hide');
      this.cargarTodo();
      setTimeout(() => {
        this.abrirSubcategorias();
      }, 300);
    })
    .finally(() => desbloquearUI());
  },

  eliminarSubcat(id) {
    apprise('¿Eliminar esta subcategoría?', { confirm: true }, ok => {
      if (!ok) return;
      bloquearUI('Eliminando subcategoría...');
      axios.post(`${this.apphost}/xoxo/reg_subcat/eliminar`, { subcat_pag_web_id: id })
        .then(() => {
          this.cargarTodo();
          this.abrirSubcategorias();
        })
        .finally(() => desbloquearUI());
    });
  }
};