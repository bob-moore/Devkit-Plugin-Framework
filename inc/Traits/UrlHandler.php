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

namespace DevKit\Plugin\Traits;

/**
 * URL Handler Trait
 *
 * Allows classes that use this trait to work with URL helpers
 *
 * @subpackage Traits
 */
trait UrlHandler
{
	/**
	 * URL to plugin instance
	 *
	 * @var string
	 */
	protected string $url = '';
	/**
	 * Set the base URL
	 * Can include an additional string for appending to the URL of the plugin
	 *
	 * @param string|null $root : root directory to use, default plugin root.
	 * @param string      $append : string to append to base URL.
	 *
	 * @return void
	 */
	protected function setUrl( $root = null, string $append = '' ): void
	{
			$this->url = $this->appendUrl( $root ?? plugin_dir_url( dirname( __DIR__, 1 ) ), $append );
	}
	/**
	 * Get the url with string appended
	 *
	 * @param string $append : string to append to the URL.
	 *
	 * @return string complete url
	 */
	protected function url( string $append = '' ): string
	{
		return $this->appendUrl( $this->url, $append );
	}
	/**
	 * Append string safely to end of a url
	 *
	 * @param string $base : the base url.
	 * @param string $append : the string to append.
	 *
	 * @return string
	 */
	protected function appendUrl( string $base, string $append = '' ): string
	{
		return ! empty( $append )
			? untrailingslashit( trailingslashit( $base ) . ltrim( $append, '/' ) )
			: untrailingslashit( $base );
	}
}
