<?php
/**
 * Middleware for `view`
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Middleware;

use DevKit\Plugin\Abstracts;

/**
 * View middleware provides an interface between Timber and various filters
 *
 * @subpackage Middleware
 */
class View extends Abstracts\Handler
{
	/**
	 * Default function that is called in the absence of an explicitly defined
	 * filter
	 *
	 * @param string       $filter : name of function a template tried to call.
	 * @param array<mixed> $args : mixed array of passed arguments.
	 *
	 * @return mixed result of running filter, default is empty string
	 */
	public function __call( string $filter, array $args ): mixed
	{
		$function = array_shift( $args );

		return apply_filters( "{$this->package}_{$filter}", '', ...$args );
	}
	/**
	 * Get the title for a view
	 *
	 * @param string|null $title : default title to return.
	 *
	 * @return string
	 */
	public function title( $title = null ): string
	{
		return apply_filters(
			"{$this->package}_compile_string",
			apply_filters( "{$this->package}_view_title", $title ?? get_the_title() ),
			[]
		);
	}
	/**
	 * Get the description for a view
	 *
	 * @param string $description : default description to return.
	 *
	 * @return string
	 */
	public function description( string $description = '' ): string
	{
		return apply_filters(
			'mwf_enhancements_compile_string',
			apply_filters( 'mwf_enhancements_view_description', $description ),
			[]
		);
	}
}
