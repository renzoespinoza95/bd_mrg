<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>RD18-100 - Rodillos Compactadores | Malvex</title>
  <!-- Google Fonts: Bebas Neue y Montserrat -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link href="https://fonts.googleapis.com/css2?family=Bebas+Neue&family=Montserrat:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
  <!-- Bootstrap 5 CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
  <!-- Font Awesome 6 -->
  <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css" rel="stylesheet">

  <style>
    :root {
      --cat-orange-gradient: linear-gradient(90deg, #ff8800 0%, #ff5100 60%, #ff3700 100%);
      --brand-navy: #0d3b66;
      --brand-blue-accent: #002b49;
      --font-body: 'Montserrat', sans-serif;
      --font-titles: 'Bebas Neue', sans-serif;
    }

    body {
      font-family: var(--font-body);
      color: #333333;
      background-color: #ffffff;
      overflow-x: hidden;
    }

    /* Títulos Universales */
    h1, h2, h3, h4, h5, h6, .display-titles {
      font-family: var(--font-titles);
      letter-spacing: 1.5px;
      color: var(--brand-navy);
      text-transform: uppercase;
    }

    /* ========================================================
       BARRA DE CONTACTO Y HEADER SUPERIOR
       ======================================================== */
    .top-header {
      border-bottom: 1px solid #e9ecef;
      padding: 10px 0;
    }
    .social-icon-box {
      width: 28px;
      height: 28px;
      background: #e9ecef;
      color: #555;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      border-radius: 4px;
      text-decoration: none;
      font-size: 0.8rem;
      transition: all 0.2s ease;
    }
    .social-icon-box:hover {
      background: var(--brand-navy);
      color: #fff;
    }
    .phone-badge {
      font-family: var(--font-titles);
      font-size: 1.6rem;
      color: var(--brand-navy);
      letter-spacing: 1px;
    }
    .anniversary-badge {
      font-family: var(--font-body);
      font-size: 0.65rem;
      line-height: 1.1;
      font-weight: 700;
      color: #0d3b66;
      border-left: 2px solid #ccc;
      padding-left: 10px;
    }
    .anniversary-badge span {
      font-size: 1.4rem;
      font-family: var(--font-titles);
      line-height: 1;
      display: block;
    }

    /* Navegación Principal */
    .nav-bar-container {
      border-bottom: 2px solid #002b49;
    }
    .main-nav .nav-link {
      font-family: var(--font-titles);
      color: #333;
      font-size: 1.25rem;
      letter-spacing: 1px;
      padding: 10px 18px;
      transition: all 0.2s;
    }
    .main-nav .nav-link:hover,
    .main-nav .nav-link.active {
      background-color: var(--brand-navy);
      color: #fff !important;
    }

    /* Botón Hamburguesa Móvil */
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
    }

    /* Modal / Drawer para móvil */
    .modal-drawer .modal-content {
      border-radius: 16px;
      border: none;
      background: #18191c;
      color: #ffffff;
      box-shadow: 0 15px 35px rgba(0, 0, 0, 0.45);
    }
    .modal-drawer .drawer-nav-link {
      font-family: var(--font-titles);
      color: #eee;
      text-decoration: none;
      font-size: 1.4rem;
      letter-spacing: 1px;
      padding: 10px 0;
      display: flex;
      justify-content: space-between;
      align-items: center;
      border-bottom: 1px solid rgba(255, 255, 255, 0.08);
    }

    /* Breadcrumbs */
    .custom-breadcrumb {
      font-size: 0.8rem;
      font-weight: 700;
      text-transform: uppercase;
    }
    .custom-breadcrumb a {
      color: #666;
      text-decoration: none;
    }
    .custom-breadcrumb a:hover {
      color: var(--brand-navy);
    }
    .custom-breadcrumb span {
      color: var(--brand-navy);
    }

    /* ========================================================
       BOTÓN PÍLDORA UNIFICADO CON DEGRADADO Y CÍRCULO BLANCO
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
      font-size: 1.15rem;
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

    /* Mini Social Share Buttons */
    .btn-social-share {
      border: 1px solid #ced4da;
      color: var(--brand-navy);
      width: 34px;
      height: 34px;
      display: inline-flex;
      align-items: center;
      justify-content: center;
      text-decoration: none;
      transition: background 0.2s;
    }
    .btn-social-share:hover {
      background-color: var(--brand-navy);
      color: #fff;
    }

    /* ========================================================
       CAJA DE COTIZACIÓN LATERAL
       ======================================================== */
    .quote-box {
      background-color: #0b3c68;
      border-radius: 6px;
      padding: 24px;
      color: #ffffff;
      box-shadow: 0 4px 15px rgba(0,0,0,0.15);
      position: relative;
    }
    .quote-box .form-control {
      border-radius: 3px;
      margin-bottom: 12px;
      font-size: 0.85rem;
      font-family: var(--font-body);
      border: none;
      padding: 10px 14px;
    }
    .whatsapp-bubble {
      position: absolute;
      right: -15px;
      bottom: -15px;
      background-color: #00b027;
      color: #ffffff;
      font-size: 0.72rem;
      font-weight: 700;
      padding: 8px 14px;
      border-radius: 6px;
      box-shadow: 0 4px 10px rgba(0,0,0,0.2);
      text-decoration: none;
      display: flex;
      align-items: center;
      gap: 6px;
      z-index: 10;
    }

    /* ========================================================
       TABLA DE ESPECIFICACIONES TÉCNICAS
       ======================================================== */
    .spec-table-header {
      background-color: #002b49;
      color: #fff;
      font-family: var(--font-titles);
      font-size: 1.3rem;
      padding: 8px 16px;
      letter-spacing: 1px;
    }
    .spec-table {
      width: 100%;
      border-collapse: collapse;
      font-size: 0.8rem;
    }
    .spec-table th, .spec-table td {
      padding: 9px 14px;
      border: 1px solid #dee2e6;
    }
    .spec-table td:first-child {
      background-color: #fdfdfd;
      font-weight: 600;
      color: #444;
      width: 60%;
    }
    .spec-table td:last-child {
      background-color: #e9ecef;
      text-align: center;
      font-weight: 700;
      color: #222;
      width: 40%;
    }

    /* ========================================================
       PRODUCTOS RELACIONADOS: CUADRADOS (1/1) CON HOVER JS
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
    .tile-footer {
      font-family: var(--font-titles);
      letter-spacing: 1px;
      position: absolute;
      left: 0;
      right: 0;
      bottom: 0;
      background: rgba(13, 59, 102, 0.85);
      color: #fff;
      padding: 10px 15px;
      display: flex;
      justify-content: space-between;
      align-items: center;
      font-size: 1.25rem;
      z-index: 2;
    }
    .tile-overlay {
      position: absolute;
      inset: 0;
      background-color: rgba(13, 59, 102, 0.94);
      color: #fff;
      padding: 24px;
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
      border-bottom: 1px solid rgba(255,255,255,0.2);
      padding-bottom: 8px;
    }
    .tile-overlay .overlay-text {
      font-family: var(--font-body);
      font-size: 0.85rem;
      line-height: 1.45;
      color: #e2e8f0;
      margin: auto 0;
    }

    /* Footer */
    footer {
      background-color: #f8f9fa;
      border-top: 1px solid #e9ecef;
      padding: 25px 0;
      font-size: 0.75rem;
      color: #777;
    }
    footer a {
      color: var(--brand-navy);
      text-decoration: none;
      font-weight: 600;
    }
  </style>
</head>
<body>

  <!-- Top Utilities & Brand Contact -->
  <div class="top-header">
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-3">
      <!-- Logo de la Empresa -->
      <a href="#" class="d-flex align-items-center text-decoration-none">
        <div class="d-flex flex-column">
          <span style="font-family: var(--font-titles); font-size: 2.2rem; color: #0d3b66; line-height: 0.85; letter-spacing: 2px;">MALVEX</span>
          <span style="font-size: 0.58rem; letter-spacing: 2.5px; font-weight: 800; color: #666;">MALVEX DEL PERÚ S.A.</span>
        </div>
      </a>

      <!-- Redes, Teléfono y Aniversario -->
      <div class="d-flex align-items-center gap-3 gap-md-4">
        <div class="d-none d-sm-flex align-items-center gap-1">
          <a href="#" class="social-icon-box"><i class="fa-brands fa-instagram"></i></a>
          <a href="#" class="social-icon-box"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" class="social-icon-box"><i class="fa-brands fa-linkedin-in"></i></a>
          <a href="#" class="social-icon-box"><i class="fa-brands fa-youtube"></i></a>
          <a href="#" class="social-icon-box"><i class="fa-brands fa-tiktok"></i></a>
        </div>

        <div class="d-flex align-items-center gap-2">
          <i class="fa-solid fa-phone text-warning"></i>
          <span class="phone-badge">965 394 698</span>
        </div>

        <div class="anniversary-badge d-none d-md-block">
          <span>60</span>
          AÑOS<br>1966 - 2026
        </div>

        <!-- Botón Hamburguesa Móvil -->
        <button class="btn-drawer-toggle d-lg-none ms-2" type="button" data-bs-toggle="modal" data-bs-target="#mobileMenuDrawer" aria-label="Abrir Menú">
          <i class="fa-solid fa-bars fs-5"></i>
        </button>
      </div>
    </div>
  </div>

  <!-- Navegación de Escritorio -->
  <nav class="nav-bar-container d-none d-lg-block">
    <div class="container">
      <ul class="nav main-nav justify-content-between p-0">
        <li class="nav-item"><a class="nav-link" href="#">Inicio</a></li>
        <li class="nav-item"><a class="nav-link" href="#">La Empresa</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Marcas</a></li>
        <li class="nav-item"><a class="nav-link active" href="#">Productos</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Post-Venta | Alquiler</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Noticias</a></li>
        <li class="nav-item"><a class="nav-link" href="#">Contáctanos</a></li>
      </ul>
    </div>
  </nav>

  <!-- Modal Drawer Centrado Responsivo (Mobile) -->
  <div class="modal fade modal-drawer" id="mobileMenuDrawer" tabindex="-1" aria-labelledby="mobileMenuLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
      <div class="modal-content">
        <div class="modal-header">
          <span style="font-family: var(--font-titles); font-size: 1.8rem; color: #ffcd00; letter-spacing: 2px;">MALVEX</span>
          <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Cerrar"></button>
        </div>
        <div class="modal-body">
          <nav class="d-flex flex-column">
            <a href="#" class="drawer-nav-link">Inicio <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">La Empresa <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Marcas <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link text-warning">Productos <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Post-Venta | Alquiler <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Noticias <i class="fa-solid fa-chevron-right fa-xs"></i></a>
            <a href="#" class="drawer-nav-link">Contáctanos <i class="fa-solid fa-chevron-right fa-xs"></i></a>
          </nav>
        </div>
      </div>
    </div>
  </div>

  <!-- Contenido Principal -->
  <main class="container py-4">
    <!-- Breadcrumb & Back -->
    <div class="custom-breadcrumb mb-3 d-flex align-items-center gap-2">
      <a href="#"><i class="fa-solid fa-chevron-left"></i></a>
      <a href="#">PRODUCTOS</a> / <a href="#">RODILLOS COMPACTADORES</a> / <span>RD18-100</span>
    </div>

    <!-- Título de Categoría -->
    <h2 class="mb-4" style="font-size: 2.2rem; border-bottom: 2px solid #e9ecef; padding-bottom: 8px;">RODILLOS COMPACTADORES</h2>

    <!-- Fila Principal: Foto, Ficha y Formulario Lateral -->
    <div class="row g-4 mb-5">
      <!-- Imagen Principal del Producto -->
      <div class="col-lg-4 col-md-6">
        <div class="border p-2 bg-light shadow-sm rounded">
          <img src="https://images.unsplash.com/photo-1579829366248-204fe8413f31?auto=format&fit=crop&w=700&q=80" 
               alt="Rodillo compactador RD18-100" 
               class="img-fluid rounded w-100" 
               style="height: 310px; object-fit: cover;">
        </div>
        <!-- Compartir en redes -->
        <div class="d-flex gap-2 mt-3">
          <a href="#" class="btn-social-share"><i class="fa-brands fa-facebook-f"></i></a>
          <a href="#" class="btn-social-share"><i class="fa-brands fa-twitter"></i></a>
        </div>
      </div>

      <!-- Descripción y Marca -->
      <div class="col-lg-4 col-md-6">
        <h3 class="mb-1" style="font-size: 2rem;">RD18-100</h3>
        
        <!-- Logo Wacker Neuson -->
        <div class="d-flex align-items-center gap-2 my-2 pb-2 border-bottom">
          <div class="rounded-circle bg-danger text-white fw-bold d-flex align-items-center justify-content-center" style="width: 24px; height: 24px; font-size: 0.75rem;">W</div>
          <span style="font-weight: 800; letter-spacing: 0.5px; font-size: 0.95rem; color: #444;">WACKER NEUSON</span>
        </div>

        <h6 class="fw-bold mt-3 mb-2" style="font-family: var(--font-body); font-size: 0.85rem;">Descripción:</h6>
        <p class="text-secondary" style="font-size: 0.82rem; line-height: 1.6;">
          Los modelos articulados RD18 suministran un rendimiento de compactación de primera categoría gracias al gran diámetro de los tambores en combinación con un centro de gravedad bajo. El usuario se beneficia de un mayor confort en la conducción gracias a la unión articulada en tres puntos y al manejo intuitivo. Una de las particularidades es el punto de izaje unilateral de los tambores, que permite compactar hasta el borde o hasta la pared.
        </p>
      </div>

      <!-- Formulario Lateral de Cotización -->
      <div class="col-lg-4">
        <div class="quote-box">
          <h4 class="text-white text-center mb-3" style="font-size: 1.8rem; letter-spacing: 1px;">COTIZAR</h4>
          <form>
            <input type="text" class="form-control" placeholder="Nombre:">
            <input type="text" class="form-control" placeholder="Empresa:">
            <input type="text" class="form-control" placeholder="RUC:">
            <input type="text" class="form-control" placeholder="Teléfono:">
            <input type="email" class="form-control" placeholder="Correo Electrónico:">
            
            <div class="mt-3 text-center">
              <button type="button" class="btn-cat-pill w-100">
                <span class="pill-text">ENVIAR COTIZACIÓN</span>
                <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
              </button>
            </div>
          </form>

          <!-- Burbuja Flotante de WhatsApp -->
          <a href="#" class="whatsapp-bubble">
            <i class="fa-brands fa-whatsapp fs-5"></i>
            <span>¡Hola!<br>Estoy aquí para ayudarte</span>
          </a>
        </div>
      </div>
    </div>

    <!-- Sección de Modelos y Tabla de Especificaciones Técnicas -->
    <div class="row mb-5">
      <div class="col-lg-5 col-md-7">
        <div class="d-flex align-items-center gap-2 mb-3">
          <h4 class="m-0" style="font-size: 1.5rem;">MODELOS</h4>
          <div class="rounded-circle bg-danger text-white fw-bold d-flex align-items-center justify-content-center" style="width: 22px; height: 22px; font-size: 0.7rem;">W</div>
          <span style="font-weight: 800; font-size: 0.9rem; color: #444;">WACKER NEUSON</span>
        </div>

        <div class="spec-table-header">RD18-100</div>
        <table class="spec-table">
          <tbody>
            <tr>
              <td>Tipos de rodillos</td>
              <td>Rodillo tándem</td>
            </tr>
            <tr>
              <td>Peso de servicio CECE (kg)</td>
              <td>1.670</td>
            </tr>
            <tr>
              <td>Peso de servicio max. (kg)</td>
              <td>1.950</td>
            </tr>
            <tr>
              <td>Anchura máxima operativa (mm)</td>
              <td>1.056</td>
            </tr>
            <tr>
              <td>Saliente lateral (mm)</td>
              <td>-</td>
            </tr>
            <tr>
              <td>Fuerza centrífuga I / II Kn</td>
              <td>25 / 16</td>
            </tr>
            <tr>
              <td>Motor</td>
              <td>Kubota D1005</td>
            </tr>
            <tr>
              <td>Potencia del motor según ISO (kW/CV)</td>
              <td>14,8 / 20,1</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>

    <!-- Sección Productos Relacionados con Cuadrados Uniformes (1 / 1) -->
    <div class="mt-4 pt-4 border-top">
      <h3 class="text-center mb-4" style="font-size: 2rem;">PRODUCTOS RELACIONADOS</h3>
      <div class="row justify-content-center g-3">
        <!-- Relacionado 1 -->
        <div class="col-6 col-md-3">
          <div class="tile-card"
               data-title="RD45-140" 
               data-text="Rodillo tándem articulado con tambor oscilante para compactación asfáltica eficiente y de alta exigencia.">
            <img src="https://images.unsplash.com/photo-1581094288338-2314dddb7ece?auto=format&fit=crop&w=600&q=80" alt="RD45-140">
            <div class="tile-footer"><span>RD45-140</span> <i class="fa-solid fa-plus"></i></div>
            <div class="tile-overlay">
              <div class="overlay-title"><span>RD45-140</span> <i class="fa-solid fa-plus"></i></div>
              <p class="overlay-text"></p>
              <a href="#" class="btn-cat-pill w-100">
                <span class="pill-text">VER DETALLE</span>
                <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
              </a>
            </div>
          </div>
        </div>

        <!-- Relacionado 2 -->
        <div class="col-6 col-md-3">
          <div class="tile-card"
               data-title="RD27-120" 
               data-text="Excelente visibilidad perimetral y compactación homogénea tanto para subbases de suelo como asfalto.">
            <img src="https://images.unsplash.com/photo-1504307651254-35680f356dfd?auto=format&fit=crop&w=600&q=80" alt="RD27-120">
            <div class="tile-footer"><span>RD27-120</span> <i class="fa-solid fa-plus"></i></div>
            <div class="tile-overlay">
              <div class="overlay-title"><span>RD27-120</span> <i class="fa-solid fa-plus"></i></div>
              <p class="overlay-text"></p>
              <a href="#" class="btn-cat-pill w-100">
                <span class="pill-text">VER DETALLE</span>
                <span class="pill-circle"><i class="fa-solid fa-arrow-right fa-xs"></i></span>
              </a>
            </div>
          </div>
        </div>
      </div>
    </div>
  </main>

  <!-- Footer -->
  <footer>
    <div class="container d-flex flex-wrap justify-content-between align-items-center gap-2">
      <div>MALVEX DEL PERÚ S.A. - TODOS LOS DERECHOS RESERVADOS 2026</div>
      <div><a href="#">Políticas de privacidad</a></div>
      <div class="text-muted">POWERED BY B2B HTML + CSS</div>
    </div>
  </footer>

  <!-- Bootstrap 5 Bundle JS -->
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Efecto Hover Dinámico con JS para Relacionados -->
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
