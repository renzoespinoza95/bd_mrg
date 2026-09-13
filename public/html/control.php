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

    $mensaje_ws = urlencode("Estimados MRG, me comunico a través de su página web oficial para solicitar mayor información técnica y cotización sobre sus servicios especializados.");
    $url_whatsapp = 'https://wa.me/' . $celular_limpio . '?text=' . $mensaje_ws;

    // 🔥 SLIDERS
    $sliders = DB::query("
        SELECT slider_id, img, orden, descripcion, titulo_superior
        FROM reg_slider
        WHERE neg_id = %i AND is_visible = 1
        ORDER BY orden ASC
    ", $pag_web_neg_id);

    // 🔥 CATEGORÍAS CON ORDEN = 1 (Con texto01)
    $categorias_raw = DB::query("
        SELECT cat_pag_web_id, titulo, url_img, texto01
        FROM reg_cat_pag_web
        WHERE orden = 1 AND is_visible = 1 AND neg_id = %i
        ORDER BY cat_pag_web_id ASC
    ", $pag_web_neg_id);

    $categorias = [];
    foreach ($categorias_raw as $c) {
        $subcats_raw = DB::query("
            SELECT subcat_pag_web_id, titulo, descripcion
            FROM reg_subcat_pag_web
            WHERE cat_pag_web_id = %i AND is_visible = 1
            ORDER BY orden ASC, subcat_pag_web_id ASC
        ", $c['cat_pag_web_id']);

        $subcategorias = [];
        foreach ($subcats_raw as $s) {
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
            'descripcion' => $c['texto01'] ?: 'Línea especializada de ingeniería y servicios.',
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

    // Directorio renombrado a comp_inicio
    $partials = [
        'head'       => file_get_contents(VARPATH . '/public/html/template/comp_inicio/head.html'),
        'header'     => file_get_contents(VARPATH . '/public/html/template/comp_inicio/header.html'),
        'slider'     => file_get_contents(VARPATH . '/public/html/template/comp_inicio/slider.html'),
        'products'   => file_get_contents(VARPATH . '/public/html/template/comp_inicio/products.html'),
        'modal_cat'  => file_get_contents(VARPATH . '/public/html/template/comp_inicio/modal_cat.html'),
        'canallinks' => file_get_contents(VARPATH . '/public/html/template/comp_inicio/canallinks.html'),
        'strip'      => file_get_contents(VARPATH . '/public/html/template/comp_inicio/strip.html'),
        'footer'     => file_get_contents(VARPATH . '/public/html/template/comp_inicio/footer.html'),
        'scripts'    => file_get_contents(VARPATH . '/public/html/template/comp_inicio/scripts.html'),
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

    $partes = explode('-', $slug);
    $pag_web_id = intval($partes[0]);

    if($pag_web_id <= 0){
        echo "URL inválida";
        return;
    }

    $meta_description = vari('META_DESCRIPTION');
    $meta_keywords = vari('META_KEYWORDS');
    $titulo_pag_web = vari('TITULO_PAG_WEB');

    $celular = vari('CELULAR');
    $celular_limpio = preg_replace('/[^0-9]/', '', $celular);
    if (strlen($celular_limpio) === 9) {
        $celular_limpio = '51' . $celular_limpio;
    }
    $mensaje_ws = urlencode("Estimados MRG, me comunico a través de su página web oficial para solicitar mayor información técnica y cotización sobre sus servicios especializados.");
    $url_whatsapp = 'https://wa.me/' . $celular_limpio . '?text=' . $mensaje_ws;

    // NAVBAR
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

    // ITEM Y CATEGORÍA RELACIONADA
    $item = DB::queryFirstRow("
        SELECT 
            i.item_pag_web_id,
            i.titulo, 
            i.contenido, 
            i.subtitulo_detalle, 
            i.html01, 
            i.html02,
            c.cat_pag_web_id,
            c.titulo AS cat_titulo,
            c.texto01 AS cat_texto01
        FROM reg_item_pag_web i
        INNER JOIN reg_subcat_pag_web s ON s.subcat_pag_web_id = i.subcat_pag_web_id
        INNER JOIN reg_cat_pag_web c ON c.cat_pag_web_id = s.cat_pag_web_id
        WHERE i.item_pag_web_id = %i
    ", $pag_web_id);

    if(!$item){
        echo "Item no encontrado";
        return;
    }

    // Subcategorías de la categoría padre
    $subcats_categoria = [];
    if (!empty($item['cat_pag_web_id'])) {
        $subcats_raw = DB::query("
            SELECT subcat_pag_web_id, titulo, descripcion
            FROM reg_subcat_pag_web
            WHERE cat_pag_web_id = %i AND is_visible = 1
            ORDER BY orden ASC, subcat_pag_web_id ASC
        ", $item['cat_pag_web_id']);

        foreach ($subcats_raw as $s) {
            $items_raw = DB::query("
                SELECT i.item_pag_web_id, i.titulo, i.url_amigable,
                       (SELECT url_img FROM reg_pag_item_img img WHERE img.item_pag_web_id = i.item_pag_web_id ORDER BY img.orden ASC LIMIT 1) AS img
                FROM reg_item_pag_web i
                WHERE i.subcat_pag_web_id = %i
                ORDER BY i.orden ASC, i.item_pag_web_id ASC
            ", $s['subcat_pag_web_id']);

            $productos = array_map(function($it) use ($apphost) {
                return [
                    'item_pag_web_id' => $it['item_pag_web_id'],
                    'titulo' => $it['titulo'],
                    'img' => $it['img'] ?: 'assets/logo-mrg.jpg',
                    'url' => $apphost . '/item/' . $it['item_pag_web_id'] . '-' . $it['url_amigable']
                ];
            }, $items_raw);

            $subcats_categoria[] = [
                'subcat_id' => $s['subcat_pag_web_id'],
                'titulo' => $s['titulo'],
                'descripcion' => $s['descripcion'] ?: '',
                'productos' => $productos,
                'total_productos' => count($productos)
            ];
        }
    }

    $data['cat_id'] = $item['cat_pag_web_id'];
    $data['categoria'] = $item['cat_titulo'];
    $data['cat_subcategorias_base64'] = base64_encode(json_encode($subcats_categoria, JSON_UNESCAPED_UNICODE));

    // LOGOTIPOS
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

    // IMAGENES
    $imagenes = DB::query("
        SELECT url_img, orden
        FROM reg_pag_item_img
        WHERE item_pag_web_id=%i
        ORDER BY orden ASC
    ", $pag_web_id);

    $data['logo'] = 'assets/main-logo.png';
    $data['title'] = $item['titulo'];
    $data['favicon'] = $varhost . '/public/ico/favicon.png';
    $data['base'] = $base;
    $data['version'] = $version;
    $data['visitas'] = $mis_visitas;    
    $data['url_inicio'] = $apphost;
    $data['fontawesome_url'] = $varhost . '/public/bootstrap/font-awesome/css/font-awesome.css';

    $data['titulo'] = $item['titulo'];
    $data['contenido'] = $item['contenido'];
    $data['html01'] = $item['html01'] ?? '';
    $data['html02'] = $item['html02'] ?? '';

    $data['imagen_principal'] = isset($imagenes[0]) 
        ? $imagenes[0]['url_img'] 
        : 'https://picsum.photos/1200/500';

    $data['imagenes'] = array_map(function($img){
        return [
            'url_img' => $img['url_img']
        ];
    }, $imagenes);

    $data['cta_titulo'] = '¿Te interesa este servicio?';
    $data['cta_texto'] = 'Contáctanos para más información';

    $data['titulo_pag_web'] = $titulo_pag_web;
    $data['meta_description'] = $meta_description;
    $data['meta_keywords'] = $meta_keywords;

    $data['cliente'] = "MRG";
    $data['anio'] = 2026;

    // Componentes parciales de comp_detalle
    $partials = [
        'head'               => file_get_contents(VARPATH . '/public/html/template/comp_detalle/head.html'),
        'header'             => file_get_contents(VARPATH . '/public/html/template/comp_detalle/header.html'),
        'breadcrumb'         => file_get_contents(VARPATH . '/public/html/template/comp_detalle/breadcrumb.html'),
        'imagen'             => file_get_contents(VARPATH . '/public/html/template/comp_detalle/imagen.html'),
        'descripcion'        => file_get_contents(VARPATH . '/public/html/template/comp_detalle/descripcion.html'),
        'cotizar'            => file_get_contents(VARPATH . '/public/html/template/comp_detalle/cotizar.html'),
        'especificaciones'   => file_get_contents(VARPATH . '/public/html/template/comp_detalle/especificaciones.html'),
        'relacionados'       => file_get_contents(VARPATH . '/public/html/template/comp_detalle/relacionados.html'),
        'modal_cat'          => file_get_contents(VARPATH . '/public/html/template/comp_detalle/modal_cat.html'),
        'modal_preview_img'  => file_get_contents(VARPATH . '/public/html/template/comp_detalle/modal_preview_img.html'),
        'footer'             => file_get_contents(VARPATH . '/public/html/template/comp_detalle/footer.html'),
        'scripts'            => file_get_contents(VARPATH . '/public/html/template/comp_detalle/scripts.html'),
    ];

    echo (new Mustache)->render(
        file_get_contents(VARPATH . '/public/html/template/detalle.html'),
        $data,
        $partials
    );
});