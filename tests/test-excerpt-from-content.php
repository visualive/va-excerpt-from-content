<?php
/**
 * Class VisuAlive_ExcerptFromContentTest
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
class VisuAlive_ExcerptFromContentTest extends WP_UnitTestCase {

	function setUp() {
		parent::setUp();
	}

	private function get_sample_content() {
		$content = <<<EOD
<ins datetime="2016-06-03T17:57:12+00:00">親譲りの無鉄砲で
小供の時から損ばかりしている</ins>。

小学校に居る時分学校の二階から飛び降りて一週間ほど腰を抜かした事がある。

<del datetime="2016-06-03T17:54:38+00:00">なぜそんな無闇をしたと聞く人があるかも知れぬ。</del>別段深い理由でもない。新築の二階から首を出していたら、同級生の一人が冗談に、いくら威張っても、そこから飛び降りる事は出来まい。弱虫やーい。と囃したからである。小使に負ぶさって帰って来た時、おやじが大きな眼をして二階ぐらいから飛び降りて腰を抜かす奴があるかと云ったから、この次は抜かさずに飛んで見せますと答えた。（青空文庫より）

なぜそんな無闇をしたと聞く人があるかも知れぬ。別段深い理由でもない。新築の二階から首を出していたら、同級生の一人が冗談に、いくら威張っても、そこから飛び降りる事は出来まい。弱虫やーい。と囃したからである。小使に負ぶさって帰って来た時、おやじが大きな眼をして二階ぐらいから飛び降りて腰を抜かす奴があるかと云ったから、この次は抜かさずに飛んで見せますと答えた。（青空文庫より）
EOD;
		return $content;
	}

	private function create_testpostdata() {
		$args    = array(
			'post_title'   => '自動抜粋のテスト',
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

		$this->expectOutputString( '<p><ins datetime="2016-06-03T17:57:12+00:00">親譲りの無鉄砲で<br />小供の時から損ばかりしている</ins>。</p><p>小学校に居る時分学校の二階から飛び降りて一週間ほど腰を抜かした事 &hellip; <a href="' . get_the_permalink() . '" class="more-link">Continue reading<span class="screen-reader-text"> "' . get_the_title() . '"</span></a></p>' );
		the_content();
	}

	/**
	 * @test
	 * [Test] excerpt from content for single.
	 */
	function test_excerpt_from_content_for_is_single() {

		global $post;

		$post_data = $this->create_testpostdata();

		$this->go_to( get_permalink( $post_data ) );
		$post = $post_data;
		setup_postdata( $post );

		$this->expectOutputString( wpautop( $this->get_sample_content() ) );
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
		$this->expectOutputString( '<p>親譲りの無鉄砲で小供の時から損ばかりしている。小学校に居る時分学校の二階から飛び降りて一週間ほど腰を抜かした事 &hellip; <a href="' . get_the_permalink() . '" class="more-link">Continue reading<span class="screen-reader-text"> "' . get_the_title() . '"</span></a></p>' );
		the_content();
	}

	/**
	 * @test
	 * test for Singleton.
	 */
	public function test_for_singleton() {
		$obj1 = VisuAlive_ExcerptFromContent::init();
		$obj2 = VisuAlive_ExcerptFromContent::init();

		$this->assertSame( $obj1, $obj2 );
	}
}

