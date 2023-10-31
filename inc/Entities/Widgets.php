<?php
/**
 * Widget Entities
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Entities;

use DevKit\Plugin\Abstracts;

/**
 * Service class for widget actions
 *
 * @subpackage Services
 */
class Widgets extends Abstracts\Service
{
	/**
	 * Register extra widget areas
	 *
	 * @return void
	 */
	public function registerSidebars(): void
	{
		$widget_areas = [
			[
				'name'          => 'Before Post Widget Area',
				'id'            => 'before-post-area',
				'description'   => 'Appears before blog posts',
				'class'         => '',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widgettitle">',
				'after_title'   => '</h4>',
			],
			[
				'name'          => 'After Post Widget Area',
				'id'            => 'after-post-area',
				'description'   => 'Appears after blog posts',
				'class'         => '',
				'before_widget' => '<section id="%1$s" class="widget %2$s">',
				'after_widget'  => '</section>',
				'before_title'  => '<h4 class="widgettitle">',
				'after_title'   => '</h4>',
			],
		];

		foreach ( $widget_areas as $widget_area ) {
			register_sidebar( $widget_area );
		}
	}
}
