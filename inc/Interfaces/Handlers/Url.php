<?php
/**
 * URL Handler definition
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Interfaces\Handlers;

/**
 * URL Handler Trait
 *
 * Allows classes that use this trait to work with URL helpers
 *
 * @subpackage Interfaces/Handlers
 */
interface Url
{
	/**
	 * Set the base URL
	 * Can include an additional string for appending to the URL of the plugin
	 *
	 * @param string|null $root : root directory to use, default plugin root.
	 * @param string      $append : string to append to base URL.
	 *
	 * @return void
	 */
	public function setUrl( $root = null, string $append = '' ): void;
	/**
	 * Get the url with string appended
	 *
	 * @param string $append : string to append to the URL.
	 *
	 * @return string complete url
	 */
	public function url( string $append = '' ): string;
}