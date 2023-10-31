<?php
/**
 * Middleware controller
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Controllers;

use DevKit\Plugin\DI\ContainerBuilder,
	DevKit\Plugin\Middleware,
	DevKit\Plugin\Abstracts;

/**
 * Middleware controller class
 * 
 * Controls when and where middleware gets injected
 *
 * @subpackage Middleware
 */
class Middleware_Controller extends Abstracts\Controller
{
	/**
	 * Construct new instance
	 * 
	 * Defines required injected classes
	 *
	 * @param View $view_handler : handler to inject view into timber context.
	 */
	public function __construct(
		protected Middleware\View $view_handler
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
			View::class => ContainerBuilder::autowire(),
		];
	}
	/**
	 * Actions to perform when the class is loaded
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_filter( 'timber/context', [ $this, 'injectContext' ] );
	}
	/**
	 * Inject middleware into Timber context
	 *
	 * @param array<string, mixed> $context : timber context.
	 *
	 * @return array<string, mixed>
	 */
	public function injectContext( array $context ) : array
	{
		$context['view'] = $this->view_handler;

		return $context;
	}
}
