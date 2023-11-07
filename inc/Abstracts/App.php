<?php
/**
 * App definition
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-cornerstone
 * @since   1.0.0
 */

namespace MWF\Plugin\Abstracts;

use MWF\Plugin\Interfaces,
    MWF\Plugin\Traits,
    MWF\Plugin\DI\Container,
    MWF\Plugin\DI\ContainerBuilder;

/**
 * App Class
 *
 * Creates service container, and kicks off execution of all plugin controllers.
 *
 * @subpackage Traits
 */
abstract class App extends Service
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
	 * @param string $root : path to root file of the plugin.
	 * @param string $package : name of the package this instance belongs to.
	 */
	public function __construct( string $package = '' )
	{
		$this->setPackage( $package );

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

		$container_builder->addDefinitions( $this->getServiceDefinitions() );

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
	 * @return void
	 */
	protected function getServiceDefinitions() : string|array|\DI\Definition\Source\DefinitionSource
	{
		return [ 'app.package' => $this->package ];
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
        add_filter( "{$this->package}_decorate_service", [ $this, 'decorateServices' ], 5, 2 );
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
		// var_dump($this->service_container->get( $alias ));
		$this->service_container->get( $alias );
	}
    /**
     * Decorate service handlers based on interface and traits
     *
     * @param mixed     $service_handler : the instance being decorated.
     * @param Container $container : instance of the service container.
     *
     * @return mixed
     */
    public function decorateServices( mixed $service_handler, Container $container ) : mixed
    {
        // $interfaces = class_implements( $service_handler );
        /**
         * Decorate instances that implement th UseAssets interface with the asset
         * handler
         */
        // if ( in_array( Interfaces\Uses\Assets::class, $interfaces, true ) ) {
		// 	if ( $container->has( Interfaces\Handlers\Assets::class ) ) {
		// 		$service_handler->setAssetHandler( $container->get( Interfaces\Handlers\Assets::class ) );
		// 	} else {
		// 		$service_handler->setAssetHandler( $container->get( Services\Assets::class ) );	
		// 	}
        // }
        /**
         * Decorate instances that implement the handler interface with package,
         * and load the class
         */
        // if ( in_array( Interfaces\Service::class, $interfaces, true ) ) {
		// 	if ( $container->has( 'app.package' ) ) {
		// 		// $service_handler->setPackage( $container->get( 'app.package' ) );
		// 	}
        //     // $service_handler->load();
        // }
        return $service_handler;
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
