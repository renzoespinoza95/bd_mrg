<?php
Flight::route('GET /', function () {
    include DEFINITION;

    visita();
    $mis_visitas = vari("visitas");
    $meta_description = vari('META_DESCRIPTION');
    $meta_keywords = vari('META_KEYWORDS');
    $titulo_pag_web = vari('TITULO_PAG_WEB');
    // Obtener celular dinámico del sistema y formatear para WhatsApp
    $celular = vari('CELULAR');
    $celular_limpio = preg_replace('/[^0-9]/', '', $celular);
    if (strlen($celular_limpio) === 9) {
        $celular_limpio = '51' . $celular_limpio;
    }
    $url_whatsapp = 'https://wa.me/' . $celular_limpio;

    // 🔥 SLIDERS
    $sliders = DB::query("
        SELECT slider_id, img, orden, descripcion, titulo_superior
        FROM reg_slider
        WHERE neg_id = %i AND is_visible = 1
        ORDER BY orden ASC
    ", $pag_web_neg_id);

    // 🔥 CATEGORÍAS CON ORDEN = 1 (Sin la columna 'descripcion')
    $categorias_raw = DB::query("
        SELECT cat_pag_web_id, titulo, url_img
        FROM reg_cat_pag_web
        WHERE orden = 1 AND is_visible = 1 AND neg_id = %i
        ORDER BY cat_pag_web_id ASC
    ", $pag_web_neg_id);

    $categorias = [];
    foreach ($categorias_raw as $c) {
        // Consultar subcategorías (la tabla reg_subcat_pag_web sí posee 'descripcion')
        $subcats_raw = DB::query("
            SELECT subcat_pag_web_id, titulo, descripcion
            FROM reg_subcat_pag_web
            WHERE cat_pag_web_id = %i AND is_visible = 1
            ORDER BY orden ASC, subcat_pag_web_id ASC
        ", $c['cat_pag_web_id']);

        $subcategorias = [];
        foreach ($subcats_raw as $s) {
            // Consultar ítems/productos
            $items_raw = DB::query("
                SELECT i.item_pag_web_id, i.titulo, i.url_amigable, i.precio,
                       (SELECT url_img FROM reg_pag_item_img img WHERE img.item_pag_web_id = i.item_pag_web_id ORDER BY img.orden ASC LIMIT 1) AS img
                FROM reg_item_pag_web i
                WHERE i.subcat_pag_web_id = %i
                ORDER BY i.orden ASC, i.item_pag_web_id ASC
            ", $s['subcat_pag_web_id']);

            $productos = array_map(function($it) use ($apphost) {
                return [
                    'item_pag_web_id' => $it['item_pag_web_id'],
                    'titulo' => $it['titulo'],
                    'precio' => number_format($it['precio'], 2),
                    'img' => $it['img'] ?: 'assets/logo-mrg.jpg',
                    'url' => $apphost . '/item/' . $it['item_pag_web_id'] . '-' . $it['url_amigable']
                ];
            }, $items_raw);

            $subcategorias[] = [
                'subcat_id' => $s['subcat_pag_web_id'],
                'titulo' => $s['titulo'],
                'descripcion' => $s['descripcion'] ?: '',
                'productos' => $productos,
                'total_productos' => count($productos)
            ];
        }

        $categorias[] = [
            'cat_id' => $c['cat_pag_web_id'],
            'titulo' => $c['titulo'],
            'url_img' => $c['url_img'] ?: 'assets/logo-mrg.jpg',
            'descripcion' => 'Línea especializada de ingeniería y servicios.',
            'subcategorias_base64' => base64_encode(json_encode($subcategorias, JSON_UNESCAPED_UNICODE))
        ];
    }

    // TOPNAVBAR
    $rows = DB::query("
        SELECT i.item_pag_web_id, i.titulo, i.url_amigable
        FROM reg_item_pag_web i
        INNER JOIN reg_subcat_pag_web s ON s.subcat_pag_web_id = i.subcat_pag_web_id
        WHERE s.clave_txt = %s
        ORDER BY i.orden ASC, i.item_pag_web_id ASC
        LIMIT 6
    ", 'TXT_TOPNAVBAR');

    $left  = array_slice($rows, 0, 3);
    $right = array_slice($rows, 3, 3);

    $data = [
        'logo' => 'assets/logo-mrg.jpg',
        'title' => 'MRG ASESORAMIENTO Y REPARACIONES',
        'favicon' => $varhost . '/public/ico/favicon.png',
        'base' => $base,
        'version' => $version,
        'meta_description' => $meta_description,
        'meta_keywords' => $meta_keywords,
        'titulo_pag_web' => $titulo_pag_web,
        'url_inicio' => $apphost,
        'visitas' => $mis_visitas,
        'categorias' => $categorias,
        'sliders' => $sliders
    ];

    $data['celular'] = $celular;
    $data['url_whatsapp'] = $url_whatsapp;

    $data['nav_left'] = array_map(function($r) use ($apphost){
        return ['titulo' => $r['titulo'], 'url' => $apphost . '/item/' . $r['item_pag_web_id'] . '-' . $r['url_amigable']];
    }, $left);

    $data['nav_right'] = array_map(function($r) use ($apphost){
        return ['titulo' => $r['titulo'], 'url' => $apphost . '/item/' . $r['item_pag_web_id'] . '-' . $r['url_amigable']];
    }, $right);

    $partials = [
        'head'       => file_get_contents(VARPATH . '/public/html/template/components/head.html'),
        'header'     => file_get_contents(VARPATH . '/public/html/template/components/header.html'),
        'slider'     => file_get_contents(VARPATH . '/public/html/template/components/slider.html'),
        'products'   => file_get_contents(VARPATH . '/public/html/template/components/products.html'),
        'modal_cat'  => file_get_contents(VARPATH . '/public/html/template/components/modal_cat.html'),
        'canallinks' => file_get_contents(VARPATH . '/public/html/template/components/canallinks.html'),
        'strip'      => file_get_contents(VARPATH . '/public/html/template/components/strip.html'),
        'footer'     => file_get_contents(VARPATH . '/public/html/template/components/footer.html'),
        'scripts'    => file_get_contents(VARPATH . '/public/html/template/components/scripts.html'),
    ];

    echo (new Mustache)->render(
        file_get_contents(VARPATH . '/public/html/template/inicio.html'),
        $data,
        $partials
    );
});


Flight::route('GET /item/@slug', function ($slug) {

    include DEFINITION;

    visita();
    $mis_visitas = vari("visitas");

    // 🔥 EXTRAER ID (ANTES DEL PRIMER GUION)
    $partes = explode('-', $slug);
    $pag_web_id = intval($partes[0]);

    if($pag_web_id <= 0){
        echo "URL inválida";
        return;
    }

    $meta_description = vari('META_DESCRIPTION');
    $meta_keywords = vari('META_KEYWORDS');
    $titulo_pag_web = vari('TITULO_PAG_WEB');

    // Obtener celular dinámico del sistema y formatear para WhatsApp
    $celular = vari('CELULAR');
    $celular_limpio = preg_replace('/[^0-9]/', '', $celular);
    if (strlen($celular_limpio) === 9) {
        $celular_limpio = '51' . $celular_limpio;
    }
    $url_whatsapp = 'https://wa.me/' . $celular_limpio;

    // =========================
    // NAVBAR
    // =========================
    $rows = DB::query("
        SELECT 
            i.item_pag_web_id, 
            i.titulo,
            i.url_amigable
        FROM reg_item_pag_web i
        INNER JOIN reg_subcat_pag_web s 
            ON s.subcat_pag_web_id = i.subcat_pag_web_id
        WHERE s.clave_txt = %s
        ORDER BY i.orden ASC, i.item_pag_web_id ASC
        LIMIT 6
    ", 'TXT_TOPNAVBAR');

    $left  = array_slice($rows, 0, 3);
    $right = array_slice($rows, 3, 3);

    $data['nav_left'] = array_map(function($r) use ($apphost){
        return [
            'titulo' => $r['titulo'],
            'url' => $apphost . '/item/' . $r['item_pag_web_id'] . '-' . $r['url_amigable']
        ];
    }, $left);

    $data['nav_right'] = array_map(function($r) use ($apphost){
        return [
            'titulo' => $r['titulo'],
            'url' => $apphost . '/item/' . $r['item_pag_web_id'] . '-' . $r['url_amigable']
        ];
    }, $right);

    $data['celular'] = $celular;
    $data['url_whatsapp'] = $url_whatsapp;

    // =========================
    // ITEM
    // =========================
    $item = DB::queryFirstRow("
        SELECT titulo, contenido, subtitulo_detalle, html01, html02
        FROM reg_item_pag_web
        WHERE item_pag_web_id = %i
    ", $pag_web_id);

    if(!$item){
        echo "Item no encontrado";
        return;
    }

    // =========================
    // LOGOTIPOS
    // =========================
    $logotipos = DB::query("
        SELECT img.url_img
        FROM reg_item_pag_web i
        INNER JOIN reg_pag_item_img img 
            ON img.item_pag_web_id = i.item_pag_web_id
        WHERE i.clave_txt = %s
        ORDER BY img.orden ASC
    ", 'TXT_LOGOTIPOS');

    $data['logotipos'] = array_map(function($r){
        return [
            'url_img' => $r['url_img']
        ];
    }, $logotipos);

    $videos = DB::query("
        SELECT 
            titulo,
            codigo_web,
            url_img
        FROM reg_pag_item_vid
        WHERE item_pag_web_id = %i
        ORDER BY orden ASC
    ", $pag_web_id);

    $data['videos'] = array_map(function($v){
        return [
            'titulo' => $v['titulo'],
            'codigo_web' => $v['codigo_web'],
            'url_img' => $v['url_img']
        ];
    }, $videos);    

    // =========================
    // IMAGENES
    // =========================
    $imagenes = DB::query("
        SELECT url_img, orden
        FROM reg_pag_item_img
        WHERE item_pag_web_id = %i
        ORDER BY orden ASC
    ", $pag_web_id);

    // =========================
    // DATA BASE
    // =========================
    $data['logo'] = 'assets/main-logo.png';
    $data['title'] = $item['titulo'];
    $data['favicon'] = $varhost . '/public/ico/favicon.png';
    $data['base'] = $base;
    $data['version'] = $version;
    $data['visitas'] = $mis_visitas;    
    $data['url_inicio'] = $apphost;
    $data['fontawesome_url'] = $varhost . '/public/bootstrap/font-awesome/css/font-awesome.css';

    // =========================
    // ITEM DATA
    // =========================
    $data['titulo'] = $item['titulo'];
    $data['contenido'] = $item['contenido'];
    $data['html01'] = $item['html01'] ?? '';
    $data['html02'] = $item['html02'] ?? '';

    $texto = trim(strip_tags($item['subtitulo_detalle'] ?? ''));

    if($texto === ''){
        $data['contenido_resumen'] = '';
    }else{
        $palabras = preg_split('/\s+/', $texto);
        $data['contenido_resumen'] = implode(' ', array_slice($palabras, 0, 40));
    }

    $data['imagen_principal'] = isset($imagenes[0]) 
        ? $imagenes[0]['url_img'] 
        : 'https://picsum.photos/1200/500';

    $data['imagenes'] = array_map(function($img){
        return [
            'url_img' => $img['url_img']
        ];
    }, $imagenes);

    // 🔥 TESTIMONIOS (puedes conectarlo luego a BD)
    $data['testimonios'] = [
        [
            'texto' => 'Excelente servicio técnico especializado',
            'autor' => 'Cliente MRG'
        ],
        [
            'texto' => 'Alta confiabilidad en reparación minera',
            'autor' => 'Operaciones'
        ]
    ];

    // 🔥 CTA
    $data['cta_titulo'] = '¿Te interesa este servicio?';
    $data['cta_texto'] = 'Contáctanos para más información';

    $data['titulo_pag_web'] = $titulo_pag_web;
    $data['meta_description'] = $meta_description;
    $data['meta_keywords'] = $meta_keywords;

    $data['cliente'] = "MRG";
    $data['anio'] = 2026;
    $data['categoria'] = "METAL MECANICA - MINERIA";

    // =========================
    // RENDER
    // =========================
    $partials = [
        'head'             => file_get_contents(VARPATH . '/public/html/template/comp_detalle/head.html'),
        'header'           => file_get_contents(VARPATH . '/public/html/template/comp_detalle/header.html'),
        'breadcrumb'       => file_get_contents(VARPATH . '/public/html/template/comp_detalle/breadcrumb.html'),
        'imagen'           => file_get_contents(VARPATH . '/public/html/template/comp_detalle/imagen.html'),
        'descripcion'      => file_get_contents(VARPATH . '/public/html/template/comp_detalle/descripcion.html'),
        'cotizar'          => file_get_contents(VARPATH . '/public/html/template/comp_detalle/cotizar.html'),
        'especificaciones' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/especificaciones.html'),
        'relacionados'     => file_get_contents(VARPATH . '/public/html/template/comp_detalle/relacionados.html'),
        'footer'           => file_get_contents(VARPATH . '/public/html/template/comp_detalle/footer.html'),
        'scripts'          => file_get_contents(VARPATH . '/public/html/template/comp_detalle/scripts.html'),
    ];

    echo (new Mustache)->render(
        file_get_contents(VARPATH . '/public/html/template/detalle.html'),
        $data,
        $partials
    );
});