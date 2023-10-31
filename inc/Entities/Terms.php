<?php
/**
 * Term Type Entities
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
	Timber\Timber;

/**
 * Class for defining and interacting with terms & taxonomies
 *
 * @subpackage Entities
 */
class Terms extends Abstracts\Service
{
	/**
	 * Get taxonomy definitions
	 *
	 * @return array<string, mixed>
	 */
	protected function getTaxonomies(): array
	{
		return [];
	}
	/**
	 * Register taxonomies with WP
	 *
	 * @return void
	 */
	public function registerTaxonomies(): void
	{
		foreach ( $this->getTaxonomies() as $tax => $args ) {
			register_taxonomy( $tax, 'devkit-layout', $args );
			register_taxonomy_for_object_type( $tax, 'devkit-layout' );
		}
	}
}
