<?php
/**
 * Directory Handler definition
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

use DI\Attribute\Inject;

use MWF\Plugin\Interfaces;

/**
 * Directory Handler Trait
 *
 * Allows classes that use this trait to work with directory helpers
 *
 * @subpackage Traits
 */
trait DirectoryHandler
{
	/**
	 * Directory path to plugin instance
	 *
	 * @var string
	 */
	protected string $dir = '';
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
	#[Inject]
	public function setDir( #[Inject( 'app.dir' )] string $root, string $append = '' ): void
	{
			$this->dir = $this->appendDir( $root, $append );
	}
	/**
	 * Get the directory path with string appended
	 *
	 * @param string $append : string to append to the directory path.
	 *
	 * @return string complete url
	 */
	public function dir( string $append = '' ): string
	{
		return $this->appendDir( $this->dir, $append );
	}
	/**
	 * Append string safely to end of a Directory
	 *
	 * @param string $base : the base directory path.
	 * @param string $append : the string to append.
	 *
	 * @return string
	 */
	protected function appendDir( string $base, string $append = '' ): string
	{
		return ! empty( $append )
			? untrailingslashit( trailingslashit( $base ) . ltrim( $append, '/' ) )
			: untrailingslashit( $base );
	}
}
