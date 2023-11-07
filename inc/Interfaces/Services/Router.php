<?php
/**
 * Router Service Definition
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Interfaces\Services;

/**
 * Service class for router actions
 *
 * @subpackage Services
 */
interface Router
{
	/**
	 * Getter for views
	 *
	 * @return array<int, string>
	 */
	public function getRoutes(): array;
	/**
	 * Load route specific functionality
	 *
	 * @return void
	 */
	public function loadRoute(): void;
}
