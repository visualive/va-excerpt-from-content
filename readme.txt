=== VA Excerpt From Content ===
Contributors: kuck1u, natsumiine, toro_unit
Donate link: http://www.amazon.co.jp/registry/wishlist/AN9BLYUQMVZ5/
Tags: post, posts, excerpt, content
Requires at least: 4.5.2
Tested up to: 4.5.2
Stable tag: trunk
License: GPLv3 or later
License URI: http://www.gnu.org/licenses/gpl-3.0.html

Automatically create the excerpt from content.

== Description ==

You don't need to enter an excerpt. Plug-ins auto-create excerpt from the content.

* Is the number of characters set in the "excerpt_length" filter.
* "Continue reading" setting in the "excerpt_more" filter.
* If there is "<!--more-->" does not create an excerpt.
* remove the html and "va_excerpt_from_content_strip_all_tags" filter to true.

```
// remove the html.
add_filter( 'va_excerpt_from_content_strip_all_tags', '__return_true' );
```

= Requires =
* WordPress 4.5 or higher
* PHP 5.6+

= Contribute! =
You can fork the plugin from [GitHub](https://github.com/visualive/va-excerpt-from-content)

== Installation ==

To install "VA Excerpt From Content":

1. Upload the "va-excerpt-from-content" directory and all its contents to your `/wp-content/plugins/` directory.
2. Activate the plugin through the 'Plugins' menu in WordPress.

== Screenshots ==

1. You don't need to enter an excerpt.
2. Plug-ins auto-create excerpt from the content..

== Changelog ==

= 1.0.0 =
* First public release
