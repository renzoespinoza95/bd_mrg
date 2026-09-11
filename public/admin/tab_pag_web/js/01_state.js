const pagWebState = {
  apphost: (typeof window.apphost !== 'undefined' ? window.apphost : ''),
  
  // 🔥 Selección actual de columnas jerárquicas
  catSeleccionada: null,
  subcatSeleccionada: null,

  videoFormEditar: {
    pag_item_vid_id: null,
    titulo: ''
  },
  items: [],
  urlImagenPegar: '',
  categorias: [],
  subcategorias: [],
  videoActual: {},
  itemForm: {
    item_pag_web_id: null,
    titulo: '',
    precio: 0,
    subtitulo_detalle: '',
    html01: '',
    html02: '',
    stock: 0,
    clave_txt: '',
    contenido: '',
    cat: null,
    subcat: null
  },
  catForm: {
    cat_pag_web_id: null,
    titulo: '',
    clave_txt: ''
  },
  videoForm: {
    titulo: '',
    codigo: ''
  },
  dtCat: null,
  subcatForm: {
    subcat_pag_web_id: null,
    titulo: '',
    clave_txt: '',
    cat: null
  },
  imagenes: [],
  videos: [],
  dtSubcat: null,
  dt: null,
  preview: null,
  itemActual: 0
};