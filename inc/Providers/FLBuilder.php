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
class FLBuilder extends Abstracts\Provider
{
	use Traits\EnvironmentHandler;

	/**
	 * Instance constructor
	 *
	 * Ensure the WPBakery is active before enabling.
	 */
	public function __construct()
	{
		$this->setEnabled( $this->isPluginActive( 'bb-builder/bb-builder.php' ) );

		if ( false === $this->isEnabled() ) {
			parent::__construct();
		}
	}
}
