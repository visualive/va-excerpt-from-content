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

		global $post, $wp_query;

		$this->go_to( home_url() );

		$content = <<<EOD
<ins datetime="2016-06-03T17:57:12+00:00">親譲りの無鉄砲で
小供の時から損ばかりしている</ins>。

小学校に居る時分学校の二階から飛び降りて一週間ほど腰を抜かした事がある。

<del datetime="2016-06-03T17:54:38+00:00">なぜそんな無闇をしたと聞く人があるかも知れぬ。</del>別段深い理由でもない。新築の二階から首を出していたら、同級生の一人が冗談に、いくら威張っても、そこから飛び降りる事は出来まい。弱虫やーい。と囃したからである。小使に負ぶさって帰って来た時、おやじが大きな眼をして二階ぐらいから飛び降りて腰を抜かす奴があるかと云ったから、この次は抜かさずに飛んで見せますと答えた。（青空文庫より）

なぜそんな無闇をしたと聞く人があるかも知れぬ。別段深い理由でもない。新築の二階から首を出していたら、同級生の一人が冗談に、いくら威張っても、そこから飛び降りる事は出来まい。弱虫やーい。と囃したからである。小使に負ぶさって帰って来た時、おやじが大きな眼をして二階ぐらいから飛び降りて腰を抜かす奴があるかと云ったから、この次は抜かさずに飛んで見せますと答えた。（青空文庫より）
EOD;
		$args    = [
			'post_title'   => '自動抜粋のテスト',
			'post_content' => $content,
			'post_status'  => 'publish',
			'post_date'    => '2016-06-01 00:00:00',
		];
		$post_id = $this->factory->post->create( $args );
		$post    = get_post( $post_id );

		setup_postdata( $post );
	}

	/**
	 * [Test] excerpt from content.
	 */
	function test_excerpt_from_content() {
		$this->expectOutputString( '<p><ins datetime="2016-06-03T17:57:12+00:00">親譲りの無鉄砲で<br />小供の時から損ばかりしている</ins>。</p><p>小学校に居る時分学校の二階から飛び降りて一週間ほど腰を抜かした事 &hellip; <a href="http://example.org/?p=3" class="more-link">Continue reading<span class="screen-reader-text"> "自動抜粋のテスト"</span></a></p>' );
		the_content();
	}

	/**
	 * [Test][Filter] strip all tags.
	 */
	function test_excerpt_strip_all_tags() {
		add_filter( 'va_excerpt_from_content_strip_all_tags', '__return_true' );
		$this->expectOutputString( '<p>親譲りの無鉄砲で小供の時から損ばかりしている。小学校に居る時分学校の二階から飛び降りて一週間ほど腰を抜かした事 &hellip; <a href="http://example.org/?p=4" class="more-link">Continue reading<span class="screen-reader-text"> "自動抜粋のテスト"</span></a></p>' );
		the_content();
	}
}

