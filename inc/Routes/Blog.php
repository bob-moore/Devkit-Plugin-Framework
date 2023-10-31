<?php
/**
 * Blog Route Definition
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

use DevKit\Plugin\Abstracts,
	DevKit\Plugin\Services;

/**
 * Blog router class
 *
 * @subpackage Route
 */
class Blog extends Archive
{
    public function __construct()
    {
        $this->setEnabled( is_home() );
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
		$blog_id = get_option( 'page_for_posts' );

		if ( $blog_id ) {
			$title = get_the_title( $blog_id );
		}
		
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
