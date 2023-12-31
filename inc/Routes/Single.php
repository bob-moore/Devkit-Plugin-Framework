<?php
/**
 * Single Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Routes;

/**
 * Singular router class
 *
 * @subpackage Route
 */
class Single extends Frontend
{
	/**
	 * Check if is singular
	 */
	public function __construct()
	{
		$this->setEnabled( is_singular() );

		parent::__construct();
	}
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_filter( "{$this->package}_view_title", [ $this, 'title' ], 20 );
		add_filter( "{$this->package}_view_description", [ $this, 'description' ], 20 );
	}
	/**
	 * Return the title
	 *
	 * Check custom field for custom title, set in 'edit page'
	 *
	 * @param string $title : string title to display.
	 *
	 * @return string
	 */
	public function title( string $title ): string
	{
		$title = get_the_title();
		return $title;
	}
	/**
	 * Return the description
	 *
	 * @param string $description : string description to display.
	 *
	 * @return string
	 */
	public function description( string $description ): string
	{
		return $description;
	}
}
