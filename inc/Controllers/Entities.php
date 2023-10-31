<?php
/**
 * Entity controller
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
	DevKit\Plugin\Entities as Entity,
	DevKit\Plugin\Abstracts;

/**
 * Entity controller class
 *
 * Entities include post types, taxonomies, post meta, and any other types of
 * data entities
 *
 * @subpackage Entities
 */
class Entities extends Abstracts\Controller
{
	/**
	 * Constructor for new instances
	 *
	 * @param Entity\Posts   $post_handler : Service class for post types.
	 * @param Entity\Terms   $term_handler : Service class for terms & taxonomies.
	 * @param Entity\Widgets $widget_handler : Service class for widgets.
     * @param Entity\Menus   $menu_handler : Service class for menus.
	 */
	public function __construct(
		protected Entity\Posts $post_handler,
		protected Entity\Terms $term_handler,
		protected Entity\Widgets $widget_handler,
        protected Entity\Menus $menu_handler
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
			Entities\Posts::class   => ContainerBuilder::autowire(),
			Entities\Terms::class   => ContainerBuilder::autowire(),
			Entities\Widgets::class => ContainerBuilder::autowire(),
            Entities\Menus::class   => ContainerBuilder::autowire(),
		];
	}
	/**
	 * Actions to perform when the class is loaded
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_action( 'init', [ $this->post_handler, 'registerPostTypes' ] );
		add_action( 'init', [ $this->term_handler, 'registerTaxonomies' ] );
        add_action( 'widgets_init', [ $this->widget_handler, 'registerSidebars' ] );
	}
}
