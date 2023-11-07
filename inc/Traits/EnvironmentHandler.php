<?php
/**
 * Environment Handler definition
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Traits;

/**
 * Environment Handler Trait
 *
 * Allows classes that use this trait to work with environment helpers
 *
 * @subpackage Traits
 */
trait EnvironmentHandler
{
	/**
	 * Environment Type
	 *
	 * @var string
	 */
	protected string $env;
	/**
	 * Set the environment type
	 *
	 * @return void
	 */
	public function setEnvironment(): void
	{
		switch ( true ) {
			case in_array( wp_get_environment_type(), [ 'development', 'local', 'testing' ] ):
				$this->env = 'dev';
				break;
			case defined( 'WP_DEBUG' ) && WP_DEBUG:
				$this->env = 'debugging';
				break;
			default:
				$this->env = 'production';
				break;
		}
	}
	/**
	 * Quickly check if in dev environment
	 *
	 * @return bool
	 */
	public function isDev(): bool
	{
		if ( ! isset( $this->env ) ) {
			$this->setEnvironment();
		}
		return 'env' === $this->env;
	}
	/**
	 * Check if a particular plugin is active and present in the environment
	 *
	 * @param string $plugin : dir/name.php of the plugin to check.
	 *
	 * @return bool
	 */
	public function isPluginActive( string $plugin ): bool
	{
		if ( ! defined( 'ABSPATH' ) || ! defined( 'WP_PLUGIN_DIR' ) ) {
			return false;
		}

		include_once ABSPATH . 'wp-admin/includes/plugin.php';

		return is_file( WP_PLUGIN_DIR . '/' . $plugin ) && is_plugin_active( $plugin );
	}
}
