<?php
/**
 * 404 Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Routes;

use DevKit\Plugin\Abstracts;

/**
 * 404 router class
 *
 * @subpackage Route
 */
class Error404 extends Frontend
{
	/**
	 * Check if is singular
	 */
	public function __construct()
	{
		$this->setEnabled( is_404() );

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
		$title = __( '404 Not Found' );
		return $title;
	}
}
