=== Just TinyMCE Custom Styles === 
Plugin Name: Just TinyMCE Custom Styles
Description: Plugin to control custom styles for tags in WordPress TinyMCE Editor
Tags: tinymce, editor, link class, custom styles, styles, tag class, link attributes, tag attributes, custom editor
Version: 1.0
Contributors: aprokopenko
Author: JustCoded
Author URI: http://justcoded.com/
License: GPL2
Requires at least: 4.3
Tested up to: 4.6
Stable tag: trunk

Plugin to control custom styles for tags in WordPress TinyMCE Editor.

== Description ==

This plugin controls TinyMce "style_formats" parameter. It allows to add custom formatters to the Wysiwyg editor.

This is only user interface to the standard feature, which is disabled by default and explained in official documentation on codex.wordpress.org:
https://codex.wordpress.org/TinyMCE_Custom_Styles


**Link Class select**

For example you can define addition dropdown of css classes for link tag.
To do so create such row formatter:

* Title: My Link Style
* Selector: a
* Classes: my-link-style
* Editor CSS: a.my-link-style { color:red; }


**Features**

* Load Settings from DB or .json file from theme
* Enable/Disable some style_format features for more clean formatting
* Easy to use formats edit


== Installation ==

1. Download, unzip and upload to your WordPress plugins directory
2. Activate the plugin within you WordPress Administration Backend
3. Go to Settings > TinyMCE Custom Styles
4. Open "Settings page", enable required elements and Save Settings
5. Open "TinyMCE Styles" page and add your options.
6. Save values.

== Upgrade Notice ==
* Remove old plugin folder.
* Follow installation steps 1-2. All settings will be safe.

== Screenshots ==

1. Plugin settings page where you can enable/disable formatter options
2. Style formatters edit
3. WordPress editor look

== Changelog ==
* Version 1.0
	* First version of the plugin
