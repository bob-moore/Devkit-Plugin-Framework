<?php
/**
 * Main plugin handler
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 0.0.1
 */

namespace DevKit\Plugin;

/**
 * Plugin Class
 *
 * Creates service container, and kicks off execution of all plugin controllers.
 *
 * @subpackage Traits
 */
class Plugin extends Abstracts\App
{
	use Traits\UrlHandler;
	use Traits\DirectoryHandler;

	/**
	 * Constructor for new instance of plugin
	 *
	 * @param string $root : path to root file of the plugin.
	 * @param string $package : name of the package this instance belongs to.
	 */
	public function __construct( string $root = '', string $package = '' )
	{
		$this->setDir( plugin_dir_path( $root ) );

		$this->setUrl( plugin_dir_url( $root ) );

		$this->app_definitions = [
			'app.url'     => $this->url,
			'app.dir'     => $this->dir,
			'assets.dir'  => "dist",
		];

		parent::__construct( $package );
	}
	/**
	 * Get definitions that should be added to the service container
	 *
	 * @return array<string, mixed>
	 */
	public static function getServiceDefinitions(): array
	{
		return array_merge(
			[
				Services\Controller::class   => ContainerBuilder::autowire(),
				Providers\Controller::class  => ContainerBuilder::autowire(),
				Entities\Controller::class   => ContainerBuilder::autowire(),
				Routes\Controller::class     => ContainerBuilder::autowire(),
				Middleware\Controller::class => ContainerBuilder::autowire(),
			],
			Services\Controller::getServiceDefinitions(),
			Providers\Controller::getServiceDefinitions(),
			Entities\Controller::getServiceDefinitions(),
			Routes\Controller::getServiceDefinitions(),
			Middleware\Controller::getServiceDefinitions(),
		);
	}
	/**
	 * Instantiate controllers
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		parent::onLoad();
        /**
         * Generic actions/filters
         */
        add_filter( 'admin_email_check_interval', '__return_false' );
        /**
         * Load controllers
         */
		$this->service_container->get( Services\Controller::class );
		$this->service_container->get( Providers\Controller::class );
		$this->service_container->get( Entities\Controller::class );
		$this->service_container->get( Routes\Controller::class );
	}
}
