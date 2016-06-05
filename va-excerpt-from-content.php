<?php
/**
 * Plugin Name: VA Excerpt From Content
 * Plugin URI: https://github.com/visualive/va-excerpt-from-content
 * Description: Automatically create the excerpt from content.
 * Author: KUCKLU, Natsumiine
 * Version: 1.0.0
 * Author URI: https://www.visualive.jp/
 * Text Domain: va-excerpt-from-content
 * Domain Path: /langs
 * License: GNU General Public License version 3 or later
 * License URI: http://www.gnu.org/licenses/gpl-3.0.html
 *
 * @package    WordPress
 * @subpackage VA Excerpt From Content
 * @author     KUCKLU <kuck1u@visualive.jp>
 *             Copyright (C) 2016 KUCKLU & VisuAlive.
 *             This program is free software: you can redistribute it and/or modify
 *             it under the terms of the GNU General Public License as published by
 *             the Free Software Foundation, either version 3 of the License, or
 *             (at your option) any later version.
 *             This program is distributed in the hope that it will be useful,
 *             but WITHOUT ANY WARRANTY; without even the implied warranty of
 *             MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE. See the
 *             GNU General Public License for more details.
 *             You should have received a copy of the GNU General Public License
 *             along with this program. If not, see <http://www.gnu.org/licenses/>.
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

require_once dirname( __FILE__ ) . '/incs/class-excerpt-from-content.php';

/**
 * Run plugin.
 *
 * @since VA Excerpt From Content v1.0.0
 */
add_action( 'plugins_loaded', [ 'VisuAlive_Excerpt_From_Content', 'init' ] );
