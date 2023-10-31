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

namespace DevKit\Plugin\Services;

use DevKit\Plugin\Abstracts,
	DevKit\Plugin\Interfaces;

/**
 * Service class for router actions
 *
 * @subpackage Services
 */
class Router 
extends Abstracts\Service
implements Interfaces\Handlers\Routes
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
}
