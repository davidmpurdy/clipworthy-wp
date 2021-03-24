<?php
/*
 * Plugin Name: Clipworthy for WordPress
 * Description: Adds features to integrate the Clipworthy platform with WordPress
 * Author:      David Purdy
 * Version:     0.1
 * License:     GPLv2 or later
 * License URI: http://www.gnu.org/licenses/old-licenses/gpl-2.0.html
 * Text Domain: clipworthy-wp
 * 
 * This program is free software; you can redistribute it and/or modify it under the terms of the GNU
 * General Public License version 2, as published by the Free Software Foundation. You may NOT assume
 * that you can use any other version of the GPL.
 *
 * This program is distributed in the hope that it will be useful, but WITHOUT ANY WARRANTY; without
 * even the implied warranty of MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.
 */

namespace ClipworthyWP;

// this plugin's directory
define (__NAMESPACE__ . '\PLUGIN_DIR', __DIR__);
define (__NAMESPACE__ . '\PLUGIN_FILE', __FILE__);


require_once (PLUGIN_DIR . '/includes/media-fields.php');