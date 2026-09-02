<?php
Flight::route('GET /', function () {

    include DEFINITION;

    visita();
    $mis_visitas = vari("visitas");

    $meta_description = vari('META_DESCRIPTION');

    $meta_keywords = vari('META_KEYWORDS');

    $titulo_pag_web = vari('TITULO_PAG_WEB');


    // 🔥 BUSCAR ITEM VIDEO_INICIO
    $itemVideo = DB::queryFirstRow("
        SELECT item_pag_web_id
        FROM reg_item_pag_web
        WHERE clave_txt = 'VIDEO_INICIO'
        LIMIT 1
    ");

    $video_inicio = null;

    if($itemVideo){

        $video = DB::queryFirstRow("
            SELECT codigo_web
            FROM reg_pag_item_vid
            WHERE item_pag_web_id = %i
            ORDER BY orden ASC
            LIMIT 1
        ", $itemVideo['item_pag_web_id']);

        if($video){
            $video_inicio = $video['codigo_web'];
        }
    }

    // 🔥 SLIDER
    $sliders = DB::query("
        SELECT
            slider_id,
            img,
            orden,
            descripcion,
            titulo_superior
        FROM reg_slider
        WHERE neg_id = %i
          AND is_visible = 1
        ORDER BY orden ASC
    ", $pag_web_neg_id);

    $about = DB::queryFirstRow("
        SELECT
            titulo,
            contenido
        FROM reg_item_pag_web
        WHERE clave_txt = 'TXT_NOSOTROS'
        LIMIT 1
    ");    

    // 🔥 PRODUCTOS
    $productos = DB::query("
        SELECT
            i.item_pag_web_id,
            i.titulo,
            i.url_amigable,
            i.precio,
            (
                SELECT url_img 
                FROM reg_pag_item_img img
                WHERE img.item_pag_web_id = i.item_pag_web_id
                ORDER BY img.orden ASC
                LIMIT 1
            ) AS img
        FROM reg_item_pag_web i
        INNER JOIN reg_subcat_pag_web s 
            ON s.subcat_pag_web_id = i.subcat_pag_web_id
        INNER JOIN reg_cat_pag_web c 
            ON c.cat_pag_web_id = s.cat_pag_web_id
        WHERE c.neg_id = %i
          AND s.clave_txt = %s
        ORDER BY i.orden ASC, i.item_pag_web_id ASC
        LIMIT 10
    ", $pag_web_neg_id, 'TXT_INGENIERIA');

    $rows = DB::query("
        SELECT 
            i.item_pag_web_id, 
            i.titulo, 
            i.subtitulo_detalle,
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

    $data = [
        'logo' => 'assets/main-logo.png',
        'title' => 'VREMHES SAC',
        'favicon' => $varhost . '/public/ico/favicon.png',
        'base' => $base,
        'version' => $version,
        'meta_description' => $meta_description,
        'meta_keywords' => $meta_keywords,
        'titulo_pag_web' => $titulo_pag_web,
        'url_inicio' => $apphost,
        'fontawesome_url' => $varhost . '/public/bootstrap/font-awesome/css/font-awesome.css'
    ];

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

    $data['products_title'] = 'Especialidades';
    $data['products_btn']   = 'Ver todos';
    $data['products_url']   = $apphost;

    $data['products'] = array_map(function($p) use ($apphost){
        return [
            'titulo' => $p['titulo'],
            'precio' => number_format($p['precio'], 2),
            'img' => $p['img'] ?: 'https://picsum.photos/300/300',
            'url' => $apphost . '/item/' . $p['item_pag_web_id'] . '-' . $p['url_amigable']
        ];
    }, $productos);

    $data['sliders'] = array_map(function($s){

        return [
            'img' => $s['img'],

            // usa lo que viene de BD
            'titulo_superior' => $s['titulo_superior'] ?: 'BIENVENIDO A VREMHES',
            'descripcion' => $s['descripcion'] ?: ''
        ];

    }, $sliders);


    $faqs = DB::query("
    SELECT
        i.item_pag_web_id,
        i.titulo,
        i.contenido
    FROM reg_item_pag_web i
    INNER JOIN reg_subcat_pag_web s 
        ON s.subcat_pag_web_id = i.subcat_pag_web_id
    WHERE s.clave_txt = %s
    ORDER BY i.orden ASC, i.item_pag_web_id ASC
", 'TXT_FAQ');

    $data['faq_title'] = 'Preguntas Frecuentes Técnicas';

    $data['faqs'] = array_map(function($f, $i){
        return [
            'id' => $i + 1,
            'pregunta' => $f['titulo'],
            'respuesta' => $f['contenido']
        ];
    }, $faqs, array_keys($faqs));


    $data['about_tag'] = 'Nosotros';

    $data['visitas'] = $mis_visitas;

    $data['about_titulo'] = $about ? $about['titulo'] : 'Sobre nosotros';

    $data['about_contenido'] = $about ? $about['contenido'] : '';

    $item_txt_banner = DB::queryFirstRow("
        SELECT item_pag_web_id, titulo
        FROM reg_item_pag_web
        WHERE clave_txt = 'TXT_BANNER'
        LIMIT 1
    ");

    $imagenes = [];

    if ($item_txt_banner) {
        $imagenes = DB::query("
            SELECT
                url_img,
                orden
            FROM reg_pag_item_img
            WHERE item_pag_web_id = %i
            ORDER BY orden ASC
        ", $item_txt_banner['item_pag_web_id']);
    }

    $data['banners'] = array_map(function($img, $i) use ($item_txt_banner){

        return [
            'img' => $img['url_img'],
            'index' => $i + 1,
            'titulo' => $item_txt_banner['titulo'],
            'url' => '#',
            'texto_btn' => 'Ver más'
        ];

    }, $imagenes, array_keys($imagenes));


    $testimonials = DB::query("
        SELECT
            i.item_pag_web_id,
            i.titulo,
            i.contenido
        FROM reg_item_pag_web i
        INNER JOIN reg_subcat_pag_web s 
            ON s.subcat_pag_web_id = i.subcat_pag_web_id
        WHERE s.clave_txt = %s
        ORDER BY i.orden ASC, i.item_pag_web_id ASC
    ", 'TXT_TESTIMONIALS');

    $data['testimonials_title'] = 'Soluciones';

    $data['testimonials'] = array_map(function($t){
        return [
            'titulo' => $t['titulo'],
            'contenido' => $t['contenido']
        ];
    }, $testimonials);    

    $data['video_inicio'] = $video_inicio;

    $partials = [
        'head' => file_get_contents(VARPATH . '/public/html/template/components/head.html'),
        'header' => file_get_contents(VARPATH . '/public/html/template/components/header.html'),
        'slider' => file_get_contents(VARPATH . '/public/html/template/components/slider.html'),
        'about' => file_get_contents(VARPATH . '/public/html/template/components/about.html'),
        'products' => file_get_contents(VARPATH . '/public/html/template/components/products.html'),
        'testimonials' => file_get_contents(VARPATH . '/public/html/template/components/testimonials.html'),
        'video' => file_get_contents(VARPATH . '/public/html/template/components/video.html'),
        'faqs' => file_get_contents(VARPATH . '/public/html/template/components/faqs.html'),
        'banner' => file_get_contents(VARPATH . '/public/html/template/components/banner.html'),
        'whatsapp' => file_get_contents(VARPATH . '/public/html/template/components/whatsapp_float.html'),         
        'footer' => file_get_contents(VARPATH . '/public/html/template/components/footer.html'),
        'scripts' => file_get_contents(VARPATH . '/public/html/template/components/scripts.html'),
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

    // =========================
    // ITEM
    // =========================
    $item = DB::queryFirstRow("
        SELECT titulo, contenido, subtitulo_detalle
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
            'autor' => 'Cliente Vremhes'
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

    $data['cliente'] = "VREMHES";
    $data['anio'] = 2026;
    $data['categoria'] = "METAL MECANICA - MINERIA";




    // =========================
    // RENDER
    // =========================
    $partials = [
        'head' => file_get_contents(VARPATH . '/public/html/template/components/head.html'),
        'header' => file_get_contents(VARPATH . '/public/html/template/components/header.html'),
        'footer' => file_get_contents(VARPATH . '/public/html/template/components/footer.html'),
        'scripts' => file_get_contents(VARPATH . '/public/html/template/components/scripts.html'),

        'hero' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/hero.html'),
        'imagen' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/imagen.html'),
        'descripcion' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/descripcion.html'),
        'datos' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/datos.html'),
        'galeria' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/galeria.html'),
        'features' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/features.html'),
        'whatsapp' => file_get_contents(VARPATH . '/public/html/template/components/whatsapp_float.html'),
        'testimonios' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/testimonios.html'),
        'logotipos' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/logotipos.html'),
        'videos' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/videos.html'),
        'cta' => file_get_contents(VARPATH . '/public/html/template/comp_detalle/cta.html'),
    ];

    echo (new Mustache)->render(
        file_get_contents(VARPATH . '/public/html/template/detalle.html'),
        $data,
        $partials
    );
});