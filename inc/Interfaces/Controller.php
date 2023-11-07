<?php
/**
 * Controller interface
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
 * Define controller requirements
 *
 * @subpackage Controllers
 */

interface Controller
{
	/**
	 * Undocumented function
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array;
}
