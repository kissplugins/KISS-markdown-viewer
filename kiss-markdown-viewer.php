# KISS-markdown-viewer

**Contributors:** KISS Plugins  
**Tags:** markdown, viewer, parsedown, admin, shortcode  
**Requires at least:** 5.0  
**Tested up to:** 6.4  
**Stable tag:** 1.0.0  
**License:** GPLv2 or later  
**License URI:** https://www.gnu.org/licenses/gpl-2.0.html  
**Plugin URI:** https://github.com/kissplugins/KISS-markdown-viewer  
**Author:** KISS Plugins  
**Author URI:** https://kissplugins.com  

A lightweight “Keep It Simple, Stupid” Markdown viewer for WordPress. Render `.md` files in the admin area or on the front end with minimal setup. Other plugins can hook in or fall back if it’s not installed.

## Table of Contents

1. [Installation](#installation)  
2. [Usage](#usage)  
3. [Developer API](#developer-api)  
4. [Shortcode](#shortcode)  
5. [Filters & Actions](#filters--actions)  
6. [Changelog](#changelog)  
7. [Upgrade Notice](#upgrade-notice)  
8. [License](#license)

---

## Installation

1. Upload the plugin folder (`kiss-markdown-viewer/`) to your `/wp-content/plugins/` directory.  
2. Ensure the `vendor/parsedown` directory is present (bundled or via Composer).  
3. Activate **KISS-markdown-viewer** through the **Plugins** screen in WordPress.

## Usage

### Admin Preview

- Navigate to **KISS Markdown Viewer → MD Preview** to preview any `.md` file in the plugin folder.

### Front-End Shortcode

```php
echo do_shortcode( '[md_render file="docs/my-doc.md"]' );
