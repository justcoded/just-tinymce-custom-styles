=== Just TinyMCE Custom Styles === 
Plugin Name: Just TinyMCE Custom Styles
Description: Adds dropdown options for custom css classes and attributes for tags in WordPress TinyMCE Editor
Tags: tinymce, editor, link class, custom styles, styles, tag class, link attributes, tag attributes, custom editor
Version: 1.1
Contributors: aprokopenko
Author: JustCoded / Alex Prokopenko
Author URI: http://justcoded.com/
License: GPL2
Requires at least: 4.3
Tested up to: 5.0.1
Stable tag: trunk

Adds dropdown options for custom css classes and attributes for tags in WordPress TinyMCE Editor.

== Description ==

This plugin controls the TinyMce "style_formats" parameter. It allows adding custom formatters to the Wysiwyg editor.

This is only a user interface to the standard feature, which is disabled by default and explained in the official
documentation on codex.wordpress.org: https://codex.wordpress.org/TinyMCE_Custom_Styles

= Features =

* Load Settings from DB or .json file from theme
* Enable/Disable some style_format features for more clean formatting
* Nice interface to quickly add your formats
* Ability to apply custom editor css for each rule separately
* You can group your styles for more clear usage
* Bootstrap preset: pre-defined bootstrap styles for editor.

= Example: Custom link class =

For example, you can define an addition dropdown option of the css classes for the link tag.
To do so, create such row formatter:.

* Title: My Link Style
* Selector: a
* Classes: my-link-style
* Editor CSS: a.my-link-style { color:red; }

= Plugin Demo =

https://www.youtube.com/watch?v=fljkfet52eg

= Presets =

We added special feature called "Presets" - these are pre-defined styles included inside the plugin.
You can import them to your site with a single click.

With presets we plan to add popular CSS framework classes to be able to use them inside the editor.
We started with a Bootstrap preset, because it's one of the most popular CSS framework right now.

= ISSUES TRACKER =

If you have any feedbacks or bugs found, please write to our GitHub issues tracker:
https://github.com/justcoded/just-tinymce-custom-styles/issues

== Installation ==

1. Download, unzip and upload to your WordPress plugins directory.
2. Activate the plugin within your WordPress Administration Backend.
3. Go to Settings > TinyMCE Custom Styles.
4. Open the Settings page, enable required elements and save Settings.
5. Open the TinyMCE Styles page and add your options.
6. Save values.

== Upgrade Notice ==

To upgrade remove the old plugin folder. After than follow the installation steps 1-2. All settings will be saved.

== Screenshots ==

1. Plugin settings page where you can enable/disable formatter options
2. Style formatters edit
3. WordPress editor look
3. Bootstrap styles preset

== Changelog ==
* Version 1.2
	* Fixed preset import: If you don't have "type" feature enabled in your settings, import will enable it for you.
* Version 1.1
	* Ability to group new styles into dropdowns
	* Presets: pre-defined list of styles. Bootstrap added.
* Version 1.0
	* First version of the plugin
