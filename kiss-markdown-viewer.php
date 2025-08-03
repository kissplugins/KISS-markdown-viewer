<?php
/**
 * Plugin Name: KISS-markdown-viewer
 * Plugin URI:  https://github.com/kissplugins/KISS-markdown-viewer
 * Description: Simple plugin to load and render .md files in admin pages or front-end. Supports headlines, bold, italics, and hyperlinks. Provides API for other plugins to integrate and graceful fallback.
 * Version:     1.0.0
 * Author:      KISS Plugins
 * Author URI:  https://kissplugins.com
 * License:     GPLv2 or later
 */

/**
 * Table of Contents:
 * 1. Initialization and Constants
 * 2. Load Markdown Parser
 * 3. Core Render Function
 * 4. Admin Menu and Page
 * 5. Front-End Shortcode
 * 6. Public API Hooks
 */

// -----------------------------------------------------------------------------
// 1. Initialization and Constants
// -----------------------------------------------------------------------------
if ( ! defined( 'ABSPATH' ) ) {
    exit; // Exit if accessed directly
}

define( 'WP_MD_RENDERER_VERSION', '1.0.0' );
define( 'WP_MD_RENDERER_PATH', plugin_dir_path( __FILE__ ) );
define( 'WP_MD_RENDERER_URL',  plugin_dir_url( __FILE__ ) );

// -----------------------------------------------------------------------------
// 2. Load Markdown Parser
// -----------------------------------------------------------------------------
/**
 * Module 2: Include Parsedown or fallback to built-in
 * Other plugins should check for Parsedown class and include their own if needed.
 */
if ( ! class_exists( 'Parsedown' ) ) {
    require_once WP_MD_RENDERER_PATH . 'vendor/parsedown/Parsedown.php';
}

// -----------------------------------------------------------------------------
// 3. Core Render Function
// -----------------------------------------------------------------------------
/**
 * Module 3: Render Markdown content to HTML
 *
 * @param string $markdown_file Full path to the .md file
 * @return string|WP_Error Rendered HTML or WP_Error on failure
 */
function wp_md_render_file( $markdown_file ) {
    if ( ! file_exists( $markdown_file ) ) {
        return new WP_Error( 'md_not_found', 'Markdown file not found.' );
    }

    // Read content
    $content = file_get_contents( $markdown_file );

    // Parse
    $parser = new Parsedown();
    $html   = $parser->text( $content );

    /**
     * Filter the rendered HTML
     * Other plugins can hook: add_filter('wp_md_renderer_html', function($html){ return $modified; });
     */
    return apply_filters( 'wp_md_renderer_html', $html, $markdown_file );
}

// -----------------------------------------------------------------------------
// 4. Admin Menu and Page
// -----------------------------------------------------------------------------
/**
 * Module 4: Add admin menu page to view Markdown
 */
function wp_md_renderer_add_admin_page() {
    add_options_page(
        'KISS Markdown Viewer Settings',
        'KISS MD Viewer',
        'manage_options',
        'kiss-md-viewer-settings',
        'wp_md_renderer_admin_page'
    );
}
add_action( 'admin_menu', 'wp_md_renderer_add_admin_page' );

/**
 * Module 4.1: Admin page callback
 */
function wp_md_renderer_admin_page() {
    echo '<div class="wrap"><h1>KISS Markdown Viewer</h1>';
    $file = WP_MD_RENDERER_PATH . 'README.md';
    $html = wp_md_render_file( $file );

    if ( is_wp_error( $html ) ) {
        echo '<div class="error"><p>' . esc_html( $html->get_error_message() ) . '</p></div>';
    } else {
        echo '<div class="md-content">' . wp_kses_post( $html ) . '</div>';
    }
    echo '</div>';
}

/**
 * Module 4.2: Add "Settings" link to plugins page
 */
function wp_md_renderer_add_settings_link( $links ) {
    $settings_link = '<a href="options-general.php?page=kiss-md-viewer-settings">' . __( 'Settings' ) . '</a>';
    array_unshift( $links, $settings_link );
    return $links;
}
add_filter( 'plugin_action_links_' . plugin_basename( __FILE__ ), 'wp_md_renderer_add_settings_link' );

// -----------------------------------------------------------------------------
// 5. Front-End Shortcode
// -----------------------------------------------------------------------------
/**
 * Module 5: Shortcode [md_render file=""] for front-end use
 *
 * Usage: echo do_shortcode('[md_render file="path/to/file.md"]');
 */
function wp_md_renderer_shortcode( $atts ) {
    $atts = shortcode_atts( [ 'file' => '' ], $atts, 'md_render' );
    $path = WP_MD_RENDERER_PATH . ltrim( $atts['file'], '/' );

    $html = wp_md_render_file( $path );
    if ( is_wp_error( $html ) ) {
        return '<p>' . esc_html( $html->get_error_message() ) . '</p>';
    }
    return '<div class="md-content">' . wp_kses_post( $html ) . '</div>';
}
add_shortcode( 'md_render', 'wp_md_renderer_shortcode' );

// -----------------------------------------------------------------------------
// 6. Public API Hooks
// -----------------------------------------------------------------------------
/**
 * Module 6: Expose function_exists check for other plugins
 *
 * Other plugins should do:
 * if ( function_exists('wp_md_render_file') ) {
 *     $html = wp_md_render_file( $my_md_path );
 * } else {
 *     // fallback logic
 * }
 */
// Nothing extra to register; presence of function suffices.

// EOF
