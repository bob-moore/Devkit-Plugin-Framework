<?php
/**
 * WP Bakery Service Provider
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Providers;

use DevKit\Plugin\Abstracts,
	DevKit\Plugin\Traits;

/**
 * Interact with WPBakery
 *
 * @subpackage Providers
 */
class Elementor extends Abstracts\Provider
{
	use Traits\EnvironmentHandler;

	/**
	 * Instance constructor
	 *
	 * Ensure the WPBakery is active before enabling.
	 */
	public function __construct()
	{
		$this->setEnabled( $this->isPluginActive( 'elementor/Elementor.php' ) );

		if ( false === $this->isEnabled() ) {
			parent::__construct();
		}
	}
}
