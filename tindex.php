<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Ferreyros CAT</title>
  <!-- Google Fonts: Bebas Neue y Montserrat -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@300;400;600;700;800;900&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

  <style>
    :root {
      --cat-yellow: #ffcd00;
      --cat-orange-gradient: linear-gradient(90deg, #ff8800 0%, #ff5100 60%, #ff3700 100%);
      --cat-orange-dark: #e02f00;
      --cat-black: #111111;
      
      /* Variables de Fuentes */
      --font-body: 'Montserrat', sans-serif;
      --font-titles: 'Bebas Neue', sans-serif;
    }

    body {
      font-family: var(--font-body);
      color: #333;
      background-color: #f5f6f8;
      overflow-x: hidden;
    }

    /* Títulos Universales */
    h1, h2, h3, h4, h5, h6, .display-6 {
      font-family: var(--font-titles);
      letter-spacing: 1px;
    }

    /* Navegación de escritorio */
    .main-nav .nav-link {
      font-family: var(--font-titles);
      color: #111;
      font-size: 1.25rem; /* Ajustado para Bebas Neue */
      letter-spacing: 1px;
      padding: 0.5rem 0.8rem;
    }
    .main-nav .nav-link:hover {
      color: #ff5100;
    }

    /* Botón Hamburguesa / Drawer estilo corporativo */
    .btn-drawer-toggle {
      background: var(--cat-orange-gradient);
      color: #fff;
      border: none;
      width: 44px;
      height: 44px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 3px 10px rgba(255, 81, 0, 0.35);
      cursor: pointer;
      transition: transform 0.2s ease;
    }
    .btn-drawer-toggle:hover {
      transform: scale(1.05);
      color: #fff;
    }

    /* Modal / Drawer en el medio para móvil */
    .modal-drawer .modal-content {
      border-radius: 16px;
      border: none;
      background: #18191c;
      color: #ffffff;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.45);
      overflow: hidden;
    }
    .modal-drawer .modal-header {
      border-bottom: 1px solid rgba(255, 255, 255, 0.1);
      padding: 16px 20px;
    }
    .modal-drawer .modal-body {
      padding: 20px 24px;
    }
    .modal-drawer .drawer-nav-link {
      font-family: var(--font-titles);
      color: #eee;
      text-decoration: none;
      font-size: 1.4rem; /* Ajustado para Bebas Neue */
      letter-spacing: 1px;
      padding: 10px 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.05);
      transition: color 0.2s ease;
    }
    .modal-drawer .drawer-nav-link:hover {
      color: var(--cat-yellow);
    }
    .modal-drawer .utility-sublink {
      font-family: var(--font-body);
      color: #aaa;
      text-decoration: none;
      font-size: 0.78rem;
      font-weight: 600;
      padding: 6px 0;
      display: block;
    }
    .modal-drawer .utility-sublink:hover {
      color: #fff;
    }

    /* ========================================================
       BOTÓN PÍLDORA UNIFICADO CON DEGRADADO CORPORATIVO
       ======================================================== */
    .btn-cat-pill {
      font-family: var(--font-titles);
      display: inline-flex;
      align-items: center;
      justify-content: space-between;
      background: var(--cat-orange-gradient);
      color: #ffffff !important;
      letter-spacing: 1.5px;
      border-radius: 50px;
      padding: 5px 6px 5px 22px;
      text-decoration: none;
      border: none;
      box-shadow: 0 4px 12px rgba(255, 61, 0, 0.35);
      transition: transform 0.2s ease, box-shadow 0.2s ease;
      cursor: pointer;
    }
    .btn-cat-pill:hover {
      transform: translateY(-2px);
      box-shadow: 0 6px 18px rgba(255, 61, 0, 0.45);
    }
    .btn-cat-pill .pill-text {
      font-size: 1.15rem; /* Ajustado para Bebas Neue */
      margin-right: 14px;
      margin-top: 2px;
    }
    .btn-cat-pill .pill-circle {
      background-color: #ffffff;
      color: #ff4500;
      width: 32px;
      height: 32px;
      border-radius: 50%;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      box-shadow: 0 2px 5px rgba(0,0,0,0.15);
      flex-shrink: 0;
    }

    /* Variante Grande (Solicite Cotización) */
    .btn-cat-pill-lg {
      padding: 7px 8px 7px 28px;
    }
    .btn-cat-pill-lg .pill-text {
      font-size: 1.4rem; /* Ajustado para Bebas Neue */
      margin-right: 18px;
    }
    .btn-cat-pill-lg .pill-circle {
      width: 40px;
      height: 40px;
      font-size: 1.1rem;
    }

    /* Variante Pequeña */
    .btn-cat-pill-sm {
      padding: 3px 4px 3px 14px;
    }
    .btn-cat-pill-sm .pill-text {
      font-size: 1rem;
      margin-right: 8px;
      margin-top: 2px;
    }
    .btn-cat-pill-sm .pill-circle {
      width: 24px;
      height: 24px;
      font-size: 0.7rem;
    }

    /* ========================================================
       HERO SLIDER (SOLO IMÁGENES RECTANGULARES)
       ======================================================== */
    .hero-slider-section {
      position: relative;
      background-color: #000;
    }
    .carousel-item img {
      width: 100%;
      height: 420px;
      object-fit: cover;
      display: block;
    }
    @media (max-width: 768px) {
      .carousel-item img {
        height: 260px;
      }
    }

    .carousel-control-prev, .carousel-control-next {
      width: 50px;
      opacity: 0.85;
      z-index: 10;
    }
    .carousel-indicators {
      margin-bottom: 1.2rem;
      z-index: 15;
    }
    .carousel-indicators [data-bs-target] {
      width: 12px;
      height: 12px;
      border: 1px solid #fff;
      background-color: transparent;
      opacity: 0.7;
      margin: 0 4px;
    }
    .carousel-indicators .active {
      background-color: #ff5100;
      border-color: #ff5100;
      opacity: 1;
    }

    /* Posicionamiento del Botón de Cotización */
    .quote-button-anchor {
      position: absolute;
      right: 5%;
      bottom: -22px;
      z-index: 20;
    }

    /* ========================================================
       CUADRADOS IDÉNTICOS (ASPECT-RATIO 1/1) CON HOVER JS
       ======================================================== */
    .tile-card {
      position: relative;
      width: 100%;
      aspect-ratio: 1 / 1;
      overflow: hidden;
      background-color: #1a1a1a;
      border-radius: 6px;
      cursor: pointer;
      box-shadow: 0 4px 10px rgba(0,0,0,0.08);
    }
    .tile-card img {
      width: 100%;
      height: 100%;
      object-fit: cover;
      transition: transform 0.45s ease;
    }
    .tile-card.is-active img {
      transform: scale(1.08);
    }

    .tile-header, .tile-footer {
      font-family: var(--font-titles);
      letter-spacing: 1px;
      position: absolute;
      left: 0;
      right: 0;
      background: rgba(18, 18, 18, 0.82);
      color: #fff;
      padding: 10px 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 1.15rem;
      z-index: 2;
    }
    .tile-header { top: 0; }
    .tile-footer { bottom: 0; }

    .tile-overlay {
      position: absolute;
      inset: 0;
      background-color: rgba(16, 24, 32, 0.92);
      color: #fff;
      padding: 22px;
      display: flex;
      flex-direction: column;
      justify-content: space-between;
      opacity: 0;
      visibility: hidden;
      transition: opacity 0.35s ease, visibility 0.35s ease;
      z-index: 5;
    }
    .tile-overlay.is-active {
      opacity: 1;
      visibility: visible;
    }
    .tile-overlay .overlay-title {
      font-family: var(--font-titles);
      font-size: 1.4rem;
      letter-spacing: 1px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(255,255,255,0.15);
      padding-bottom: 8px;
    }
    .tile-overlay .overlay-text {
      font-family: var(--font-body);
      font-size: 0.82rem;
      line-height: 1.5;
      font-weight: 400;
      color: #cfd4dc;
      margin: auto 0;
    }

    /* Strip Amarillo */
    .yellow-strip {
      background-color: var(--cat-yellow);
      padding: 22px 0;
    }

    /* Footer */
    footer {
      background-color: #0d0d0d;
      color: #888;
      font-size: 0.75rem;
      padding: 40px 0 20px;
    }
    footer a {
      font-family: var(--font-titles);
      font-size: 1.1rem;
      letter-spacing: 1px;
      color: #fff;
      text-decoration: none;
    }
    
    /* Textos Pequeños extra */
    .small-body-text {
      font-family: var(--font-body);
      font-size: 0.75rem;
    }
  </style>
</head>
<body>

  <!-- Barra Principal / Header (Sin la parte superior anterior) -->
  <header class="bg-white border-bottom py-2">
    <div class="container d-flex justify-content-between align-items-center">
      <!-- Logo Ferreyros CAT -->
      <div class="d-flex align-items-center" style="font-family: var(--font-body);">
        <span class="bg-warning px-2 py-1 fw-bold me-1 text-black fs-5">Ferreyros</span>
        <span class="bg-dark text-white px-2 py-1 fw-bold fs-5">CAT</span>
      </div>

      <!-- Menú Desktop Horizontal -->
      <nav class="nav main-nav d-none d-lg-flex">
        <a class="nav-link" href="#">Nosotros <i class="fa-solid fa-chevron-down fa-2xs ms-1"></i></a>
        <a class="nav-link" href="#">Productos <i class="fa-solid fa-chevron-down fa-2xs ms-1"></i></a>
        <a class="nav-link" href="#">Repuestos <i class="fa-solid fa-chevron-down fa-2xs ms-1"></i></a>
        <a class="nav-link" href="#">Servicios <i class="fa-solid fa-chevron-down fa-2xs ms-1"></i></a>
        <a class="nav-link" href="#">Tecnología <i class="fa-solid fa-chevron-down fa-2xs ms-1"></i></a>
        <a class="nav-link" href="#">Novedades</a>
        <a class="nav-link" href="#">Promociones</a>
      </nav>

      <!-- Botón Drawer Mobile a la altura del logo (Solo visible en pantallas pequeñas) -->
      <button class="btn-drawer-toggle d-lg-none" type="button" data-bs-toggle="modal" data-bs-target="#mobileMenuDrawer" aria-label="Abrir Menú">
        <i class="fa-solid fa-bars fs-5"></i>
      </button>
    </div>
  </header>

  <!-- Modal Drawer Centrado Responsivo -->
  <div class="modal fade modal-drawer" id="mobileMenuDrawer" tabindex="-1" aria-labelledby="mobileMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <div class="d-flex align-items-center" style="font-family: var(--font-body);">
            <span class="bg-warning px-2 py-1 fw-bold me-1 text-black fs-6">Ferreyros</span>
            <span class="bg-dark text-white px-2 py-1 fw-bold fs-6">CAT</span>
          </div>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <div class="mb-3">
            <input type="text" class="form-control rounded-pill bg-dark text-white border-secondary small-body-text" placeholder="Buscar productos, repuestos...">
          </div>

          <!-- Enlaces Principales -->
          <nav class="d-flex flex-column mb-3">
            <a href="#" class="drawer-nav-link">Nosotros <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Productos <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Repuestos <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Servicios <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Tecnología <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Novedades <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Promociones <i class="fa-solid fa-chevron-right fa-xs"></i></a>
          </nav>

          <!-- Enlaces de utilidad integrados para móvil -->
          <div class="pt-2 border-top border-secondary">
            <div class="row">
              <div class="col-6">
                <a href="#" class="utility-sublink"><i class="fa-solid fa-laptop me-1"></i> FERREYNET</a>
                <a href="#" class="utility-sublink"><i class="fa-solid fa-location-dot me-1"></i> LOCALES</a>
              </div>
              <div class="col-6">
                <a href="#" class="utility-sublink"><i class="fa-solid fa-envelope me-1"></i> ESCRÍBANOS</a>
                <a href="#" class="utility-sublink"><i class="fa-solid fa-headset me-1"></i> ATENCIÓN</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>

  <!-- Hero Slider (Solo Imágenes Rectangulares) -->
  <section class="hero-slider-section">
    <div id="heroCatCarousel" class="carousel slide" data-bs-ride="carousel" data-bs-interval="5000">
      <div class="carousel-indicators">
        <button type="button" data-bs-target="#heroCatCarousel" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
        <button type="button" data-bs-target="#heroCatCarousel" data-bs-slide-to="1" aria-label="Slide 2"></button>
        <button type="button" data-bs-target="#heroCatCarousel" data-bs-slide-to="2" aria-label="Slide 3"></button>
      </div>

      <div class="carousel-inner">
        <div class="carousel-item active">
          <img src="https://images.unsplash.com/photo-1579829366248-204fe8413f31?auto=format&fit=crop&w=1600&h=600&q=80" alt="Maquinaria CAT">
        </div>
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1581094288338-2314dddb7ece?auto=format&fit=crop&w=1600&h=600&q=80" alt="Excavadora CAT">
        </div>
        <div class="carousel-item">
          <img src="https://images.unsplash.com/photo-1581092160607-ee22621dd758?auto=format&fit=crop&w=1600&h=600&q=80" alt="Ingeniería CAT">
        </div>
      </div>

      <button class="carousel-control-prev" type="button" data-bs-target="#heroCatCarousel" data-bs-slide="prev">
        <span class="btn-cat-pill btn-cat-pill-sm p-1">
          <span class="pill-circle"><i class="fa-solid fa-arrow-left fa-xs"></i></span>
        </span>
      </button>
      <button class="carousel-control-next" type="button" data-bs-target="#heroCatCarousel" data-bs-slide="next">
        <span class="btn-cat-pill btn-cat-pill-sm p-1">
          <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
        </span>
      </button>
    </div>

    <!-- Botón Solicite una Cotización -->
    <div class="quote-button-anchor">
      <a href="#" class="btn-cat-pill btn-cat-pill-lg">
        <span class="pill-text">SOLICITE UNA COTIZACIÓN</span>
        <span class="pill-circle"><i class="fa-solid fa-arrow-right"></i></span>
      </a>
    </div>
  </section>

  <!-- Grid Uniforme de Cuadrados Idénticos (Aspect Ratio 1/1) -->
  <main class="container pt-5 pb-4">
    <div class="row row-cols-1 row-cols-sm-2 row-cols-md-4 g-3 mb-5 mt-2">
      
      <!-- 1. Equipos -->
      <div class="col">
        <div class="tile-card"
             data-title="EQUIPOS" 
             data-text="Invierte en el futuro de tu negocio. Nuestros nuevos equipos y generadores Cat están diseñados para ser duraderos y confiables.">
          <div class="tile-header">Equipos <i class="fa-solid fa-plus"></i></div>
          <img src="https://images.unsplash.com/photo-1581094288338-2314dddb7ece?auto=format&fit=crop&w=600&q=80" alt="Equipos">
          <div class="tile-overlay">
            <div class="overlay-title"><span>EQUIPOS</span> <i class="fa-solid fa-plus"></i></div>
            <p class="overlay-text"></p>
            <a href="#" class="btn-cat-pill w-100">
              <span class="pill-text">EXPLORAR</span>
              <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
            </a>
          </div>
        </div>
      </div>

      <!-- 2. Servicios -->
      <div class="col">
        <div class="tile-card"
             data-title="SERVICIOS" 
             data-text="Soporte técnico integral en talleres y campo certificado, monitoreo satelital y soluciones a la medida de tu operación.">
          <div class="tile-footer">Servicios <i class="fa-solid fa-plus"></i></div>
          <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=600&q=80" alt="Servicios">
          <div class="tile-overlay">
            <div class="overlay-title"><span>SERVICIOS</span> <i class="fa-solid fa-plus"></i></div>
            <p class="overlay-text"></p>
            <a href="#" class="btn-cat-pill w-100">
              <span class="pill-text">EXPLORAR</span>
              <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
            </a>
          </div>
        </div>
      </div>

      <!-- 3. Repuestos -->
      <div class="col">
        <div class="tile-card"
             data-title="REPUESTOS" 
             data-text="Disponibilidad inmediata con más de 1.4 millones de repuestos originales Cat diseñados para alargar la vida útil de su flota.">
          <div class="tile-header">Repuestos <i class="fa-solid fa-plus"></i></div>
          <img src="https://images.unsplash.com/photo-1586528116311-ad8dd3c8310d?auto=format&fit=crop&w=600&q=80" alt="Repuestos">
          <div class="tile-overlay">
            <div class="overlay-title"><span>REPUESTOS</span> <i class="fa-solid fa-plus"></i></div>
            <p class="overlay-text"></p>
            <a href="#" class="btn-cat-pill w-100">
              <span class="pill-text">EXPLORAR</span>
              <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
            </a>
          </div>
        </div>
      </div>

      <!-- 4. Alquiler -->
      <div class="col">
        <div class="tile-card"
             data-title="ALQUILER" 
             data-text="Flotas modernas de excavadoras, cargadores y rodillos listas para proyectos inmediatos con respaldo técnico incluido.">
          <div class="tile-header">Alquiler <i class="fa-solid fa-plus"></i></div>
          <img src="https://images.unsplash.com/photo-1579829366248-204fe8413f31?auto=format&fit=crop&w=600&q=80" alt="Alquiler">
          <div class="tile-overlay">
            <div class="overlay-title"><span>ALQUILER</span> <i class="fa-solid fa-plus"></i></div>
            <p class="overlay-text"></p>
            <a href="#" class="btn-cat-pill w-100">
              <span class="pill-text">EXPLORAR</span>
              <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
            </a>
          </div>
        </div>
      </div>

      <!-- 5. Tecnología -->
      <div class="col">
        <div class="tile-card"
             data-title="TECNOLOGÍA" 
             data-text="Sistemas autónomos, telemetría y soluciones Cat Product Link para optimizar el rendimiento y consumo de su maquinaria.">
          <div class="tile-footer">Tecnología <i class="fa-solid fa-plus"></i></div>
          <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?auto=format&fit=crop&w=600&q=80" alt="Tecnología">
          <div class="tile-overlay">
            <div class="overlay-title"><span>TECNOLOGÍA</span> <i class="fa-solid fa-plus"></i></div>
            <p class="overlay-text"></p>
            <a href="#" class="btn-cat-pill w-100">
              <span class="pill-text">EXPLORAR</span>
              <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
            </a>
          </div>
        </div>
      </div>

      <!-- 6. Generadores -->
      <div class="col">
        <div class="tile-card"
             data-title="GENERADORES" 
             data-text="Suministro continuo de energía crítica y generadores diésel diseñados para las condiciones de trabajo más severas.">
          <div class="tile-header">Generadores <i class="fa-solid fa-plus"></i></div>
          <img src="https://images.unsplash.com/photo-1513836279014-a89f7a76ae86?auto=format&fit=crop&w=600&q=80" alt="Grupos Electrógenos">
          <div class="tile-overlay">
            <div class="overlay-title"><span>GENERADORES</span> <i class="fa-solid fa-plus"></i></div>
            <p class="overlay-text"></p>
            <a href="#" class="btn-cat-pill w-100">
              <span class="pill-text">EXPLORAR</span>
              <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
            </a>
          </div>
        </div>
      </div>

      <!-- 7. Ferreynet 3.0 -->
      <div class="col">
        <div class="tile-card"
             data-title="FERREYNET 3.0" 
             data-text="Portal corporativo 100% digitalizado para seguimiento de compras, cotizaciones y pedidos de servicio en línea.">
          <div class="tile-footer">Ferreynet 3.0 <i class="fa-solid fa-plus"></i></div>
          <img src="https://images.unsplash.com/photo-1531403009284-440f080d1e12?auto=format&fit=crop&w=600&q=80" alt="Ferreynet 3.0">
          <div class="tile-overlay">
            <div class="overlay-title"><span>FERREYNET 3.0</span> <i class="fa-solid fa-plus"></i></div>
            <p class="overlay-text"></p>
            <a href="#" class="btn-cat-pill w-100">
              <span class="pill-text">EXPLORAR</span>
              <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
            </a>
          </div>
        </div>
      </div>

      <!-- 8. Novedades -->
      <div class="col">
        <div class="tile-card"
             data-title="NOVEDADES" 
             data-text="Descubre las últimas innovaciones, lanzamientos oficiales CAT y eventos del sector industrial minero.">
          <div class="tile-footer">Novedades <i class="fa-solid fa-plus"></i></div>
          <img src="https://images.unsplash.com/photo-1541888946425-d0fbb186c5f7?auto=format&fit=crop&w=600&q=80" alt="Novedades">
          <div class="tile-overlay">
            <div class="overlay-title"><span>NOVEDADES</span> <i class="fa-solid fa-plus"></i></div>
            <p class="overlay-text"></p>
            <a href="#" class="btn-cat-pill w-100">
              <span class="pill-text">EXPLORAR</span>
              <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
            </a>
          </div>
        </div>
      </div>
    </div>

    <!-- Canales Secundarios Inferiores -->
    <div class="row g-4 mt-2">
      <div class="col-md-3">
        <h6 class="fw-bold text-uppercase">Ferreynet Clientes</h6>
        <div class="border p-4 text-center bg-dark text-white mb-2 fw-bold rounded" style="font-family: var(--font-titles); font-size: 1.5rem; letter-spacing: 1px;">FERREYNET</div>
        <p class="text-muted small-body-text mb-3">Monitorea tus operaciones y cotizaciones personalizadas.</p>
        <a href="#" class="btn-cat-pill btn-cat-pill-sm">
          <span class="pill-text">INGRESAR</span>
          <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-2xs"></i></span>
        </a>
      </div>

      <div class="col-md-3">
        <h6 class="fw-bold text-uppercase">Ferreyshop</h6>
        <div class="border p-4 text-center bg-light text-dark mb-2 fw-bold border-warning rounded" style="font-family: var(--font-titles); font-size: 1.5rem; letter-spacing: 1px;">FERREY<span class="text-warning">SHOP</span>.COM</div>
        <p class="text-muted small-body-text mb-3">Colecciones oficiales CAT, accesorios, botas y merchandising.</p>
        <a href="#" class="btn-cat-pill btn-cat-pill-sm">
          <span class="pill-text">COMPRAR</span>
          <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-2xs"></i></span>
        </a>
      </div>

      <div class="col-md-3">
        <h6 class="fw-bold text-uppercase">Cat Rentals</h6>
        <div class="border p-4 text-center bg-danger text-white mb-2 fw-bold rounded" style="font-family: var(--font-titles); font-size: 1.5rem; letter-spacing: 1px;">CAT RENTALS</div>
        <p class="text-muted small-body-text mb-3">Alquiler con disponibilidad inmediata para obras medianas y grandes.</p>
        <a href="#" class="btn-cat-pill btn-cat-pill-sm">
          <span class="pill-text">ALQUILAR</span>
          <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-2xs"></i></span>
        </a>
      </div>

      <div class="col-md-3">
        <div class="bg-warning p-3 text-dark rounded h-100 shadow-sm">
          <div class="fw-bold mb-2 d-flex align-items-center gap-2" style="font-family: var(--font-titles); font-size: 1.2rem; letter-spacing: 1px;">
            <i class="fa-solid fa-headset fs-5"></i> ATENCIÓN AL CLIENTE
          </div>
          <div class="small-body-text">
            <p class="mb-1 fw-bold text-dark">Call Center - Consultas</p>
            <p class="mb-2">Tlf: (51 1) 626-4000<br>clientes@ferreyros.com.pe</p>
            <p class="mb-1 fw-bold text-dark">Contact Center Repuestos</p>
            <p class="mb-0">Tlf: (51 1) 626-5000</p>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Strip Amarillo Inferior -->
  <section class="yellow-strip">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
      <a href="#" class="btn-cat-pill btn-cat-pill-sm">
        <span class="pill-text">BOLSA DE TRABAJO</span>
        <span class="pill-circle"><i class="fa-solid fa-briefcase fa-2xs"></i></span>
      </a>
      <a href="#" class="btn-cat-pill btn-cat-pill-sm">
        <span class="pill-text">COMPROBANTES</span>
        <span class="pill-circle"><i class="fa-solid fa-receipt fa-2xs"></i></span>
      </a>
      <a href="#" class="btn-cat-pill btn-cat-pill-sm">
        <span class="pill-text">RECLAMACIONES</span>
        <span class="pill-circle"><i class="fa-solid fa-book-open fa-2xs"></i></span>
      </a>
      <div class="d-flex gap-2">
        <a href="#" class="btn-cat-pill btn-cat-pill-sm p-1">
          <span class="pill-circle"><i class="fa-brands fa-facebook-f fa-xs"></i></span>
        </a>
        <a href="#" class="btn-cat-pill btn-cat-pill-sm p-1">
          <span class="pill-circle"><i class="fa-brands fa-instagram fa-xs"></i></span>
        </a>
        <a href="#" class="btn-cat-pill btn-cat-pill-sm p-1">
          <span class="pill-circle"><i class="fa-brands fa-linkedin-in fa-xs"></i></span>
        </a>
        <a href="#" class="btn-cat-pill btn-cat-pill-sm p-1">
          <span class="pill-circle"><i class="fa-brands fa-youtube fa-xs"></i></span>
        </a>
      </div>
    </div>
  </section>

  <!-- Footer -->
  <footer>
    <div class="container">
      <div class="d-flex flex-wrap gap-3 mb-4 pb-3 border-bottom border-secondary justify-content-between align-items-center">
        <div class="d-flex flex-wrap gap-3 text-uppercase">
          <a href="#">Nosotros</a>
          <a href="#">Equipos</a>
          <a href="#">Repuestos</a>
          <a href="#">Servicios</a>
          <a href="#">Tecnología</a>
          <a href="#">Novedades</a>
          <a href="#">Promociones</a>
          <a href="#">Ferreynet</a>
        </div>
        <a href="#" class="btn-cat-pill btn-cat-pill-sm">
          <span class="pill-text">CANAL DE DENUNCIAS</span>
          <span class="pill-circle"><i class="fa-solid fa-triangle-exclamation fa-2xs"></i></span>
        </a>
      </div>
      <p class="mb-1 text-light small-body-text">FERREYROS S.A. - RUC: 20100028838</p>
      <p class="mb-3 text-secondary small-body-text">COPYRIGHT © FERREYROS 2026. TODOS LOS DERECHOS RESERVADOS.</p>
    </div>
  </footer>

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Hover dinámico con JavaScript -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const interactiveTiles = document.querySelectorAll('.tile-card[data-text]');

      interactiveTiles.forEach(tile => {
        const overlay = tile.querySelector('.tile-overlay');
        const textField = overlay.querySelector('.overlay-text');
        
        if (textField) {
          textField.textContent = tile.getAttribute('data-text');
        }

        tile.addEventListener('mouseenter', () => {
          tile.classList.add('is-active');
          overlay.classList.add('is-active');
        });

        tile.addEventListener('mouseleave', () => {
          tile.classList.remove('is-active');
          overlay.classList.remove('is-active');
        });
      });
    });
  </script>
</body>
</html>