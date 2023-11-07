<?php
/**
 * Main plugin handler
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Cornerstone
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin;

use MWF\Plugin\DI\Container,
	MWF\Plugin\DI\ContainerBuilder;

/**
 * Plugin Class
 *
 * Creates service container, and kicks off execution of all plugin controllers.
 *
 * @subpackage Traits
 */
class Plugin extends Abstracts\Loadable
{
	use Traits\UrlHandler;
	use Traits\DirectoryHandler;

	/**
	 * The service container for dependency injections, and locating service
	 * instances
	 *
	 * @var Container
	 */
	protected Container $service_container;
	/**
	 * Constructor for new instance of plugin
	 *
	 * @param string $package : name of the package this instance belongs to.
	 * @param string $root_file : path to root file of the plugin.
	 */
	public function __construct( string $package = '', $root_file = '' )
	{
		/**
		 * Maybe set package
		 */
		if ( ! isset( $this->package ) ) {
			if ( empty( $package ) ) {
				throw new \ValueError( __( 'Package ID is required' ) );
			} else {
				$this->setPackage( $package );
			}
		}
		/**
		 * Maybe set url
		 */
		if ( ! isset( $this->url ) ) {
			if ( empty( $root_file ) ) {
				throw new \ValueError( __( 'Root plugin file required to set URL' ) );
			} else {
				$this->setUrl( plugin_dir_url( $root_file ) );
			}
		}
		/**
		 * Maybe set dir
		 */
		if ( ! isset( $this->dir ) ) {
			if ( empty( $root_file ) ) {
				throw new \ValueError( __( 'Root plugin file required to set DIR' ) );
			} else {
				$this->setDir( plugin_dir_path( $root_file ) );
			}
		}

		$this->service_container = $this->getContainer();

		parent::__construct();
	}
	/**
	 * Set the class package
	 *
	 * @param string $package : name used to reference the current instance.
	 *
	 * @return void
	 */
	public function setPackage( string $package ): void
	{
		if ( ! empty( trim( $package ) ) ) {
			parent::setPackage( $package );
		} elseif ( empty( $this->package ) ) {
			parent::setPackage( str_ireplace( '\\', '_', static::class ) );
		}
	}
	/**
	 * Build the service container
	 * - Instantiate a new container builder
	 * - Add plugin specific definitions
	 * - Get service definitions from controllers
	 *
	 * @return Container
	 */
	protected function buildContainer(): Container
	{
		$container_builder = new ContainerBuilder();

		$container_builder->useAttributes(true);

		$container_builder->addDefinitions(
			apply_filters( 
				"{$this->package}_definitions", 
				$this->getServiceDefinitions()
			)
		);

		$container = $container_builder->build();

		return $container;
	}
	/**
	 * Get container from the cache if available, else instantiate a new one
	 *
	 * Cache is used to give access to the container instead of a singleton
	 *
	 * @return Container
	 */
	protected function getContainer()
	{
		$container = ContainerBuilder::locateContainer( static::class );

		if ( ! $container ) {
			$container = $this->buildContainer();
			ContainerBuilder::cacheContainer( static::class, $container );
		}
		return $container;
	}
	/**
	 * Get service definitons to add to service container
	 *
	 * @return string|array<string, mixed>|\DI\Definition\Source\DefinitionSource
	 */
	protected function getServiceDefinitions() : string|array|\DI\Definition\Source\DefinitionSource
	{
		$definitions = [ 
			'app.package'       => $this->package,
			'app.url'           => $this->url,
			'app.dir'           => $this->dir,
			'app.assets.dir'    => 'dist',
			'app.templates.dir' => 'template-parts',
			Controllers\Dispatchers::class => ContainerBuilder::autowire(),
			Controllers\Routes::class => ContainerBuilder::autowire(),
			Controllers\Services::class => ContainerBuilder::autowire()
		];

		return $definitions;
	}
	/**
	 * Instantiate controllers
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
        /**
         * Package actions/filters
         */
		add_filter( "{$this->package}_has_route", [ $this, 'hasRoute' ], 5, 2 );
        add_action( "{$this->package}_load_route", [ $this, 'loadRoute' ], 5 );

		$this->service_container->get( Controllers\Dispatchers::class );
		$this->service_container->get( Controllers\Routes::class );
		$this->service_container->get( Controllers\Services::class );
	}
	/**
	 * Check if a particular route exists
	 *
	 * @param boolean $has_route : default value.
	 * @param string  $route_alias : name of route to find.
	 *
	 * @return boolean
	 */
	public function hasRoute( bool $has_route, string $route_alias ): bool
	{
		$has_route = $this->service_container->has( $route_alias );
		return $has_route;
	}
	/**
	 * Load a route from the service container
	 *
	 * @param string $alias : name of route to load.
	 *
	 * @return void
	 */
	public function loadRoute( string $alias ): void
	{
		$this->service_container->get( $alias );
	}
	/**
	 * Locate a specific service
	 *
	 * Use primarily by 3rd party interactions to remove actions/filters
	 *
	 * @param string $service : name of service to locate.
	 *
	 * @return mixed
	 */
	public static function locateService( string $service )
	{
		$container = ContainerBuilder::locateContainer( static::class );

		if ( $container ) {
			return $container->get( $service );
		} else {
			return null;
		}
	}
}
