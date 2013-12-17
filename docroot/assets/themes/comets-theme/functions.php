<?php

    add_theme_support('post-formats');
    add_theme_support('post-thumbnails');
    add_theme_support('menus');

    add_filter('get_twig', 'add_to_twig');
    add_filter('timber_context', 'add_to_context');

    add_action('wp_enqueue_scripts', 'load_scripts');
    remove_action('wp_head', 'wp_generator');

    define('THEME_URL', get_template_directory_uri());
    function add_to_context($data){
        /* this is where you can add your own data to Timber's context object */
        $data['menu'] = new TimberMenu();
        $data['STATIC_URL'] = THEME_URL;
        return $data;
    }

    function add_to_twig($twig){
        /* this is where you can add your own fuctions to twig */
        $twig->addExtension(new Twig_Extension_StringLoader());
        $twig->addFilter('myfoo', new Twig_Filter_Function('myfoo'));
        return $twig;
    }

    function myfoo($text){
        $text .= ' bar!';
        return $text;
    }

    function load_scripts(){
        wp_enqueue_script('jquery');
    }

    function styles() {
        wp_register_style('normalize', get_template_directory_uri() . '/normalize.css', array(), '1.0', 'all');
        wp_enqueue_style('normalize'); // Enqueue it!

        wp_register_style('font', '//fonts.googleapis.com/css?family=Philosopher:400,700,400italic,700italic', array(), '1.0', 'all');
        wp_enqueue_style('font'); // Enqueue it!

        wp_register_style('base', get_template_directory_uri() . '/style.css', array(), '1.0', 'all');
        wp_enqueue_style('base'); // Enqueue it!
    }

    function scripts() {
        if (!is_admin()) {

            wp_deregister_script('jquery'); // Deregister WordPress jQuery
            wp_register_script('jquery', '//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js', array(), '1.9.1', true); // Google CDN jQuery
            wp_enqueue_script('jquery'); // Enqueue it!

            // wp_register_script('conditionizr', '//cdnjs.cloudflare.com/ajax/libs/conditionizr.js/4.0.0/conditionizr.js', array(), '4.0.0', true); // Conditionizr
            // wp_enqueue_script('conditionizr'); // Enqueue it!

            // wp_register_script('modernizr', '//cdnjs.cloudflare.com/ajax/libs/modernizr/2.6.2/modernizr.min.js', array(), '2.6.2', true); // Modernizr
            // wp_enqueue_script('modernizr'); // Enqueue it!

            wp_register_script('comets', get_template_directory_uri() . '/js/comets.js', array(), '1.0.0', true); // Custom scripts
            wp_enqueue_script('comets'); // Enqueue it!
        }
    }

    function remove_admin_bar() {
        return false;
    }

    add_action('wp_enqueue_scripts', 'scripts'); // Add Custom Scripts to wp_head
    add_action('wp_enqueue_scripts', 'styles'); // Add Theme Stylesheet
    add_filter('show_admin_bar', 'remove_admin_bar');


