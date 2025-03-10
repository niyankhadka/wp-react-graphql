<?php 

/*
 * Plugin Name:       Articles GraphQL
 * Plugin URI:        #
 * Description:       Articles GraphQL
 * Version:           1.0.0
 * Requires at least: 5.2
 * Requires PHP:      7.2
 * Author:            niyankhadka
 * Author URI:        #
 * License:           GPL v2 or later
 * License URI:       https://www.gnu.org/licenses/gpl-2.0.html
 * Update URI:        #
 * Text Domain:       articles-graphql
 * Domain Path:       /languages
 * Requires Plugins:  wp-graphql
 */

 if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly
}

define( 'ARTICLES_GRAPHQL_PLUGIN_DIR', plugin_dir_path( __FILE__ ) );
define( 'ARTICLES_GRAPHQL_PLUGIN_URL', plugin_dir_url( __FILE__ ) );

/**
 * Register the "articles" custom post type
 */
function articles_graphql_setup_post_type() {
	register_post_type( 'articles',
		array(
			'labels'      => array(
				'name'          => __( 'Articles', 'articles-graphql' ),
				'singular_name' => __( 'Article', 'articles-graphql' ),
			),
			'supports' => array( 
				'title', 
				'editor', 
				'excerpt', 
				'thumbnail', 
				'author',
				'trackbacks', 
				'custom-fields', 
				'comments', 
				'revisions' 
			),
			'taxonomies' => array( 'article_category' ),
			'public'      => true,
			'has_archive' => true,
			'query_var' => true,
			'can_export' => true,
			'rewrite'     => array( 'slug' => 'article' ),
			'capability_type' => 'post',
			'show_in_rest' => true,
			'show_in_graphql' => true,
			'graphql_single_name' => 'article_graphql', 
			'graphql_plural_name' => 'articles_graphql',
		)
	); 
} 
add_action( 'init', 'articles_graphql_setup_post_type' );

/**
 * Register the "articles" taxonomies
 */
function articles_graphql_taxionomies() {
	$labels = array(
		'name'              => _x( 'Article Category', 'taxonomy general name', 'articles-graphql' ),
		'singular_name'     => _x( 'Article Category', 'taxonomy singular name', 'articles-graphql' ),
		'search_items'      => __( 'Search Articles', 'articles-graphql' ),
		'all_items'         => __( 'All Articles', 'articles-graphql' ),
		'parent_item'       => __( 'Parent Article', 'articles-graphql' ),
		'parent_item_colon' => __( 'Parent Article:', 'articles-graphql' ),
		'edit_item'         => __( 'Edit Article', 'articles-graphql' ),
		'update_item'       => __( 'Update Article', 'articles-graphql' ),
		'add_new_item'      => __( 'Add New Article', 'articles-graphql' ),
		'new_item_name'     => __( 'New Article Name', 'articles-graphql' ),
		'menu_name'         => __( 'Article Category', 'articles-graphql' ),
	);
	$args   = array(
		'hierarchical'      => true, // make it hierarchical (like categories)
		'labels'            => $labels,
		'show_ui'           => true,
		'show_admin_column' => true,
		'query_var'         => true,
		'rewrite'      		=> array( 'slug' => 'article-category' ),
		'show_in_rest' 		=> true,
		'show_in_graphql' 	=> true,
		'graphql_single_name' => 'articleCategory_graphql',
		'graphql_plural_name' => 'articleCategories_graphql',
	);
	register_taxonomy( 'article_category', 'articles', $args );
}
add_action( 'init', 'articles_graphql_taxionomies' );

/**
 * Add custom template for single article
 */
function get_single_article_template( $single_template ) {
	global $post;

	if ( 'articles' === $post->post_type ) {
		$single_template = ARTICLES_GRAPHQL_PLUGIN_DIR . '/templates/single-article.php';
	}

	return $single_template;
}
add_filter( 'single_template', 'get_single_article_template' );

/**
 * Add custom template for archive article
 */
function get_archive_article_template( $archive_template ) {
	if( is_archive('article_category' )) {
	$archive_template = ARTICLES_GRAPHQL_PLUGIN_DIR . '/templates/archive-article.php';
	}
	return $archive_template;
}
add_filter( "archive_template", 'get_archive_article_template');

/**
 * Add custom template for page articles
 */
function get_page_articles_template( $template ) {

    if ( is_page( 'articles' )  ) {
        $new_template =  ARTICLES_GRAPHQL_PLUGIN_DIR . '/templates/page-articles.php';
        return $new_template;
    }
	return $template;
}
add_filter( 'template_include', 'get_page_articles_template' );

/**
 * Enqueue assets for the React app
 */
function articles_graphql_react_app_enqueue_assets() {
	// wp_enqueue_style(
	// 	'articles-graphql-react-app-css',
	// 	ARTICLES_GRAPHQL_PLUGIN_URL . '/react-app/build/index.css',
	// 	[],
	// 	'1.0.0' // version number
	// );
	
	wp_enqueue_script(
		'articles-graphql-react-app-js',
		ARTICLES_GRAPHQL_PLUGIN_URL . 'react-app/build/index.js',
		[ 'wp-blocks', 'wp-element', 'wp-editor' ],
		'1.0.0', // version number
		true // enqueue the script in the footer)
	);

	wp_localize_script(
		'articles-graphql-react-app-js',
		'articlesGraphqlReactApp',
		[	
			'siteUrl' => esc_url( site_url() ),
			'apiUrl' => esc_url( site_url() ) . '/graphql',
			'nonce' => wp_create_nonce( 'articles-graphql-nonce' ),
		]
	);
}
add_action( 'init', 'articles_graphql_react_app_enqueue_assets' );

/**
 * Activate the plugin.
 */
function articles_graphql_activate() {
	// Trigger our function that registers the custom post type plugin.
	articles_graphql_setup_post_type();
	// Trigger our function that registers the custom taxonomy plugin.
	articles_graphql_taxionomies();
	// Enqueue the assets for the React app.
	articles_graphql_react_app_enqueue_assets();
	// Clear the permalinks after the post type has been registered.
	flush_rewrite_rules(); 
}
register_activation_hook( __FILE__, 'articles_graphql_activate' );

/**
 * Deactivation hook.
 */
function articles_graphql_deactivate() {
	// Unregister the post type, so the rules are no longer in memory.
	unregister_post_type( 'articles' );
	// Unregister the taxonomy, so the rules are no longer in memory.
	unregister_taxonomy( 'article_category' );
	// Clear the permalinks to remove our post type's rules from the database.
	flush_rewrite_rules();
}
register_deactivation_hook( __FILE__, 'articles_graphql_deactivate' );