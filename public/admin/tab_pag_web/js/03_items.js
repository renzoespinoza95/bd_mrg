const itemMethods = {
  // Carga inicial completa de categorías, subcategorías e ítems
  cargarTodo() {
    bloquearUI('Cargando catálogo...');
    Promise.all([
      axios.get(`${this.apphost}/xoxo/reg_cat/listar`),
      axios.get(`${this.apphost}/xoxo/reg_subcat/listar`),
      axios.get(`${this.apphost}/xoxo/reg_item/listar`)
    ])
    .then(([catRes, subcatRes, itemRes]) => {
      this.categorias = catRes.data.data || [];
      this.subcategorias = subcatRes.data.data || [];
      this.items = itemRes.data.data || [];

      // Seleccionar automáticamente la primera categoría si existe
      if (this.categorias.length > 0 && !this.catSeleccionada) {
        this.seleccionarCategoria(this.categorias[0]);
      } else if (this.subcatSeleccionada) {
        this.filtrarTablaPorSubcat();
      }
    })
    .finally(() => desbloquearUI());
  },

  seleccionarCategoria(cat) {
    this.catSeleccionada = cat;
    const subs = this.subcategorias.filter(s => s.cat_pag_web_id == cat.cat_pag_web_id);
    if (subs.length > 0) {
      this.seleccionarSubcategoria(subs[0]);
    } else {
      this.subcatSeleccionada = null;
      this.filtrarTablaPorSubcat();
    }
  },

  seleccionarSubcategoria(subcat) {
    this.subcatSeleccionada = subcat;
    this.filtrarTablaPorSubcat();
  },

  contarSubcats(cat_id) {
    return this.subcategorias.filter(s => s.cat_pag_web_id == cat_id).length;
  },

  contarItems(subcat_id) {
    return this.items.filter(i => i.subcat_pag_web_id == subcat_id).length;
  },

  filtrarTablaPorSubcat() {
    this.$nextTick(() => {
      if (!this.dt) {
        this.dt = $('#tablaItems').DataTable({
          language: (typeof dt_language !== 'undefined' ? dt_language : undefined),
          scrollX: true,
          dom: 'frtip',
          order: [[0, 'desc']]
        });

        const self = this;
        $('#tablaItems tbody')
          .on('click', '.editar', function () {
            const id = $(this).data('id');
            const row = self.items.find(x => x.item_pag_web_id == id);
            self.abrirEditarItem(row);
          })
          .on('click', '.eliminar', function () {
            const id = $(this).data('id');
            self.eliminar(id);
          })
          .on('click', '.img', function () {
            self.itemActual = $(this).data('id');
            self.verImagenes(self.itemActual);
          })
          .on('click', '.vid', function () {
            self.itemActual = $(this).data('id');
            self.verVideos(self.itemActual);
          });
      }

      this.dt.clear();

      const itemsFiltrados = this.subcatSeleccionada
        ? this.items.filter(i => i.subcat_pag_web_id == this.subcatSeleccionada.subcat_pag_web_id)
        : [];

      itemsFiltrados.forEach(i => {
        this.dt.row.add([
          i.item_pag_web_id,
          i.titulo,
          i.precio,
          i.stock,
          `
          <div class="btn-group">
            <button class="btn btn-mini dropdown-toggle" data-toggle="dropdown">
              ⚙ <span class="caret"></span>
            </button>
            <ul class="dropdown-menu pull-right">
              <li><a href="#" class="editar" data-id="${i.item_pag_web_id}">Editar</a></li>
              <li><a href="#" class="eliminar" data-id="${i.item_pag_web_id}">Eliminar</a></li>
              <li class="divider"></li>
              <li><a href="#" class="img" data-id="${i.item_pag_web_id}">Imagen</a></li>
              <li><a href="#" class="vid" data-id="${i.item_pag_web_id}">Video</a></li>
            </ul>
          </div>
          `
        ]);
      });

      this.dt.draw();
    });
  },

  abrirNuevoItemDirecto() {
    this.itemForm = {
      item_pag_web_id: null,
      titulo: '',
      precio: 0,
      stock: 0,
      contenido: '',
      subtitulo_detalle: '',
      html01: '',
      html02: '',
      clave_txt: '',
      cat: this.catSeleccionada,
      subcat: this.subcatSeleccionada
    };

    $('#modalItem').modal('show');

    this.$nextTick(() => {
      if ($('#txtContenido').next('.note-editor').length) $('#txtContenido').summernote('destroy');
      if ($('#txtSubtitulo').next('.note-editor').length) $('#txtSubtitulo').summernote('destroy');
      if ($('#txtHtml01').next('.note-editor').length) $('#txtHtml01').summernote('destroy');
      if ($('#txtHtml02').next('.note-editor').length) $('#txtHtml02').summernote('destroy');

      $('#txtContenido').summernote({ height: 200 }).summernote('code', '');
      $('#txtSubtitulo').summernote({ height: 150 }).summernote('code', '');
      $('#txtHtml01').summernote({ height: 150 }).summernote('code', '');
      $('#txtHtml02').summernote({ height: 150 }).summernote('code', '');
    });
  },

  abrirNuevoItem() {
    this.itemForm = {
      item_pag_web_id: null,
      titulo: '',
      precio: 0,
      stock: 0,
      contenido: '',
      subtitulo_detalle: '',
      html01: '',
      html02: '',
      clave_txt: '',
      cat: this.catSeleccionada || null,
      subcat: this.subcatSeleccionada || null
    };

    $('#modalItem').modal('show');

    this.$nextTick(() => {
      if ($('#txtContenido').next('.note-editor').length) $('#txtContenido').summernote('destroy');
      if ($('#txtSubtitulo').next('.note-editor').length) $('#txtSubtitulo').summernote('destroy');
      if ($('#txtHtml01').next('.note-editor').length) $('#txtHtml01').summernote('destroy');
      if ($('#txtHtml02').next('.note-editor').length) $('#txtHtml02').summernote('destroy');

      $('#txtContenido').summernote({ height: 200 }).summernote('code', '');
      $('#txtSubtitulo').summernote({ height: 150 }).summernote('code', '');
      $('#txtHtml01').summernote({ height: 150 }).summernote('code', '');
      $('#txtHtml02').summernote({ height: 150 }).summernote('code', '');
    });
  },

  abrirEditarItem(row) {
    this.itemForm = {
      item_pag_web_id: row.item_pag_web_id,
      titulo: row.titulo,
      clave_txt: row.clave_txt || '',
      precio: row.precio,
      stock: row.stock,
      contenido: row.contenido || '',
      subtitulo_detalle: row.subtitulo_detalle || '',
      html01: row.html01 || '',
      html02: row.html02 || '',
      cat: null,
      subcat: null
    };

    const sub = this.subcategorias.find(s => s.subcat_pag_web_id == row.subcat_pag_web_id);
    if (sub) {
      const cat = this.categorias.find(c => c.cat_pag_web_id == sub.cat_pag_web_id);
      if (cat) {
        this.itemForm.cat = cat;
        this.$nextTick(() => {
          this.itemForm.subcat = sub;
        });
      }
    }

    $('#modalItem').modal('show');

    this.$nextTick(() => {
      if ($('#txtContenido').next('.note-editor').length) $('#txtContenido').summernote('destroy');
      if ($('#txtSubtitulo').next('.note-editor').length) $('#txtSubtitulo').summernote('destroy');
      if ($('#txtHtml01').next('.note-editor').length) $('#txtHtml01').summernote('destroy');
      if ($('#txtHtml02').next('.note-editor').length) $('#txtHtml02').summernote('destroy');

      $('#txtContenido').summernote({ height: 200 }).summernote('code', row.contenido || '');
      $('#txtSubtitulo').summernote({ height: 150 }).summernote('code', row.subtitulo_detalle || '');
      $('#txtHtml01').summernote({ height: 150 }).summernote('code', row.html01 || '');
      $('#txtHtml02').summernote({ height: 150 }).summernote('code', row.html02 || '');
    });
  },

  guardarItem() {
    this.itemForm.contenido = $('#txtContenido').summernote('code');
    this.itemForm.subtitulo_detalle = $('#txtSubtitulo').summernote('code');
    this.itemForm.html01 = $('#txtHtml01').summernote('code');
    this.itemForm.html02 = $('#txtHtml02').summernote('code');

    const url = this.itemForm.item_pag_web_id
      ? `${this.apphost}/xoxo/reg_item/editar`
      : `${this.apphost}/xoxo/reg_item/crear`;

    if (!this.itemForm.subcat) {
      return apprise('Selecciona subcategoría');
    }

    bloquearUI('Guardando item...');

    axios.post(url, {
      item_pag_web_id: this.itemForm.item_pag_web_id,
      titulo: this.itemForm.titulo,
      clave_txt: this.itemForm.clave_txt,
      precio: this.itemForm.precio,
      stock: this.itemForm.stock,
      contenido: this.itemForm.contenido,
      subtitulo_detalle: this.itemForm.subtitulo_detalle,
      html01: this.itemForm.html01,
      html02: this.itemForm.html02,
      subcat_id: this.itemForm.subcat?.subcat_pag_web_id || null
    })
    .then(() => {
      $('#modalItem').modal('hide');
      this.cargarTodo();
    })
    .finally(() => desbloquearUI());
  },

  eliminar(id) {
    apprise('¿Eliminar este ítem?', { confirm: true }, ok => {
      if (!ok) return;
      bloquearUI('Eliminando ítem...');
      axios.post(`${this.apphost}/xoxo/reg_item/eliminar`, { item_pag_web_id: id })
        .then(() => this.cargarTodo())
        .finally(() => desbloquearUI());
    });
  }
};