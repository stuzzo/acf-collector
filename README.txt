=== ACF-Collector ===
Contributors: stuzzo
Donate link: https://www.paypal.me/stuzzo
Tags: acf, advanced, custom, field, fields, rest, api
Requires Wordpress: 4.7
Requires Advanced Custom Fields: 5.0
Stable tag: 1.0.0
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

It appends automatically to the current request all the custom fields used in the current content (e.g. Pages, Posts, etc.)

== Description ==

This plugin retrieves automatically all the custom fields added by you with the Advanced Custom Fields plugin.

Are you tired to use several times the ACF function `get_field` and remember all the field keys?
Do you want all the custom fields that you added on the Wordpress Rest API endpoints?
Do you want to have all the custom fields on the global `post` that you have on your template?

The ACF Collector plugin appends your custom fields on pages, posts, taxonomies and all the Wordpress objects supported by the ACF plugin.

You have to do nothing, just activate the plugin.

== Installation ==

This section describes how to install the plugin and get it working.

1. Upload `acf-collector` to the `/wp-content/plugins/` directory
1. Activate the plugin through the 'Plugins' menu in WordPress
1. Test if the plugin is active requesting `http(s)://yourhost/wp-json/wp/v2/posts`, you should see an entry key `acf_collector_field`

== Frequently Asked Questions ==

= Is it required ACF (Advanced custom fields)? =

Yes, it is. You must have ACF (at least version 5.0) installed and activated.

= What Wordress objects are supported? =

The same objects supported by the ACF plugin:

- pages
- posts
- taxonomies
- users
- and so on

= Does the plugin supports all the ACF field types? =

Yes, but in the free version you don't find support for:

- Repeater field
- Gallery field
- Flexible content field
- Clone field

= How can I notify an issue or ask for support? =

You can use the [support section of the plugin](https://wordpress.org/support/plugin/acf-collector/) or you can add an issue to [GitHub](https://github.com/stuzzo/acf-collector/).

== Links ==

* [GitHub](https://github.com/stuzzo/acf-collector/)
* [Support](https://wordpress.org/support/plugin/acf-collector/)

== Screenshots ==

1. Rest API example response
2. Dump post data in template

== Changelog ==

= 1.0.0 =
* Initial plugin release