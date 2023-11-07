<?php
/**
 * Route Controller
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-cornerstone
 * @since   1.0.0
 */

namespace MWF\Plugin\Controllers;

use MWF\Plugin\DI\ContainerBuilder,
	MWF\Plugin\Abstracts,
	MWF\Plugin\Interfaces,
	MWF\Plugin\Routes as Route;

/**
 * Control functions related to routing
 *
 * @subpackage Controllers
 */
class Routes
extends Abstracts\Controller
{
	/**
	 * Construct new instance of the controller
	 *
	 * @param Interfaces\Services\Router $router : Instance of Services Router.
	 */
	public function __construct( protected Interfaces\Services\Router $router )
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
			Route\Frontend::class  => ContainerBuilder::autowire(),
			Route\Admin::class     => ContainerBuilder::autowire(),
			Route\Login::class     => ContainerBuilder::autowire(),
			Route\Single::class    => ContainerBuilder::autowire(),
			Route\Frontpage::class => ContainerBuilder::autowire(),
			Route\Archive::class   => ContainerBuilder::autowire(),
			Route\Blog::class      => ContainerBuilder::autowire(),
			Route\Search::class    => ContainerBuilder::autowire(),
			Route\Error404::class  => ContainerBuilder::autowire(),
			'route.frontend'       => ContainerBuilder::get( Route\Frontend::class ),
			'route.admin'          => ContainerBuilder::get( Route\Admin::class ),
			'route.login'          => ContainerBuilder::get( Route\Login::class ),
			'route.single'         => ContainerBuilder::get( Route\Single::class ),
			'route.frontpage'      => ContainerBuilder::get( Route\Frontpage::class ),
			'route.archive'        => ContainerBuilder::get( Route\Archive::class ),
			'route.blog'           => ContainerBuilder::get( Route\Blog::class ),
			'route.search'         => ContainerBuilder::get( Route\Search::class ),
			'route.404'            => ContainerBuilder::get( Route\Error404::class ),
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
	 * Load route specific classes
	 *
	 * @return void
	 */
	public function loadRoute(): void
	{
		foreach ( $this->router->getRoutes() as $route ) {
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
