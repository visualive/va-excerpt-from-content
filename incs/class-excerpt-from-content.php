<?php
/**
 * Excerpt From Content
 *
 * @package    WordPress
 * @subpackage VA Excerpt From Content
 * @author     KUCKLU <kuck1u@visualive.jp>
 *             Copyright (C) 2016 KUCKLU and VisuAlive.
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

class VisuAlive_ExcerptFromContent {
	/**
	 * Get instance.
	 *
	 * @since VA Excerpt From Content v1.0.0
	 * @return VisuAlive_ExcerptFromContent
	 */
	public static function init() {
		static $instance = false;

		if ( ! $instance ) {
			$instance = new self;
		}

		return $instance;
	}

	/**
	 * Constructor should be private for singleton.
	 */
	private function __construct() {
		add_filter( 'the_content', array( &$this, 'excerpt_from_content' ) );
	}

	/**
	 * Automatically create the excerpt from content.
	 *
	 * @since VA Excerpt From Content v1.0.0
	 *
	 * @param $content
	 *
	 * @return string
	 */
	public function excerpt_from_content( $content ) {
		global $post;

		if ( ! empty( $post->post_content ) && ( ( is_front_page() && is_home() ) || is_home() || is_archive() || is_search() ) ) {
			$content = self::_create_excerpt( $post->post_content );
		}

		return $content;
	}

	/**
	 * Create the excerpt.
	 *
	 * @since VA Excerpt From Content v1.0.0
	 *
	 * @param string $content
	 *
	 * @return string
	 */
	protected function _create_excerpt( $content = '' ) {
		$cut            = false;
		$excerpt_more   = apply_filters( 'excerpt_more', ' [&hellip;]' );
		$excerpt_length = (int) apply_filters( 'excerpt_length', 55 );
		$content        = self::_adjust_content( $content );
		$texts          = preg_grep( '#(<[^>]+>)|(<\/[^>]+>)#s', $content, PREG_GREP_INVERT );
		$total_length   = count( preg_split( '//u', implode( '', $texts ), - 1, PREG_SPLIT_NO_EMPTY ) );

		foreach ( $texts as $key => $text ) {
			$text           = preg_split( '//u', $text, - 1, PREG_SPLIT_NO_EMPTY );
			$text           = array_slice( $text, 0, $excerpt_length );
			$excerpt_length = $excerpt_length - count( $text );
			$cut            = $key;

			if ( 0 >= $excerpt_length ) {
				if ( $total_length > $excerpt_length ) {
					$text[] = $excerpt_more;
				}

				$content[ $key ] = $texts[ $key ] = implode( '', $text );
				break;
			}
		}

		if ( false !== $cut ) {
			array_splice( $content, $cut + 1 );
		}

		if ( $strip_all_tags = apply_filters( 'va_excerpt_from_content_strip_all_tags', false ) ) {
			$content = self::_strip_all_tags( $texts, $cut );
		}

		$content = implode( '', apply_filters( 'va_excerpt_from_content_the_content', $content ) );
		$content = balanceTags( $content, true );

		return $content;
	}

	/**
	 * Adjust the content.
	 *
	 * @since VA Excerpt From Content v1.0.0
	 *
	 * @param string $content
	 *
	 * @return array
	 */
	protected function _adjust_content( $content = '' ) {
		$content = capital_P_dangit( $content );
		$content = wptexturize( $content );
		$content = convert_smilies( $content );
		$content = wpautop( $content );
		$content = prepend_attachment( $content );
		$content = wp_make_content_images_responsive( $content );
		$content = strip_shortcodes( $content );
		$content = str_replace( ']]>', ']]&gt;', $content );
		$content = str_replace( array( "\r\n", "\r", "\n" ), "", $content );
		$content = preg_split( '#(<[^>]+>)|(<\/[^>]+>)#s', trim( $content ), - 1, PREG_SPLIT_DELIM_CAPTURE );
		$content = array_diff( $content, array( "\n", '' ) );
		$content = array_values( $content );

		return $content;
	}

	/**
	 * Strip all tags.
	 *
	 * @since VA Excerpt From Content v1.0.0
	 *
	 * @param array $texts
	 * @param int   $cut
	 *
	 * @return array
	 */
	protected function _strip_all_tags( $texts = array(), $cut = 0 ) {
		if ( ! is_array( $texts ) ) {
			return $texts;
		}

		$clean_texts = array( '<p>' );

		foreach ( $texts as $key => $value ) {
			if ( $key <= $cut ) {
				$clean_texts[] = $value;
			}
		}

		return $clean_texts;
	}
}
