<?php
/**
 * Functions to register client-side assets (scripts and stylesheets) for the
 * Gutenberg block.
 *
 * @package lep-sitemap-block
 */

/**
 * Registers all block assets so that they can be enqueued through Gutenberg in
 * the corresponding context.
 *
 * @see https://wordpress.org/gutenberg/handbook/designers-developers/developers/tutorials/block-tutorial/applying-styles-with-stylesheets/
 */
function sitemap_block_init() {
	// Skip block registration if Gutenberg is not enabled/merged.
	if ( ! function_exists( 'register_block_type' ) ) {
		return;
	}
	$dir = dirname( __FILE__ );

	$index_js = 'sitemap/index.js';
	wp_register_script(
		'sitemap-block-editor-script',
		plugins_url( $index_js, __FILE__ ),
		array(
			'wp-blocks',
			'wp-i18n',
			'wp-element',
		),
		filemtime( "$dir/$index_js" )
	);

	$editor_css = 'sitemap/editor.css';
	wp_register_style(
		'sitemap-block-editor-style',
		plugins_url( $editor_css, __FILE__ ),
		array(),
		filemtime( "$dir/$editor_css" )
	);

	$style_css = 'sitemap/style.css';
	wp_register_style(
		'sitemap-block',
		plugins_url( $style_css, __FILE__ ),
		array(),
		filemtime( "$dir/$style_css" )
	);

	register_block_type( 'lep-sitemap-block/sitemap',
		array(
			'render_callback' => 'render_sitemap_block',
			'attributes' => array(
				'list_type' => array(
					'type'  => 'string',
					'default' => 'lep_list_type'
				),
			),
			'editor_script'   => 'sitemap-block-editor-script',
			'editor_style'    => 'sitemap-block-editor-style',
			'style'           => 'sitemap-block',
		)
	);
}
add_action( 'init', 'sitemap_block_init' );
