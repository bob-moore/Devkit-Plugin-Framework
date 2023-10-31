<?php
/**
 * Trait definition for classes that use an asset handler
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Traits\Uses;

use DevKit\Plugin\Interfaces;

/**
 * Asset Handler User Trait
 *
 * @subpackage Traits
 */
trait Assets
{
    /**
     * Instance of the asset handler
     *
     * @var Interfaces\AssetHandler
     */
    protected Interfaces\AssetHandler $asset_handler;
    /**
     * Setter for the asset directory
     *
     * @param string $directory : path to the assets directory
     *
     * @return void
     */
    public function setAssetHandler( Interfaces\AssetHandler $asset_handler ) : void
    {
        $this->asset_handler = $asset_handler;
    }
}
