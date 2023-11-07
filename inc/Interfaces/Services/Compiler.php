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

use Twig\Environment;

/**
 * Service class for router actions
 *
 * @subpackage Services
 */
interface Compiler
{
	/**
	 * Filters the default locations array for twig to search for templates. We never use some paths, so there's
	 * no reason to waste overhead looking for templates there.
	 *
	 * @param array<int, string> $locations : Array of absolute paths to
	 *                                        available templates.
	 *
	 * @return array<int, string> $locations
	 */
	public function templateLocations( array $locations ): array;
    /**
	 * Register custom function with TWIG
	 *
	 * @param Environment $twig : instance of twig environment.
	 *
	 * @return Environment
	 */
	public function loadFunctions( Environment $twig ): Environment;
	/**
	 * Register custom filters with TWIG
	 *
	 * @param Environment $twig : instance of twig environment.
	 *
	 * @return Environment
	 */
	public function loadFilters( Environment $twig ): Environment;
}
