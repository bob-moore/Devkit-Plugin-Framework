<?php
/**
 * Container Builder
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\DI;

use DI\Definition\Helper\AutowireDefinitionHelper,
	DI\Definition\Reference;

/**
 * Builder for Service Containers
 *
 * @subpackage DI
 */
class ContainerBuilder extends \DI\ContainerBuilder
{
	/**
	 * Saved containers for later retrieval
	 *
	 * Used to cache containers, so services can be retrieved without
	 * singletons
	 *
	 * @var array<string, Container>
	 */
	protected static array $containers = [];
	/**
	 * Constructor for new instances
	 *
	 * Sets parent containerClass to DL\Container instead of default
	 */
	public function __construct()
	{
		parent::__construct( Container::class );
	}
	/**
	 * Get a cached service container
	 *
	 * @param string $container_id : name of cached container to retrieve.
	 *
	 * @return Container|null
	 */
	public static function locateContainer( string $container_id )
	{
		return isset( self::$containers[ $container_id ] ) ? self::$containers[ $container_id ] : null;
	}
	/**
	 * Save a service container to the cache
	 *
	 * @param string    $container_id : name of container to reference it by.
	 * @param Container $container : Container instance to cache.
	 *
	 * @return void
	 */
	public static function cacheContainer( string $container_id, Container $container ): void
	{
		self::$containers[ $container_id ] = $container;
	}
	/**
	 * Wrapper for parent autowire function. Only used for simplicity
	 *
	 * @param string $class_name : name of service to autowire.
	 *
	 * @return AutowireDefinitionHelper
	 */
	public static function autowire( string $class_name = null ): AutowireDefinitionHelper
	{
		return \DI\autowire( $class_name );
	}
	/**
	 * Wrapper for parent get function. Only used for simplicity
	 *
	 * @param string $class_name : name of service to retrieve.
	 *
	 * @return Reference
	 */
	public static function get( string $class_name ): Reference
	{
		return \DI\get( $class_name );
	}
}
