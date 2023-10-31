<?php
/**
 * Handler definition file
 *
 * Handlers are the most generic type most classes inherit from
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/Devkit-Plugin-Framework
 * @since   1.0.0
 */

namespace DevKit\Plugin\Abstracts;

use DevKit\Plugin\Interfaces;

/**
 * Abstract Handler class
 *
 * @subpackage Abstracts
 */
abstract class Handler implements Interfaces\Handler
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

		add_action( "{$this->slug}_load", [ $this, 'onLoad' ], 5 );
	}
	/**
	 * Setter for package field
	 *
	 * @param string $package : name of package this class belongs to.
	 *
	 * @return void
	 */
	public function setPackage( string $package ): void
	{
		$this->package = trim( $package );
	}
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * Depends on not having previously performed the same action
	 *
	 * @return void
	 */
	public function load(): void
	{
		if ( ! $this->hasLoaded() ) {
			do_action( "{$this->slug}_load" );
		}
	}
	/**
	 * Check if loading action has already fired
	 *
	 * @return int
	 */
	public function hasLoaded(): int
	{
		return did_action( "{$this->slug}_load" );
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
