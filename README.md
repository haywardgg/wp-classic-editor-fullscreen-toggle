# wp-classic-editor-fullscreen-toggle
Here's a simple, lightweight WordPress plugin that adds a keyboard shortcut (Ctrl+Shift+F) to toggle full-screen mode in the Classic Editor. The plugin is minimal, focused only on the fullscreen toggle feature, and works with either the official plugin or WordPress's built-in classic mode.

## How It Works

- **Keyboard shortcut**: Press `Ctrl + Shift + F` to toggle fullscreen mode
- **What gets hidden**: Admin sidebar, admin bar, publish metabox, slug editor, and other distractions
- **Visual feedback**: Shows a small hint in the editor toolbar with the shortcut
- **Editor expands**: The editor area expands to fill most of the screen

## What It Hides in Fullscreen Mode

- WordPress admin sidebar menu
- Admin toolbar at the top
- Publish metabox (right sidebar)
- Slug editor
- Footer
- Other post metaboxes

## Optional Floating Button [Untested] 

I've included commented code for a floating circular button that appears when you hover near the bottom-right corner of the screen. If you prefer a mouse-based toggle option, uncomment the `addFloatingButton()` line in the JavaScript file.

