<?php

/*
 *
 * Plugin Name: Common - Language CPT
 * Description: Wordpress Plugin for Venue Custom Post Type to be used on applicable UCF College of Arts and Humanities websites
 * Author: Austin Tindle & Alessandro Vecchi
 *
 */

/* Custom Post Type ------------------- */

// ini_set('display_errors', 1);
// ini_set('display_startup_errors', 1);
// error_reporting(E_ALL);

// Load our CSS
function language_load_plugin_css() {
    wp_enqueue_style( 'language-plugin-style', plugin_dir_url(__FILE__) . 'css/style.css');
}
add_action( 'admin_enqueue_scripts', 'language_load_plugin_css' );

// Add create function to init
add_action('init', 'language_create_type');

// Create the custom post type and register it
function language_create_type() {
	$args = array(
	      'label' => 'Languages',
	        'public' => true,
	        'show_ui' => true,
	        'capability_type' => 'post',
	        'hierarchical' => false,
	        'rewrite' => array('slug' => 'language'),
			'menu_icon'  => 'dashicons-editor-textcolor',
	        'query_var' => true,
	        'supports' => array(
	            'title',
	            'thumbnail',
	            'excerpt',
	            'revisions')
	    );
	register_post_type( 'language' , $args );
}

add_action("admin_init", "language_init");
add_action('save_post', 'language_save');

// Add the meta boxes to our CPT page
function language_init() {
	global $cbncah_slidr;

	add_meta_box("language-slider-meta", "Slidr Images", "language_meta_slider", "language", "normal", "low");
    add_meta_box("language-why-meta", "Why study", "language_meta_why", "language", "normal", "low");
    add_meta_box("language-programs-meta", "Programs", "language_meta_programs", "language", "normal", "low");
    add_meta_box("language-associations-meta", "Associations", "language_meta_associations", "language", "normal", "low");
	 add_meta_box("language-faculty-meta", "Faculty", "language_meta_faculty", "language", "normal", "low");
    add_meta_box("languages-faq-meta", "FAQ", "language_meta_faq", "language", "normal", "low");
}

// Meta box functions
function language_meta_slider(){
    global $post;
    $custom = get_post_custom($post->ID);
    
    wp_editor( $custom['slider'][0], 'slider', $settings['sm'] );
}

function language_meta_why() {
	global $post; // Get global WP post var
    $custom = get_post_custom($post->ID); // Set our custom values to an array in the global post var

    wp_editor($custom['why'][0], 'why', $settings['sm']);
}

function language_meta_programs() {
	global $post; // Get global WP post var
    $custom = get_post_custom($post->ID); // Set our custom values to an array in the global post var

    wp_editor($custom['programs'][0], 'programs', $settings['sm']);
}

function language_meta_associations() {
	global $post; // Get global WP post var
    $custom = get_post_custom($post->ID); // Set our custom values to an array in the global post var

    wp_editor($custom['associations'][0], 'associations', $settings['sm']);
}

function language_meta_faculty() {
	// global $post; // Get global WP post var
 //    $custom = get_post_custom($post->ID); // Set our custom values to an array in the global post var

 //    wp_editor($custom['associations'][0], 'associations', $settings['sm']);
}

function language_meta_faq() {
	global $post;
    $custom = get_post_custom($post->ID);
    $faq = $custom["faq"][0];
    $data = json_encode( unserialize($faq) );
    ?>
        <style>
            .add-row {
                background-color:#71da71;
                margin-left:3px;
                margin-top:5px;
                padding:5px 10px;
                display:inline-block;
                color:#000;
            }
            .add-row:hover {
                color:#333;
                cursor: pointer;
            }
            .remove-row {
               background-color: #ff4d4d;
                padding:3px 7px;
                display:inline-block;
                color:#fff;
                margin-left:5px;
            }
            .remove-row:hover {
                color:#ddd;
                cursor: pointer;
            }

        </style>
        <div id="FAQ-editor">
            <span style="display:none"><?php echo $data; ?></span>
        </div>
    <?php
}

// Save our variables
function language_save() {
	global $post;

	update_post_meta($post->ID, "slider", $_POST["slider"]);
	update_post_meta($post->ID, "why", $_POST["why"]);
	update_post_meta($post->ID, "programs", $_POST["programs"]);
	update_post_meta($post->ID, "associations", $_POST["associations"]);
	update_post_meta($post->ID, "faq", $_POST["faq"]);
}

// Settings array. This is so I can retrieve predefined wp_editor() settings to keep the markup clean
$settings = array (
	'sm' => array('textarea_rows' => 3),
	'md' => array('textarea_rows' => 6),
);


?>