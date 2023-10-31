<?php
/**
 * Menu Entities
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
 * Service class for menu actions
 *
 * @subpackage Services
 */
class Menus extends Abstracts\Service
{
/**
	 * Reorder admin sidebar items
	 *
	 * @param  array<string> $menu_items Array of menu items
     * 
	 * @return array<string> reordered array of menu items
	 */
	public function reorderAdminMenu( array $menu_items ) : array
    {
        $menu = [
            'top'         => [],
            'posts'       => [],
            'secondary'   => [],
            'woocommerce' => [],
            'elementor'   => [],
            'bottom'      => [],
            'last'        => [],
        ];

		foreach( $menu_items as $menu_item )
        {
            switch ( true )
            {
                case in_array( $menu_item,
                    [
                        'jetpack',
                        'genesis',
                        'edit.php?post_type=fl-builder-template',
                        'edit.php?post_type=acf-field-group',
                        'googlesitekit-dashboard',
                        'yith_plugin_panel'
                    ], true ) :
                    $menu['last'][] = $menu_item;
                    break;
                case in_array( $menu_item,
                    [
                        'edit.php?post_type=product',
                        'woocommerce',
                        'wc-admin&path=/analytics/revenue',
                        'woocommerce-marketing',
                        'wc-admin&path=/analytics/overview',
                        'kadence-shop-kit-settings'
                    ], true ) :
                    $menu['woocommerce'][] = $menu_item;
                    break;
                case $menu_item === 'separator-woocommerce' :
                    array_unshift( $menu['woocommerce'], $menu_item );
                    break;
                case in_array( $menu_item,
                    [
                        'index.php',
                        'separator1',
                        'video-user-manuals/plugin.php'
                    ], true ) :
                    $menu['top'][] = $menu_item;
                    break;
                case in_array( $menu_item,
                    [
                        'edit.php?post_type=elementor_library',
                        'separator-elementor',
                        'elementor'
                    ], true ) :
                    $menu['elementor'][] = $menu_item;
                    break;
                case str_contains( $menu_item , 'edit.php' ) :
				case $menu_item === 'nestedpages' :
                    $menu['posts'][] = $menu_item;
                    break;
                case in_array( $menu_item,
                    [
                        'upload.php',
                        'gf_edit_forms',
                        'edit-comments.php'
                    ], true ) :
                    $menu['secondary'][] = $menu_item;
                    break;
                default :
                    $menu['bottom'][] = $menu_item;
                    break;
            }
		}

        return array_reduce( $menu, function( $combined, $current ) {
            return array_merge( $combined, $current );
        }, [] );
	}
    /**
	 * Rename admin sidebar items
	 *
	 * Rename "posts" to "blog"
	 *
	 * @return void
	 */
	public function renameAdminMenuItems() : void
    {
		global $menu;
		global $submenu;

		$menu[5][0]                 = __( 'Blog', 'mwf-cornerstone' );
		$submenu['edit.php'][5][0]  = __( 'Blog Posts', 'mwf-cornerstone' );
		$submenu['edit.php'][10][0] = __( 'Add Blog Posts', 'mwf-cornerstone' );
	}
}
