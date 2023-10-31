<?php
/**
 * Frontpage Route Definition
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

/**
 * Frontpage router class
 *
 * @subpackage Route
 */
class Frontpage extends Single
{
	/**
	 * Check if is frontpage
	 */
	public function __construct()
	{
		$this->setEnabled( is_front_page() );

		parent::__construct();
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
		return get_the_title();
	}
}
