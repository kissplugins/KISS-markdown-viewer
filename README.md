# KISS-markdown-viewer

**Contributors:** KISS Plugins
**Tags:** markdown, viewer, parsedown, admin, shortcode
**Requires at least:** 5.0
**Tested up to:** 6.4
**Stable tag:** 1.0.0
**License:** GPLv2 or later
**License URI:** [https://www.gnu.org/licenses/gpl-2.0.html](https://www.gnu.org/licenses/gpl-2.0.html)
**Plugin URI:** [https://github.com/kissplugins/KISS-markdown-viewer](https://github.com/kissplugins/KISS-markdown-viewer)
**Author:** KISS Plugins
**Author URI:** [https://kissplugins.com](https://kissplugins.com)

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

* Navigate to **KISS Markdown Viewer → MD Preview** to preview any `.md` file in the plugin folder.

### Front-End Shortcode

```php
echo do_shortcode( '[md_render file="docs/my-doc.md"]' );
```

Or directly in post/page content:

```
[md_render file="docs/my-doc.md"]
```

## Developer API

Programmatically render Markdown:

```php
if ( function_exists( 'wp_md_render_file' ) ) {
    $html = wp_md_render_file( '/path/to/file.md' );
} else {
    // Fallback logic
}
```

## Shortcode

* **Tag:** `[md_render file="relative/path/to.md"]`
* **Attributes:**

  * `file` (required) – Path relative to the plugin root directory.

## Filters & Actions

* **Filter:** `wp_md_renderer_html`
  Modify the rendered HTML before output:

  ```php
  add_filter( 'wp_md_renderer_html', function( $html, $file ) {
      // Alter $html as needed
      return $html;
  }, 10, 2 );
  ```

* **Suggested Action:** `wp_md_renderer_before_render`
  Hook before parsing:

  ```php
  add_action( 'wp_md_renderer_before_render', function( $file ) {
      // Pre-render logic
  } );
  ```

## Changelog

### 1.0.0

* Initial release: basic parsing, admin preview, shortcode, and API hooks.

## Upgrade Notice

### 1.0.0

Initial stable version.

---

## License

This plugin is distributed under the terms of the GNU General Public License v2.0.
See the [license text](https://www.gnu.org/licenses/gpl-2.0.html) for details.
