<?php
/**
 * Post Type Entities
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Entities;

use DevKit\Plugin\Abstracts,
	Timber\PostQuery;

/**
 * Class for defining and interacting with post types
 *
 * @subpackage Entities
 */
class Posts extends Abstracts\Service
{
	/**
	 * Get post type definitions
	 *
	 * @return array<string, mixed>
	 */
	protected function postTypes(): array
	{
		return [];
	}
	/**
	 * Register post types with WP
	 *
	 * @return void
	 */
	public function registerPostTypes(): void
	{
		foreach ( $this->postTypes() as $post_type => $args ) {
			register_post_type( $post_type, $args );
		}
	}
	/**
	 * Return an iterable of Timber\Posts
	 *
	 * @param array<string, mixed> $args : get_post args to query Timber posts.
	 *
	 * @return PostQuery
	 */
	public function getPosts( array $args = [] ): PostQuery
	{
		return new PostQuery( $args );
	}
}
