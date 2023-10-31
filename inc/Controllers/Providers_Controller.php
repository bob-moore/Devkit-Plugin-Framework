<?php
/**
 * Provider Controller
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Controller;

use DevKit\Plugin\DI\ContainerBuilder,
	DevKit\Plugin\Providers,
	DevKit\Plugin\Abstracts;

/**
 * Prover controller class
 *
 * Controls execution of provider services, including any interaction with 3rd
 * party plugins, themes, or other packages that provide functionality.
 *
 * @subpackage Controllers
 */
class Providers_Controller extends Abstracts\Controller
{
	/**
	 * Constructor for new instances
	 *
	 * @param Providers\WPBakery $wpbakery_handler : WPBakery provider instance.
	 */
	public function __construct(
		protected Providers\WPBakery $wpbakery_handler
	)
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
			WPBakery::class => ContainerBuilder::autowire(),
		];
	}
}
