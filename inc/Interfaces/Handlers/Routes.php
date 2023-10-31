<?php
/**
 * Router Service Definition
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
 * Service class for router actions
 *
 * @subpackage Services
 */
interface Routes
{
	/**
	 * Getter for views
	 *
	 * @return array<int, string>
	 */
	public function getRoutes(): array;
}
