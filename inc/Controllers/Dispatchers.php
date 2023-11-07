<?php
/**
 * Dispatcher Controller
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Controllers;

use MWF\Plugin\DI\ContainerBuilder,
	MWF\Plugin\Dispatchers as Dispatcher,
	MWF\Plugin\Interfaces,
	MWF\Plugin\Abstracts;

/**
 * Controls the registration and execution of dispatcher services
 *
 * @subpackage Controllers
 */
class Dispatchers
extends Abstracts\Controller
{
	/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return [
			/**
			 * Class Aliases
			 */
			Dispatcher\Styles::class => ContainerBuilder::autowire(),
			Dispatcher\Scripts::class => ContainerBuilder::autowire(),
			/**
			 * Interfaces
			 */
			Interfaces\Dispatchers\Styles::class => ContainerBuilder::get( Dispatcher\Styles::class ),
			Interfaces\Dispatchers\Scripts::class => ContainerBuilder::get( Dispatcher\Scripts::class ),

		];
	}
}
