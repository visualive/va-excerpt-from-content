<?php
/**
 * Class VisuAlive_ExcerptFromContentTest_EN
 *
 * @package
 */

/**
 * Test case.
 * Special Thanks! @miya0001
 *
 * @link https://firegoby.jp/archives/5498
 *       https://firegoby.jp/archives/5511
 *       http://qiita.com/tags/wp_unittestcase
 */
require_once dirname( __FILE__ ) . '/test-excerpt-from-content.php';

class VisuAlive_ExcerptFromContentTest_EN extends VisuAlive_ExcerptFromContentTest {
	private function get_sample_content() {
		$content = <<<EOD
<ins datetime="2016-06-03T17:57:12+00:00">Lorem ipsum dolor sit amet,
consectetuer adipiscing elit</ins>. Aenean commodo ligula eget dolor. Aenean massa.

<del datetime="2016-06-03T17:54:38+00:00">Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus.</del> Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem.

Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibu
EOD;
		return $content;
	}

	private function create_testpostdata() {
		$args    = array(
			'post_title'   => 'Test of the auto excerpt !',
			'post_content' => $this->get_sample_content(),
			'post_status'  => 'publish',
			'post_date'    => '2016-06-01 00:00:00',
		);
		$post_id = $this->factory->post->create( $args );

		return get_post( $post_id );
	}

	/**
	 * @test
	 * [Test] excerpt from content.
	 */
	function test_excerpt_from_content_for_is_home() {
		global $post;
		$post_data = $this->create_testpostdata();

		$this->go_to( home_url() );
		$post = $post_data;
		setup_postdata( $post );

		$this->expectOutputString( '<p><ins datetime="2016-06-03T17:57:12+00:00">Lorem ipsum dolor sit amet,<br />consectetuer adipiscing elit &hellip; <a href="' . get_the_permalink() . '" class="more-link">Continue reading<span class="screen-reader-text"> "' . get_the_title() . '"</span></a></ins></p>' );
		the_content();
	}

	/**
	 * @test
	 * [Test][Filter] strip all tags.
	 */
	function test_excerpt_strip_all_tags() {

		global $post;
		$post_data = $this->create_testpostdata();

		$this->go_to( home_url() );
		$post = $post_data;
		setup_postdata( $post );

		add_filter( 'va_excerpt_from_content_strip_all_tags', '__return_true' );
		$this->expectOutputString( '<p>Lorem ipsum dolor sit amet,consectetuer adipiscing elit &hellip; <a href="' . get_the_permalink() . '" class="more-link">Continue reading<span class="screen-reader-text"> "' . get_the_title() . '"</span></a></p>' );
		the_content();
	}
}
