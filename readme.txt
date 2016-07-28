=== Just TinyMCE Custom Styles === 
Plugin Name: Just TinyMCE Custom Styles
Description: Adds dropdown options for custom css classes and attributes for tags in WordPress TinyMCE Editor
Tags: tinymce, editor, link class, custom styles, styles, tag class, link attributes, tag attributes, custom editor
Version: 1.0
Contributors: aprokopenko
Author: JustCoded / Alex Prokopenko
Author URI: http://justcoded.com/
License: GPL2
Requires at least: 4.3
Tested up to: 4.6
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

= Example: Custom link class =

For example, you can define an addition dropdown option of the css classes for the link tag.
To do so, create such row formatter:.

* Title: My Link Style
* Selector: a
* Classes: my-link-style
* Editor CSS: a.my-link-style { color:red; }

= Plugin Demo =

https://www.youtube.com/watch?v=fljkfet52eg

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

== Changelog ==
* Version 1.0
	* First version of the plugin
