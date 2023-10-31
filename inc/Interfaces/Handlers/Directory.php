<?php
/**
 * Directory Handler definition
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
 * Directory Handler Trait
 *
 * Allows classes that use this trait to work with directory helpers
 *
 * @subpackage interfaces/handlers
 */
interface Directory
{
	/**
	 * Set the base directory - relative to the main plugin file
	 *
	 * Can include an additional string, to make it relative to a different file
	 *
	 * @param string|null $root : root path of the plugin.
	 * @param string      $append : string to append to base directory path.
	 *
	 * @return void
	 */
	public function setDir( $root = null, string $append = '' ): void;
	/**
	 * Get the directory path with string appended
	 *
	 * @param string $append : string to append to the directory path.
	 *
	 * @return string complete url
	 */
	public function dir( string $append = '' ): string;
}