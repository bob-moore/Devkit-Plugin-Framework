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

namespace MWF\Plugin\Services;

use MWF\Plugin\Abstracts,
	MWF\Plugin\Interfaces;

/**
 * Service class for router actions
 *
 * @subpackage Services
 */
class Router 
extends Abstracts\Service
implements Interfaces\Services\Router
{
	/**
	 * Routes available on current context
	 *
	 * @var array<int, string>
	 */
	protected array $routes = [];
	/**
	 * Define current route(s)
	 *
	 * Can't be run until 'wp' action when the query is available
	 *
	 * @return array<int, string>
	 */
	protected function defineRoutes(): array
	{
		switch ( true ) {
			case is_front_page() && ! is_home():
				$routes = [ 'single', 'frontpage' ];
				break;
			case is_home():
				$routes = [ 'archive', 'blog' ];
				break;
			case is_search():
				$routes = [ 'archive', 'search' ];
				break;
			case is_archive():
				$routes = [ 'archive' ];
				break;
			case is_singular():
				$routes = [ 'single' ];
				break;
			case is_404():
				$routes = [ '404' ];
				break;
            case is_login():
                $routes = [ 'login' ];
                break;
            case is_admin():
                $routes = [ 'admin' ];
                break;
			default:
				$routes = [];
				break;
		}
		return array_reverse( apply_filters( "{$this->package}_routes", $routes ) );
	}
	/**
	 * Getter for views
	 *
	 * @return array<int, string>
	 */
	public function getRoutes(): array
	{
		if ( empty( $this->routes ) ) {
			$this->routes = $this->defineRoutes();
		}
		return $this->routes;
	}
	/**
	 * Get routes via filter
	 *
	 * @param string|array<string> $default_routes : routes to prepend to the list
	 *
	 * @return array
	 */
	public function getRoutesByFilter( string|array $default_routes = [] ): array
	{
		$routes = $this->getRoutes();

		switch ( true ) {
			case is_array( $default_routes ):
				$routes = array_merge( $default_routes, $routes );
				break;
			case is_string( $default_routes ) && ! empty( $default_routes ):
				array_unshift( $routes, $default_routes );
				break;
			default:
				break;
		}
		return $routes;
	}
	/**
	 * Setter for $route
	 *
	 * @return void
	 */
	public function loadRoute(): void
	{
		foreach ( $this->getRoutes() as $route ) {
			$alias = 'route.' . strtolower( $route );

			$has_route = apply_filters( "{$this->package}_has_route", false, $alias );

			if ( ! $this->routeHasLoaded() && $has_route ) {
				do_action( "{$this->package}_load_route", $alias, $route );
			}

			do_action( "{$this->package}_route_{$route}", $alias );
		}
	}
	/**
	 * Determine if a route has already been loaded
	 *
	 * @return boolean
	 */
	public function routeHasLoaded() : bool
	{
		return did_action( "{$this->package}_load_route" );
	}
}
