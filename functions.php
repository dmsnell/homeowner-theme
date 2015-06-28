<?php
/**
 * Homeowner functions and definitions
 *
 * @package Homeowner
 */

if ( ! function_exists( 'homeowner_setup' ) ) :
/**
 * Sets up theme defaults and registers support for various WordPress features.
 *
 * Note that this function is hooked into the after_setup_theme hook, which
 * runs before the init hook. The init hook is too late for some features, such
 * as indicating support for post thumbnails.
 */
function homeowner_setup() {
	/*
	 * Make theme available for translation.
	 * Translations can be filed in the /languages/ directory.
	 * If you're building a theme based on Homeowner, use a find and replace
	 * to change 'homeowner' to the name of your theme in all the template files
	 */
	load_theme_textdomain( 'homeowner', get_template_directory() . '/languages' );

	// Add default posts and comments RSS feed links to head.
	add_theme_support( 'automatic-feed-links' );

	/*
	 * Let WordPress manage the document title.
	 * By adding theme support, we declare that this theme does not use a
	 * hard-coded <title> tag in the document head, and expect WordPress to
	 * provide it for us.
	 */
	add_theme_support( 'title-tag' );

	/*
	 * Enable support for Post Thumbnails on posts and pages.
	 *
	 * @link http://codex.wordpress.org/Function_Reference/add_theme_support#Post_Thumbnails
	 */
	add_theme_support( 'post-thumbnails' );

	// This theme uses wp_nav_menu() in one location.
	register_nav_menus( array(
		'primary' => esc_html__( 'Primary Menu', 'homeowner' ),
	) );

	/*
	 * Switch default core markup for search form, comment form, and comments
	 * to output valid HTML5.
	 */
	add_theme_support( 'html5', array(
		'search-form',
		'comment-form',
		'comment-list',
		'gallery',
		'caption',
	) );

	/*
	 * Enable support for Post Formats.
	 * See http://codex.wordpress.org/Post_Formats
	 */
	add_theme_support( 'post-formats', array(
		'aside',
		'image',
		'video',
		'quote',
		'link',
	) );

	// Set up the WordPress core custom background feature.
	add_theme_support( 'custom-background', apply_filters( 'homeowner_custom_background_args', array(
		'default-color' => 'ffffff',
		'default-image' => '',
	) ) );
}
endif; // homeowner_setup
add_action( 'after_setup_theme', 'homeowner_setup' );

/**
 * Set the content width in pixels, based on the theme's design and stylesheet.
 *
 * Priority 0 to make it available to lower priority callbacks.
 *
 * @global int $content_width
 */
function homeowner_content_width() {
	$GLOBALS['content_width'] = apply_filters( 'homeowner_content_width', 640 );
}
add_action( 'after_setup_theme', 'homeowner_content_width', 0 );

/**
 * Register widget area.
 *
 * @link http://codex.wordpress.org/Function_Reference/register_sidebar
 */
function homeowner_widgets_init() {
	register_sidebar( array(
		'name'          => esc_html__( 'Sidebar', 'homeowner' ),
		'id'            => 'sidebar-1',
		'description'   => '',
		'before_widget' => '<aside id="%1$s" class="widget %2$s">',
		'after_widget'  => '</aside>',
		'before_title'  => '<h1 class="widget-title">',
		'after_title'   => '</h1>',
	) );
}
add_action( 'widgets_init', 'homeowner_widgets_init' );

/**
 * Enqueue scripts and styles.
 */
function homeowner_scripts() {
	wp_enqueue_style( 'homeowner-style', get_stylesheet_uri() );

	wp_enqueue_script( 'homeowner-navigation', get_template_directory_uri() . '/js/navigation.js', array(), '20120206', true );

	wp_enqueue_script( 'homeowner-skip-link-focus-fix', get_template_directory_uri() . '/js/skip-link-focus-fix.js', array(), '20130115', true );

	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) ) {
		wp_enqueue_script( 'comment-reply' );
	}
}
add_action( 'wp_enqueue_scripts', 'homeowner_scripts' );


add_action( 'wp_enqueue_scripts', 'load_dashicons_front_end' );
function load_dashicons_front_end() {
wp_enqueue_style( 'dashicons' );
}

if ( ! function_exists('neat_trim') ) {

	function neat_trim($str, $n, $delim='...') {                                                                                                                                                          
	  $len = strlen($str);
	  if ($len > $n) {
	    preg_match('/(.{' . $n . '}.*?)\b/', $str, $matches);
	    return rtrim($matches[1]) . $delim;
	  }
	  else {
	    return $str;
	  }
	}

}

if ( ! function_exists('register_maintenance_post_type') ) {

// Register Custom Post Type
function register_maintenance_post_type() {

	$labels = array(
		'name'                => _x( 'Maintenance', 'Post Type General Name', 'homeowner' ),
		'singular_name'       => _x( 'Maintenance', 'Post Type Singular Name', 'homeowner' ),
		'menu_name'           => __( 'Maintenance', 'homeowner' ),
		'name_admin_bar'      => __( 'Maintenance', 'homeowner' ),
		'parent_item_colon'   => __( 'Parent Item:', 'homeowner' ),
		'all_items'           => __( 'All Items', 'homeowner' ),
		'add_new_item'        => __( 'Add New Item', 'homeowner' ),
		'add_new'             => __( 'Add New', 'homeowner' ),
		'new_item'            => __( 'New Item', 'homeowner' ),
		'edit_item'           => __( 'Edit Item', 'homeowner' ),
		'update_item'         => __( 'Update Item', 'homeowner' ),
		'view_item'           => __( 'View Item', 'homeowner' ),
		'search_items'        => __( 'Search Item', 'homeowner' ),
		'not_found'           => __( 'Not found', 'homeowner' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'homeowner' ),
	);
	$args = array(
		'label'               => __( 'maintenance', 'homeowner' ),
		'description'         => __( 'Maintenance Performed', 'homeowner' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		'taxonomies'          => array( 'company', ' area' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-hammer',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'maintenance', $args );

}

// Hook into the 'init' action
add_action( 'init', 'register_maintenance_post_type', 0 );

}


if ( ! function_exists('register_upgrade_post_type') ) {

// Register Custom Post Type
function register_upgrade_post_type() {

	$labels = array(
		'name'                => _x( 'Upgrades', 'Post Type General Name', 'homeowner' ),
		'singular_name'       => _x( 'Upgrade', 'Post Type Singular Name', 'homeowner' ),
		'menu_name'           => __( 'Upgrades', 'homeowner' ),
		'name_admin_bar'      => __( 'Upgrades', 'homeowner' ),
		'parent_item_colon'   => __( 'Parent Item:', 'homeowner' ),
		'all_items'           => __( 'All Items', 'homeowner' ),
		'add_new_item'        => __( 'Add New Upgrade', 'homeowner' ),
		'add_new'             => __( 'Add New', 'homeowner' ),
		'new_item'            => __( 'New Upgrade', 'homeowner' ),
		'edit_item'           => __( 'Edit Upgrade', 'homeowner' ),
		'update_item'         => __( 'Update Upgrade', 'homeowner' ),
		'view_item'           => __( 'View Upgrade', 'homeowner' ),
		'search_items'        => __( 'Search Upgrade', 'homeowner' ),
		'not_found'           => __( 'Not found', 'homeowner' ),
		'not_found_in_trash'  => __( 'Not found in Trash', 'homeowner' ),
	);
	$args = array(
		'label'               => __( 'upgrade', 'homeowner' ),
		'description'         => __( 'Upgrade Performed', 'homeowner' ),
		'labels'              => $labels,
		'supports'            => array( 'title', 'editor', 'excerpt', 'author', 'thumbnail', 'comments', 'revisions', 'custom-fields', ),
		'taxonomies'          => array( 'company', ' area' ),
		'hierarchical'        => false,
		'public'              => true,
		'show_ui'             => true,
		'show_in_menu'        => true,
		'menu_position'       => 5,
		'menu_icon'           => 'dashicons-lightbulb',
		'show_in_admin_bar'   => true,
		'show_in_nav_menus'   => true,
		'can_export'          => true,
		'has_archive'         => true,
		'exclude_from_search' => false,
		'publicly_queryable'  => true,
		'capability_type'     => 'post',
	);
	register_post_type( 'upgrade', $args );

}

// Hook into the 'init' action
add_action( 'init', 'register_upgrade_post_type', 0 );

}




if ( ! function_exists( 'register_company_taxonomy' ) ) {

// Register Custom Taxonomy
function register_company_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Companies', 'Taxonomy General Name', 'homeowner' ),
		'singular_name'              => _x( 'Company', 'Taxonomy Singular Name', 'homeowner' ),
		'menu_name'                  => __( 'Companies', 'homeowner' ),
		'all_items'                  => __( 'All Companies', 'homeowner' ),
		'parent_item'                => __( 'Parent Company', 'homeowner' ),
		'parent_item_colon'          => __( 'Parent Company:', 'homeowner' ),
		'new_item_name'              => __( 'New Company', 'homeowner' ),
		'add_new_item'               => __( 'Add New Company', 'homeowner' ),
		'edit_item'                  => __( 'Edit Company', 'homeowner' ),
		'update_item'                => __( 'Update Company', 'homeowner' ),
		'view_item'                  => __( 'View Company', 'homeowner' ),
		'separate_items_with_commas' => __( 'Separate companies with commas', 'homeowner' ),
		'add_or_remove_items'        => __( 'Add or remove companies', 'homeowner' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'homeowner' ),
		'popular_items'              => __( 'Popular Companies', 'homeowner' ),
		'search_items'               => __( 'Search Companies', 'homeowner' ),
		'not_found'                  => __( 'Not Found', 'homeowner' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'company', array( 'maintenance', 'upgrade' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'register_company_taxonomy', 0 );

}



if ( ! function_exists( 'register_area_taxonomy' ) ) {

// Register Custom Taxonomy
function register_area_taxonomy() {

	$labels = array(
		'name'                       => _x( 'Areas', 'Taxonomy General Name', 'homeowner' ),
		'singular_name'              => _x( 'Area', 'Taxonomy Singular Name', 'homeowner' ),
		'menu_name'                  => __( 'Areas', 'homeowner' ),
		'all_items'                  => __( 'All Areas', 'homeowner' ),
		'parent_item'                => __( 'Parent Area', 'homeowner' ),
		'parent_item_colon'          => __( 'Parent Area:', 'homeowner' ),
		'new_item_name'              => __( 'New Area', 'homeowner' ),
		'add_new_item'               => __( 'Add New Area', 'homeowner' ),
		'edit_item'                  => __( 'Edit Area', 'homeowner' ),
		'update_item'                => __( 'Update Area', 'homeowner' ),
		'view_item'                  => __( 'View Area', 'homeowner' ),
		'separate_items_with_commas' => __( 'Separate areas with commas', 'homeowner' ),
		'add_or_remove_items'        => __( 'Add or remove areas', 'homeowner' ),
		'choose_from_most_used'      => __( 'Choose from the most used', 'homeowner' ),
		'popular_items'              => __( 'Popular Areas', 'homeowner' ),
		'search_items'               => __( 'Search Areas', 'homeowner' ),
		'not_found'                  => __( 'Not Found', 'homeowner' ),
	);
	$args = array(
		'labels'                     => $labels,
		'hierarchical'               => true,
		'public'                     => true,
		'show_ui'                    => true,
		'show_admin_column'          => true,
		'show_in_nav_menus'          => true,
		'show_tagcloud'              => true,
	);
	register_taxonomy( 'area', array( 'maintenance', 'upgrade' ), $args );

}

// Hook into the 'init' action
add_action( 'init', 'register_area_taxonomy', 0 );

}


function remove_menus(){
  
  remove_menu_page( 'upload.php' );                 //Media
  remove_menu_page( 'edit.php?post_type=page' );    //Pages
  
}
add_action( 'admin_menu', 'remove_menus' );


include_once('advanced-custom-fields/acf.php');
define( 'ACF_LITE', true );

if(function_exists("register_field_group"))
{
	register_field_group(array (
		'id' => 'acf_work-information',
		'title' => 'Work Information',
		'fields' => array (
			array (
				'key' => 'field_558f50809a3ab',
				'label' => 'Date Performed',
				'name' => 'date_performed',
				'type' => 'date_picker',
				'date_format' => 'yy-mm-dd',
				'display_format' => 'mm/dd/yy',
				'first_day' => 0,
			),
			array (
				'key' => 'field_558f50cc9a3ac',
				'label' => 'Cost',
				'name' => 'cost',
				'type' => 'text',
				'default_value' => '',
				'placeholder' => '',
				'prepend' => '$',
				'append' => '',
				'formatting' => 'none',
				'maxlength' => '',
			),
			array (
				'key' => 'field_558f50ff9a3ad',
				'label' => 'Receipt',
				'name' => 'receipt',
				'type' => 'image',
				'save_format' => 'object',
				'preview_size' => 'thumbnail',
				'library' => 'uploadedTo',
			),
			array (
				'key' => 'field_558f63a5b5d08',
				'label' => 'Rating',
				'name' => 'rating',
				'type' => 'select',
				'choices' => array (
					1 => 1,
					2 => 2,
					3 => 3,
					4 => 4,
					5 => 5,
				),
				'default_value' => '',
				'allow_null' => 0,
				'multiple' => 0,
			),
		),
		'location' => array (
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'maintenance',
					'order_no' => 0,
					'group_no' => 0,
				),
			),
			array (
				array (
					'param' => 'post_type',
					'operator' => '==',
					'value' => 'upgrade',
					'order_no' => 0,
					'group_no' => 1,
				),
			),
		),
		'options' => array (
			'position' => 'side',
			'layout' => 'default',
			'hide_on_screen' => array (
			),
		),
		'menu_order' => 0,
	));
}




/**
 * Implement the Custom Header feature.
 */
require get_template_directory() . '/inc/custom-header.php';

/**
 * Custom template tags for this theme.
 */
require get_template_directory() . '/inc/template-tags.php';

/**
 * Custom functions that act independently of the theme templates.
 */
require get_template_directory() . '/inc/extras.php';

/**
 * Customizer additions.
 */
require get_template_directory() . '/inc/customizer.php';

/**
 * Load Jetpack compatibility file.
 */
require get_template_directory() . '/inc/jetpack.php';
