<?php
/**
 * Frontpage Route Definition
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
