<?php
/**
 * Plugin bootstrap file
 *
 * @package MWF\Plugin
 *
 * @wordpress-plugin
 * Plugin Name: MWF Plugin Dev
 * Plugin URI:  https://midwestfamilymadison.com
 * Description: Custom functions by Mid-West Family Madison
 * Version:     1.0.0
 * Author:      Mid-West Family
 * Author URI:  https://midwestfamilymadison.com
 * Donate link: https://midwestfamilymadison.com
 * Tags: comments, spam
 * Requires at least: 6.0
 * Tested up to: 6.3
 * Requires PHP: 8.0.28
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: mwf_custom_functions
 */

namespace MWF\Plugin;

defined( 'ABSPATH' ) || exit;

require_once trailingslashit( plugin_dir_path( __FILE__ ) ) . 'lib/autoload.php';

$mwf_plugin = new Plugin( 'mwf_plugin_dev', __FILE__ );

$mwf_plugin->load();