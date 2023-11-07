<?php
/**
 * Loadable interface
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Interfaces;

/**
 * Define requirements for any loadable class
 *
 * @subpackage Controllers
 */
interface Loadable
{
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * @return void
	 */
	public function load(): void;
	/**
	 * Perform all functionality required to run when a class loads
	 *
	 * @return void
	 */
	public function onLoad(): void;
	/**
	 * Check if loading action has already fired
	 *
	 * @return int
	 */
	public function hasLoaded(): int;
	/**
	 * Set the name of the package this class belongs to
	 *
	 * @param string $package : string name of the package.
	 *
	 * @return void
	 */
	public function setPackage( string $package ): void;
}
