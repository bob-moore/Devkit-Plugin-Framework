<?php
/**
 * Route Controller
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/Devkit-Plugin-Framework
 * @since   1.0.0
 */

namespace DevKit\Plugin\Routes;

use DevKit\Plugin\DI\ContainerBuilder,
	DevKit\Plugin\Abstracts,
	DevKit\Plugin\Interfaces,
	DevKit\Plugin\Services;

/**
 * Control functions related to routing
 *
 * @subpackage Controllers
 */
class Route_Controller 
extends Abstracts\Controller
{
	/**
	 * Construct new instance of the controller
	 *
	 * @param Services\Router $route_handler : Instance of Services Router.
	 */
	public function __construct( protected Interfaces\Handlers\Routes $route_handler )
	{
		parent::__construct();
	}
		/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return [
			Frontend::class   => ContainerBuilder::autowire(),
			Admin::class      => ContainerBuilder::autowire(),
			Login::class      => ContainerBuilder::autowire(),
			Single::class     => ContainerBuilder::autowire(),
			Frontpage::class  => ContainerBuilder::autowire(),
			Archive::class    => ContainerBuilder::autowire(),
			Blog::class       => ContainerBuilder::autowire(),
			Search::class     => ContainerBuilder::autowire(),
			Error404::class   => ContainerBuilder::autowire(),
			'route.frontend'  => ContainerBuilder::get( Frontend::class ),
			'route.admin'     => ContainerBuilder::get( Admin::class ),
			'route.login'     => ContainerBuilder::get( Login::class ),
			'route.single'    => ContainerBuilder::get( Single::class ),
			'route.frontpage' => ContainerBuilder::get( Frontpage::class ),
			'route.archive'   => ContainerBuilder::get( Archive::class ),
			'route.blog'      => ContainerBuilder::get( Blog::class ),
			'route.search'    => ContainerBuilder::get( Search::class ),
			'route.404'       => ContainerBuilder::get( Error404::class ),
		];
	}
	/**
	 * Actions to perform when the class is loaded
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_action( 'wp', [ $this, 'loadRoute' ] );
		add_action( 'admin_init', [ $this, 'loadRoute' ] );
		add_action( 'login_init', [ $this, 'loadRoute' ] );
	}
	/**
	 * Setter for $route
	 *
	 * @return void
	 */
	public function loadRoute(): void
	{
		foreach ( $this->route_handler->getRoutes() as $route ) {
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
