<?php
/**
 * Controller definition file
 *
 * Controllers orchestrate communication between different layers
 * of the plugin
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

/**
 * Abstract controller class
 *
 * @subpackage Abstracts
 */
abstract class Controller 
extends Loadable 
implements Interfaces\Controller
{
	/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return [];
	}
}
