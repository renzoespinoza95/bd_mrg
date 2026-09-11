const categoriaMethods = {
  abrirCategorias() {
    bloquearUI('Cargando categorías...');
    axios.get(`${this.apphost}/xoxo/reg_cat/listar`)
      .then(r => {
        this.categorias = r.data.data || [];
        this.$nextTick(() => {
          if (!this.dtCat) {
            this.dtCat = $('#tablaCat').DataTable({
              language: (typeof dt_language !== 'undefined' ? dt_language : undefined),
              scrollX: true,
              dom: 'frtip',
              order: [[0, 'desc']]
            });

            const self = this;
            $('#tablaCat tbody')
              .on('click', '.editar-cat', function () {
                const id = $(this).data('id');
                const row = self.categorias.find(x => x.cat_pag_web_id == id);
                self.abrirEditarCategoria(row);
              })
              .on('click', '.eliminar-cat', function () {
                const id = $(this).data('id');
                self.eliminarCategoria(id);
              });
          }

          this.dtCat.clear();
          this.categorias.forEach(c => {
            const vistaThumb = c.url_img 
              ? `<img src="${c.url_img}" style="max-width: 60px; max-height: 40px; border-radius: 3px; object-fit: cover;">`
              : `<span class="muted" style="font-size: 11px;">Sin img</span>`;

            this.dtCat.row.add([
              c.cat_pag_web_id,
              vistaThumb,
              c.titulo,
              c.clave_txt || '',
              `
              <div class="btn-group">
                <button class="btn btn-mini btn-primary dropdown-toggle" data-toggle="dropdown">
                  Opciones <span class="caret"></span>
                </button>
                <ul class="dropdown-menu pull-right">
                  <li><a href="#" class="editar-cat" data-id="${c.cat_pag_web_id}">Editar</a></li>
                  <li><a href="#" class="eliminar-cat" data-id="${c.cat_pag_web_id}">Eliminar</a></li>
                </ul>
              </div>
              `
            ]);
          });

          this.dtCat.draw();
          $('#modalCategorias').modal('show');
        });
      })
      .finally(() => desbloquearUI());
  },

  abrirCrearCategoria() {
    this.catForm = { titulo: '', clave_txt: '', url_img: '' };
    $('#modalCategorias').modal('hide');
    $('#modalCrearCategoria').modal('show');
  },

  guardarCategoria() {
    if (!this.catForm.titulo) {
      return apprise('Escribe el título');
    }
    bloquearUI('Guardando categoría...');
    axios.post(`${this.apphost}/xoxo/reg_cat/crear`, this.catForm)
      .then(() => {
        $('#modalCrearCategoria').modal('hide');
        this.cargarTodo();
        setTimeout(() => {
          this.abrirCategorias();
        }, 300);
      })
      .finally(() => desbloquearUI());
  },

  abrirEditarCategoria(row) {
    this.catForm = {
      cat_pag_web_id: row.cat_pag_web_id,
      titulo: row.titulo,
      clave_txt: row.clave_txt || '',
      url_img: row.url_img || ''
    };
    $('#modalCategorias').modal('hide');
    setTimeout(() => {
      $('#modalEditarCategoria').modal('show');
    }, 200);
  },

  actualizarCategoria() {
    if (!this.catForm.titulo) {
      return apprise('Escribe el título');
    }
    bloquearUI('Actualizando categoría...');
    axios.post(`${this.apphost}/xoxo/reg_cat/editar`, {
      cat_pag_web_id: this.catForm.cat_pag_web_id,
      titulo: this.catForm.titulo,
      clave_txt: this.catForm.clave_txt,
      url_img: this.catForm.url_img
    })
    .then(() => {
      $('#modalEditarCategoria').modal('hide');
      this.cargarTodo();
      setTimeout(() => {
        this.abrirCategorias();
      }, 300);
    })
    .finally(() => desbloquearUI());
  },

  eliminarCategoria(id) {
    apprise('¿Eliminar esta categoría?', { confirm: true }, ok => {
      if (!ok) return;
      bloquearUI('Eliminando categoría...');
      axios.post(`${this.apphost}/xoxo/reg_cat/eliminar`, { cat_pag_web_id: id })
        .then(() => {
          this.cargarTodo();
          this.abrirCategorias();
        })
        .finally(() => desbloquearUI());
    });
  }
};