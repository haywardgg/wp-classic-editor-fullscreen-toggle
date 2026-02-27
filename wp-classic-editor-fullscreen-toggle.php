<?php
/**
 * Plugin Name: WordPress Classic Editor Fullscreen Toggle
 * Plugin URI: 
 * Description: Press Ctrl+Shift+F to toggle full-screen mode in the Classic Editor
 * Version: 1.0
 * Author: HaywardGG
 * License: GPL v2 or later
 * License URI: https://www.gnu.org/licenses/gpl-2.0.html
 * Text Domain: wp-classic-editor-fullscreen-toggle
 */

// Prevent direct access
if (!defined('ABSPATH')) {
    exit;
}

class ClassicEditorFullscreenToggle {
    
    public function __construct() {
        add_action('admin_enqueue_scripts', array($this, 'enqueue_scripts'));
    }
    
    public function enqueue_scripts($hook) {
        // Only load on post/page edit pages
        if (!in_array($hook, array('post.php', 'post-new.php'))) {
            return;
        }
        
        // Check if classic editor is being used
        if (!function_exists('get_current_screen')) {
            return;
        }
        
        $screen = get_current_screen();
        
        // Only load for post types that use editor
        if (!$screen || !post_type_supports($screen->post_type, 'editor')) {
            return;
        }
        
        // Enqueue our JavaScript
        wp_enqueue_script(
            'wp-classic-editor-fullscreen-toggle',
            plugins_url('js/fullscreen-toggle.js', __FILE__),
            array('jquery'),
            '1.0',
            true
        );
        
        // Add inline CSS for fullscreen mode
        wp_add_inline_style('wp-admin', $this->get_fullscreen_css());
    }
    
    private function get_fullscreen_css() {
        return '
            /* Fullscreen mode styles */
            body.ceft-fullscreen-mode #wpcontent {
                margin-left: 0 !important;
                padding-left: 0 !important;
            }
            
            body.ceft-fullscreen-mode #wpadminbar {
                display: none;
            }
            
            body.ceft-fullscreen-mode #adminmenumain {
                display: none;
            }
            
            body.ceft-fullscreen-mode #wpfooter {
                display: none;
            }
            
            body.ceft-fullscreen-mode #edit-slug-box {
                display: none;
            }
            
            body.ceft-fullscreen-mode #minor-publishing-actions {
                display: none;
            }
            
            body.ceft-fullscreen-mode #misc-publishing-actions {
                display: none;
            }
            
            body.ceft-fullscreen-mode .page-title-action {
                display: none;
            }
            
            body.ceft-fullscreen-mode #post-body-content {
                float: none;
                width: 100%;
            }
            
            body.ceft-fullscreen-mode #postbox-container-1 {
                display: none;
            }
            
            body.ceft-fullscreen-mode #normal-sortables {
                display: none;
            }
            
            body.ceft-fullscreen-mode #poststuff #post-body.columns-2 {
                margin-right: 0;
            }
            
            body.ceft-fullscreen-mode #wp-content-editor-tools {
                position: sticky;
                top: 0;
                background: #f0f0f1;
                z-index: 999;
                padding-top: 10px;
            }
            
            body.ceft-fullscreen-mode #wp-content-editor-container {
                min-height: calc(100vh - 150px);
            }
            
            body.ceft-fullscreen-mode .wp-editor-area {
                min-height: calc(100vh - 200px) !important;
            }
            
            /* Visual feedback for shortcut */
            .ceft-shortcut-hint {
                display: inline-block;
                margin-left: 10px;
                padding: 4px 8px;
                background: #2c3338;
                color: #fff;
                border-radius: 4px;
                font-size: 11px;
                font-family: monospace;
                opacity: 0.7;
            }
            
            body.ceft-fullscreen-mode .ceft-shortcut-hint {
                position: fixed;
                bottom: 20px;
                right: 20px;
                z-index: 9999;
                opacity: 0.4;
            }
            
            body.ceft-fullscreen-mode .ceft-shortcut-hint:hover {
                opacity: 1;
            }
        ';
    }
}

// Initialize the plugin
function wp_classic_editor_fullscreen_toggle_init() {
    new ClassicEditorFullscreenToggle();
}
add_action('plugins_loaded', 'wp_classic_editor_fullscreen_toggle_init');
