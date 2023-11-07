<?php
/**
 * WP Bakery Service Provider
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Providers;

use MWF\Plugin\Abstracts,
	MWF\Plugin\Traits;

/**
 * Interact with WPBakery
 *
 * @subpackage Providers
 */
class WPBakery extends Abstracts\Provider
{
	use Traits\EnvironmentHandler;

	/**
	 * Instance constructor
	 *
	 * Ensure the WPBakery is active before enabling.
	 */
	public function __construct()
	{
		$this->setEnabled( $this->isPluginActive( 'wp-bakery/wp-bakery.php' ) );

		if ( false === $this->isEnabled() ) {
			parent::__construct();
		}
	}
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_filter( 'vc_raw_html_module_content', [ $this, 'rawHtmlContent' ] );
	}
	/**
	 * Undocumented function
	 *
	 * @param string $content : the content to be processed.
	 *
	 * @return string
	 */
	public function rawHtmlContent( string $content ): string
	{
		return apply_filters( "{$this->package}_compile_string", $content );
	}
}
