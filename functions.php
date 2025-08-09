<?php
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Evita acceso directo al archivo
}

if ( ! function_exists( 'eiduo_enqueue_assets' ) ) :
    function eiduo_enqueue_assets() {
        // Evita que se cargue en el área de administración
        if ( is_admin() ) return;

        $theme_dir = get_template_directory();
        $theme_uri = get_template_directory_uri();

        // === ESTILOS ===
        $css_path = $theme_dir . '/assets/css/';
        $css_uri  = $theme_uri . '/assets/css/';

        $styles = [
            'normalize'    => 'normalize.min.css',
            'main-grid'    => 'main-grid.min.css',
            'slick'        => 'slick.min.css',
            'slick-theme'  => 'slick-theme.min.css',
            'main'         => 'main.css',
        ];

        foreach ( $styles as $handle => $file ) {
            $version = file_exists( $css_path . $file ) ? filemtime( $css_path . $file ) : false;
            wp_enqueue_style( $handle, $css_uri . $file, [], $version, 'all' );
        }

        // Estilo base del tema
        wp_enqueue_style( 'eiduo-style', $theme_uri . '/style.css', [], filemtime( $theme_dir . '/style.css' ), 'all' );

        // === SCRIPTS ===
        $js_path = $theme_dir . '/assets/js/';
        $js_uri  = $theme_uri . '/assets/js/';

        $scripts = [
            'slick-js'        => ['file' => 'slick.min.js',         'deps' => ['jquery'],    'in_footer' => true],
            'custom-scripts'  => ['file' => 'scripts.js',           'deps' => ['jquery', 'slick-js'], 'in_footer' => true],
        ];

        foreach ( $scripts as $handle => $data ) {
            $file    = $data['file'];
            $deps    = $data['deps'];
            $in_footer = $data['in_footer'];
            $version = file_exists( $js_path . $file ) ? filemtime( $js_path . $file ) : false;

            wp_enqueue_script( $handle, $js_uri . $file, $deps, $version, $in_footer );
        }
    }
endif;

add_action( 'wp_enqueue_scripts', 'eiduo_enqueue_assets', 10 );

// Funciones del tema
function eiduo_setup() {
    // Ready for i18n
    load_theme_textdomain( "eiduo", get_template_directory() . "/languages");

    // Switch default core markup for search form, comment form, and comments to output valid HTML5.
    add_theme_support( 'html5', array( 'search-form', 'comment-form', 'comment-list', 'gallery', 'caption' ) );

    // Use thumbnails
    add_theme_support( 'post-thumbnails' );

    // Add default posts and comments RSS feed links to head.
    add_theme_support( 'automatic-feed-links' );

    // Let WordPress manage the document title
    add_theme_support( 'title-tag' );

    // Enable support for custom logo.
    add_theme_support( 'custom-logo', array(
        'height'      => 100,
        'width'       => 400,
        'flex-height' => true,
        'flex-width' => true,
    ));

    // Register Navigation Menus
    register_nav_menus(array(
    'menu_escritorio' => __('Menu Escritorio', 'eiduo'),
    'menu_movil'      => __('Menú Móvil', 'eiduo'),
    'menu_footer'     => __('Menú Footer', 'eiduo'),
    'menu_legal'      => __('Menú Legal', 'eiduo')
    ));

}
add_action( 'after_setup_theme', 'eiduo_setup' );

function skip_logo_crop( $sizes, $metadata ) {
    $custom_logo_id = get_theme_mod('custom_logo');
    if ($metadata['file'] === wp_get_attachment_metadata($custom_logo_id)['file']) {
        $sizes = array();
    }
    return $sizes;
}
add_filter('intermediate_image_sizes_advanced', 'skip_logo_crop', 10, 2);

function theme_customize_register($wp_customize) {
    $wp_customize->add_setting('custom_logo_size', array(
        'default' => '100',
        'transport' => 'refresh',
    ));

    $wp_customize->add_control(new WP_Customize_Control($wp_customize, 'custom_logo_size', array(
        'label' => __('Tamaño del logotipo', 'theme_text_domain'),
        'section' => 'title_tagline',
        'settings' => 'custom_logo_size',
        'type' => 'number',
    )));
}
add_action('customize_register', 'theme_customize_register');

function theme_customize_css() {
    echo '<style type="text/css">';
    echo '.custom-logo { width: ' . get_theme_mod('custom_logo_size') . 'px; }';
    echo '</style>';
}
add_action('wp_head', 'theme_customize_css');

// Registrar las áreas de widgets del pie de página
function eiduo_widgets_init() {
    for ($i = 1; $i <= 5; $i++) {
        register_sidebar( array(
            'name'          => sprintf( __( 'Pie de página %s', 'eiduo' ), $i ),
            'id'            => 'footer-' . $i,
            'description'   => __( 'Añade widgets aquí.', 'eiduo' ),
            'before_widget' => '<section id="%1$s" class="widget %2$s">',
            'after_widget'  => '</section>',
            'before_title'  => '<h4 class="widget-title">',
            'after_title'   => '</h4>',
        ) );
    }
    register_sidebar(
        array(
            'name'          => __( 'Formulario Newsletter' ),
            'id'            => 'form_newsletter'
        )
    );
}
add_action( 'widgets_init', 'eiduo_widgets_init' );

// HABILITAR SUBIDA SVG/WEBP
function cc_mime_types($mimes) {
    $mimes['svg'] = 'image/svg+xml';
    $mimes['webp'] = 'image/webp';
    return $mimes;
}
add_filter('upload_mimes', 'cc_mime_types');

// Agregar soporte para el formato .webP en WordPress
function add_webp_support($mime_types) {
    $mime_types['svg'] = 'image/svg+xml';
    $mime_types['webp'] = 'image/webp';
    return $mime_types;
}
add_filter('upload_mimes', 'add_webp_support');

// Permitir subir archivos .webP en la biblioteca de medios
function enable_webp_upload($existing_mimes) {
    $existing_mimes['svg'] = 'mime/type';
    $existing_mimes['webp'] = 'mime/type';
    return $existing_mimes;
}
add_filter('mime_types', 'enable_webp_upload');

// Habilitar la visualización de imágenes .webP en la biblioteca de medios
function display_webp_thumbnails($result, $path) {
    if ($result === false && preg_match('/\.webp$/i', $path)) {
        return true;
    }
    return $result;
}
add_filter('file_is_displayable_image', 'display_webp_thumbnails', 10, 2);

// Añadir el campo personalizado en el personalizador de WordPress
function eiduo_customize_register( $wp_customize ) {
    // Añadir la sección del pie de página
    $wp_customize->add_section( 'footer_section' , array(
        'title'      => __( 'Pie de página', 'eiduo' ),
        'priority'   => 30,
    ) );
    // Añadir la opción para el ancho del pie de página
    $wp_customize->add_setting( 'footer_width' , array(
        'default'     => 'content-width',
        'transport'   => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_width', array(
        'label'        => __( 'Ancho del pie de página', 'eiduo' ),
        'section'    => 'footer_section',
        'settings'   => 'footer_width',
        'type'       => 'select',
        'choices'    => array(
            'content-width' => 'Ancho de contenido',
            'full-width' => 'Ancho completo',
        ),
    ) ) );

    // Añadir la opción para el número de columnas del pie de página
    $wp_customize->add_setting( 'footer_layout' , array(
        'default'     => '3',
        'transport'   => 'refresh',
    ) );

    $wp_customize->add_control( new WP_Customize_Control( $wp_customize, 'footer_layout', array(
        'label'        => __( 'Número de columnas del pie de página', 'eiduo' ),
        'section'    => 'footer_section',
        'settings'   => 'footer_layout',
        'type'       => 'select',
        'choices'    => array(
            '3' => '3 columnas',
            '4' => '4 columnas',
            '5' => '5 columnas',
        ),
    ) ) );

}
add_action( 'customize_register', 'eiduo_customize_register' );

//Marcar la longitud del extracto
function eiduo_excerpt($length) {
    return 25;
}
add_filter( 'excerpt_length', 'eiduo_excerpt' );

//Eliminar [..] de los excerpt
function eiduo_excerpt_more( $more ) {  
  return ''; 
}
add_filter('excerpt_more', 'eiduo_excerpt_more'); 

//Activar/Desactivar funciones del tema
function eiduo_activation_actions() {
    update_option( "users_can_register", 1 );

    add_option( 'eiduo_facebook_url', '#', '', 'yes' );
    add_option( 'eiduo_twitter_url', '#', '', 'yes' );
    add_option( 'eiduo_googleplus_url', '#', '', 'yes' );
}
add_action( 'after_switch_theme', 'eiduo_activation_actions', 10 );

function eiduo_desactivation_actions() {
    update_option( "users_can_register", 0 );

    delete_option( 'eiduo_facebook_url' );
    delete_option( 'eiduo_twitter_url' );
    delete_option( 'eiduo_instagram_url' );
    delete_option( 'eiduo_linkedin_url' );
}
add_action( 'switch_theme', 'eiduo_desactivation_actions', 10 );

// Añadir shortcode de Bloque Proyectos
function load_template_part_content_projects() {
    ob_start();
    get_template_part('template-parts/content/content', 'projects');
    return ob_get_clean();
}
add_shortcode('content_projects', 'load_template_part_content_projects');

// Añadir bloque para compartir en redes sociales
function eiduo_social_share() {
    if(is_singular( array('post', 'proyectos') )) {
      echo '<div class="social-share">
  
          <span>Compartir___ </span>
  
          <span class="link">
            <a class="text-dark" href="http://www.facebook.com/sharer.php?u='.get_permalink().'" target="_blank">
              <strong>Facebook</strong>
            </a>
          </span>
  
          <span class="link">
            <a class="text-dark" href="https://twitter.com/share?url='.get_permalink().'&text='.get_the_title().'&hashtags=creativos&via=agenciaeiduo" target="_blank">
              <strong>Twitter</strong>
            </a>
          </span>
  
          <span class="link">
            <a class="text-dark" href="http://www.linkedin.com/shareArticle?mini=true&amp;url='.get_permalink().'" target="_blank">
              <strong>Linkedin</strong>
            </a>
          </span>
  
      </div>';
    }
  }
  add_action( 'social-share', 'eiduo_social_share' );
  //add_shortcode('social-share','eiduo_social_share');

// Añade un formulario sobre la utilidad del articulo
  add_filter('the_content', 'add_feedback_form_to_posts');
    function add_feedback_form_to_posts($content) {
        if (is_single()) {
            $form_shortcode = '[gravityform id="7" title="false" description="false"]';
            return $content . do_shortcode($form_shortcode);
        }
        return $content;
    }

// Registra los Custom Post Types
require get_template_directory() . '/inc/custom-post-type.php';
// Registra campos personalizados
require get_template_directory() . '/inc/custom-fields.php';
// Personalizar Admin
require get_template_directory() . '/inc/custom-admin.php';

// Agregamos Chat GPT4 a nuestro tema
function conectar_a_chatgpt($mensaje) {
    $api_url = 'https://api.openai.com/v1/chat/completions';
    
    $data = [
        'model' => 'gpt-4', // O usa 'gpt-4' si tienes acceso
        'messages' => [
            ['role' => 'system', 'content' => 'Eres un asistente virtual.'],
            ['role' => 'user', 'content' => $mensaje],
        ],
        'max_tokens' => 100,
    ];

    $response = wp_remote_post($api_url, [
        'headers' => [
            'Authorization' => 'Bearer ' . OPENAI_API_KEY,
            'Content-Type' => 'application/json',
        ],
        'body' => json_encode($data),
    ]);

    if (is_wp_error($response)) {
        return 'Error al conectarse a la API.';
    }

    $body = json_decode(wp_remote_retrieve_body($response), true);

    if (isset($body['choices'][0]['message']['content'])) {
        return $body['choices'][0]['message']['content'];
    }

    return 'No se pudo obtener una respuesta de la API.';
}

add_action('init', function() {
    if (current_user_can('administrator')) { // Solo los admins verán este mensaje
        $respuesta = conectar_a_chatgpt('Hola, ¿cómo estás?');
        error_log('Prueba de conexión a la API: ' . $respuesta);
    }
});


add_action('init', function() {
    load_textdomain('complianz-gdpr', WP_LANG_DIR . '/plugins/complianz-gdpr-' . get_locale() . '.mo');
    load_textdomain('rank-math-pro', WP_LANG_DIR . '/plugins/rank-math-pro-' . get_locale() . '.mo');
    load_textdomain('updraftplus', WP_LANG_DIR . '/plugins/updraftplus-' . get_locale() . '.mo');
});

?>