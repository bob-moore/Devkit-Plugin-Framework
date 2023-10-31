<?php
/**
 * Admin Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Routes;

use DevKit\Plugin\Abstracts;

/**
 * Admin router class
 *
 * @subpackage Route
 */
class Admin extends Abstracts\Route
{
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_action( 'admin_enqueue_scripts', [ $this, 'enqueueAssets' ] );
	}
	/**
	 * Enqueue admin styles and JS bundles
	 *
	 * @return void
	 */
	public function enqueueAssets(): void
	{
		$this->asset_handler->enqueueScript(
			'admin',
			'admin/bundle.js'
		);
		$this->asset_handler->enqueueStyle(
			'admin',
			'admin/bundle.css'
		);
	}
}
