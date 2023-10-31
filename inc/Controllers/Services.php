<?php
/**
 * Service Controller
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

use DevKit\Plugin\DI\ContainerBuilder,
	DevKit\Plugin\Abstracts;

/**
 * Service controller class
 *
 * Controls and orchestrates the execution of any plugin services.
 *
 * @subpackage Controllers
 */
class Services extends Abstracts\Controller
{
	/**
	 * Constructor for new instances
	 *
	 * @param Compiler $compiler Compiler service instance.
	 */
	public function __construct(
		protected Compiler $compiler
	) {
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
			Assets::class   => ContainerBuilder::autowire()
				->constructor(
					asset_dir : ContainerBuilder::get( 'assets.dir' ),
					app_dir   : ContainerBuilder::get( 'app.dir' ),
                    app_url   : ContainerBuilder::get( 'app.url' )
				),
			Router::class   => ContainerBuilder::autowire(),
			Compiler::class => ContainerBuilder::autowire()
				->constructor(
					dir : ContainerBuilder::get( 'app.dir' )
				),
		];
	}
	/**
	 * Actions to perform when the class is loaded
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_filter( 'timber/twig', [ $this->compiler, 'loadFunctions' ] );
		add_filter( 'timber/twig', [ $this->compiler, 'loadFilters' ] );
		add_filter( 'timber/locations', [ $this->compiler, 'templateLocations' ] );

		$this->compiler->addFunction( 'has_action', 'has_action' );
		$this->compiler->addFunction( 'do_action', 'do_action' );
		$this->compiler->addFunction( 'apply_filters', 'apply_filters' );
		$this->compiler->addFunction( 'get_terms', 'get_terms' );
		$this->compiler->addFunction( 'get_posts', [ $this->compiler, 'getPosts' ] );
		$this->compiler->addFunction(
			'do_function',
			[ $this->compiler, 'doFunction' ],
			[ 'is_variadic' => true ]
		);
	}
}
