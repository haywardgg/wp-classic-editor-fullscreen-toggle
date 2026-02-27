/**
 * WordPress Classic Editor Fullscreen Toggle - JavaScript
 * Toggles fullscreen mode with Ctrl+Shift+F
 */

(function($) {
    'use strict';
    
    // Wait for DOM to be ready
    $(document).ready(function() {
        
        // Add shortcut hint to the editor toolbar
        function addShortcutHint() {
            if ($('#wp-content-media-buttons .ceft-shortcut-hint').length === 0) {
                $('#wp-content-media-buttons').append(
                    '<span class="ceft-shortcut-hint" title="Press Ctrl+Shift+F to toggle fullscreen">' +
                    'Fullscreen: Ctrl+Shift+F' +
                    '</span>'
                );
            }
        }
        
        // Call it after a short delay to ensure editor is loaded
        setTimeout(addShortcutHint, 1000);
        
        // Toggle fullscreen function
        function toggleFullscreen() {
            var $body = $('body');
            
            if ($body.hasClass('ceft-fullscreen-mode')) {
                // Exit fullscreen
                $body.removeClass('ceft-fullscreen-mode');
                
                // Update hint text
                $('.ceft-shortcut-hint').html('Fullscreen: Ctrl+Shift+F');
                
                // Remove our custom height from editor
                $('#wp-content-editor-container').css('min-height', '');
                $('.wp-editor-area').css('min-height', '');
                
            } else {
                // Enter fullscreen
                $body.addClass('ceft-fullscreen-mode');
                
                // Update hint text
                $('.ceft-shortcut-hint').html('Exit fullscreen: Ctrl+Shift+F');
                
                // Adjust editor height
                var viewportHeight = $(window).height();
                $('#wp-content-editor-container').css('min-height', viewportHeight - 150);
                $('.wp-editor-area').css('min-height', viewportHeight - 200);
                
                // If in TinyMCE visual mode, trigger resize
                if (typeof tinyMCE !== 'undefined' && tinyMCE.activeEditor) {
                    setTimeout(function() {
                        tinyMCE.activeEditor.fire('resize');
                    }, 100);
                }
            }
            
            // Trigger resize for responsive elements
            $(window).trigger('resize');
        }
        
        // Keyboard shortcut handler
        $(document).on('keydown', function(e) {
            // Check for Ctrl+Shift+F
            if (e.ctrlKey && e.shiftKey && e.key.toLowerCase() === 'f') {
                e.preventDefault(); // Prevent browser's find dialog
                toggleFullscreen();
            }
        });
        
        // Also add a small floating button for mouse users (optional)
        function addFloatingButton() {
            if ($('.ceft-floating-fullscreen-btn').length === 0) {
                var $button = $('<button class="ceft-floating-fullscreen-btn" title="Toggle Fullscreen (Ctrl+Shift+F)">⛶</button>');
                
                $button.css({
                    'position': 'fixed',
                    'bottom': '80px',
                    'right': '20px',
                    'z-index': '9999',
                    'background': '#2271b1',
                    'color': 'white',
                    'border': 'none',
                    'border-radius': '50%',
                    'width': '50px',
                    'height': '50px',
                    'font-size': '24px',
                    'cursor': 'pointer',
                    'box-shadow': '0 2px 5px rgba(0,0,0,0.3)',
                    'display': 'none' // Hidden by default
                });
                
                $button.on('click', toggleFullscreen);
                $('body').append($button);
                
                // Show button only when hovering near bottom right
                $(document).on('mousemove', function(e) {
                    var windowWidth = $(window).width();
                    var windowHeight = $(window).height();
                    
                    if (e.pageX > windowWidth - 100 && e.pageY > windowHeight - 100) {
                        $('.ceft-floating-fullscreen-btn').fadeIn(200);
                    } else {
                        $('.ceft-floating-fullscreen-btn').fadeOut(200);
                    }
                });
            }
        }
        
        // Uncomment the line below if you want the floating button
        // addFloatingButton();
        
        // Clean up when leaving the page
        $(window).on('beforeunload', function() {
            $('body').removeClass('ceft-fullscreen-mode');
        });
        
    });
    
})(jQuery);
