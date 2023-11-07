<?php
/**
 * Loadable definition file
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-cornerstone
 * @since   1.0.0
 */

namespace MWF\Plugin\Abstracts;

use MWF\Plugin\Interfaces;

use DI\Attribute\Inject;

/**
 * Abstract Loadable class
 *
 * @subpackage Abstracts
 */
abstract class Loadable implements Interfaces\Loadable
{
	/**
	 * Name of class converted to usable slug
	 *
	 * Fully qualified class name, converted to lowercase with forward slashes
	 *
	 * @var string
	 */
	protected string $slug = '';
	/**
	 * Package this service belongs to
	 *
	 * $package defines a group of classes used together. For instance, classes
	 * outside of this plugin can extend this class, as part of a theme package.
	 *
	 * @var string
	 */
	protected string $package = '';
	/**
	 * Default constructor
	 *
	 * If this is the first instance, load actions & filters
	 */
	public function __construct()
	{
		$this->slug = strtolower( str_replace( '\\', '_', static::class ) );
	}
	/**
	 * Setter for package field
	 *
	 * @param string $package : name of package this class belongs to.
	 *
	 * @return void
	 */
	#[Inject]
	public function setPackage( #[Inject( 'app.package' )] string $package ): void
	{
		$this->package = trim( $package );
	}
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * Depends on not having previously performed the load action
	 *
	 * @return void
	 */
	#[Inject]
	public function load(): void
	{
		if ( ! $this->hasLoaded() ) {
			$this->onLoad();
			do_action( "{$this->slug}_onload" );
		}
	}
	/**
	 * Check if loading action has already fired
	 *
	 * @return int
	 */
	public function hasLoaded(): int
	{
		return did_action( "{$this->slug}_onload" );
	}
	/**
	 * Perform all functionality required to run when a class loads
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
	}
}
