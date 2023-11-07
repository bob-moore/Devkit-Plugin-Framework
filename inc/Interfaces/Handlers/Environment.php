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

namespace MWF\Plugin\Interfaces\Handlers;

/**
 * Environment Handler Trait
 *
 * Allows classes that use this trait to work with environment helpers
 *
 * @subpackage Traits
 */
Interface Environment
{
	/**
	 * Set the environment type
	 *
	 * @return void
	 */
	public function setEnvironment(): void;
	/**
	 * Quickly check if in dev environment
	 *
	 * @return bool
	 */
	public function isDev(): bool;
	/**
	 * Check if a particular plugin is active and present in the environment
	 *
	 * @param string $plugin : dir/name.php of the plugin to check.
	 *
	 * @return bool
	 */
	public function isPluginActive( string $plugin ): bool;
}
