=== Rezdy Reloaded ===
Contributors: EnigmaWeb
Donate link: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=CEJ9HFWJ94BG4
Tags: rezdy, rezdy reloaded, bookings, reservations
Requires at least: 3.1
Tested up to: 4.8
Stable tag: trunk
License: GPLv2 or later
License URI: http://www.gnu.org/licenses/gpl-2.0.html

Elegant Rezdy integration for WordPress

== Description ==

Rezdy Reloaded is a neat integration between Rezdy (booking software) and WordPress. It is based on a WordPress custom post type, allowing you to manage your tour info on the WordPress side (giving you full control over content, visual design and SEO). It displays the Rezdy booking widget to the right, sending customers over to Rezdy to complete checkout.

I built this plugin for my client, [Matters of Taste,](http://mattersoftaste.com.au/cooking-classes) because they needed more control over the design/display of their listings than the official Rezdy plugin provided. I am happy to share it, and  hope that it will be useful for other Rezdy customers.

= Key Features =

* Fully responsive
* Works in all major browsers - IE9+, Safari, Firefox, Chrome
* Gives you full control over your sales listings on the WordPress side
* Customise base slug (default is "rezdy-items" but you might like to change this depending on your industry. Eg "cooking-classes")
* Custom post type supports categories, tags, excerpts, featured image and revisions.
* Display items in list or grid
* Fully customisable using templating system (more info in FAQs)

= Demo =

* [Click here](http://demo.enigmaweb.com.au/reloaded-rezdy/) for out-of-the-box demo
* [Click here](http://mattersoftaste/cooking-classes) for an example of a fully styled implementation. This site also uses the Rezdy API to pull in session data. So please note it's a little more advanced than the plugin provides out of the box.

== Installation ==

1. Upload the `reloaded-rezdy` folder to the `/wp-content/plugins/` directory
1. Activate Rezdy Reloaded plugin through the 'Plugins' menu in WordPress
1. Configure the plugin by going to the `Rezdy Reloaded` tab that appears in your admin menu > Settings
 
== Frequently Asked Questions ==

= What is Rezdy? =

Rezdy is a fantastic online bookings software for tour and activity providers. Find out more at [rezdy.com](https://www.rezdy.com/)

Note that Rezdy Reloaded is an unofficial plugin made by me, Maeve Lander, a simple user and fan of Rezdy, un-affiliated with them in any way.

= How can I customise the design? =

You can set a custom slug, and set the image sizes via Rezdy Reloaded > Settings.

Developers, you can completely customise the way the post type displays by copying the plugin templates to your theme and customising them there. You may be familiar with this method of templating as used by WooCommerce.

In the plugin's root directory you will find a folder called `rezdy-template`. You can override that folder and any of the files within, by copying them into your active theme ie. `yourtheme/rezdy-template`. Rezdy Reloaded plugin will automatically load any template files you have in that folder in your theme, and use them instead of its default template files. If no such folder or files exist in your theme, it will use the ones from the plugin.

This is the safest way to customise the Rezdy Reloaded templates, as it means that your changes will not be overwritten when the plugin updates.

= How can I customise the booking widget & checkout? =

The booking widget is pulled in from Rezdy using an iFrame, and your users will be redirected to checkout on your Rezdy hosted site. This is currently just the way Rezdy works - there is no way around this. Thus, if you want to customise the design of the booking widget and/or checkout then you must do so via Rezdy. [Tutorial here.](https://support.rezdy.com/hc/en-us/articles/203690694-How-to-setup-your-booking-form)

Note that they do actually give you access to the header & footer html, and the CSS, so in fact with some clever coding you can get your checkout pretty seamlessly integrated with the design of your main WordPress site. For an example, check out [Matters of Taste here.](http://mattersoftaste.com.au/cooking-classes)

= Can I use Rezdy Reloaded in my Language? =

Yes, the plugin is internationalized and ready for translation. If you would like to help with a translation please [contact me](http://www.enigmaplugins.com/contact-support)
You can also use it WPML. After installing and activating both plugins, go to WPML > Translation Management > Multilangual Content Setup > scroll all the way down > tick the checkbox 'custom posts' and 'custom taxanomies' for this post type, set to 'Translate'.

= Where can I get support for this plugin? =

If you've tried all the obvious stuff and it's still not working please request support via the [support forum here.](https://wordpress.org/support/plugin/reloaded-rezdy/)

And by popular request... if you would like my help with a more advanced Rezdy Integration (eg API stuff, styling your checkout etc) please [get in touch here.](http://www.enigmaplugins.com/contact-support)


== Screenshots ==

1. An example of Rezdy Reloaded in action, post detail view with booking widget
2. Another example of Rezdy Reloaded front-end, post archive view
3. The settings screen in WP-Admin
4. The product editor in WP-Admin

== Changelog ==

= 1.0.1 =
* Remove / from Rezdy widget URL

= 1.0 =
* Initial release

== Upgrade Notice ==

= 1.0.1 =
* Remove / from Rezdy widget URL - a very small but very important update

= 1.0 =
* Initial release