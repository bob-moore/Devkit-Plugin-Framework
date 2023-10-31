<?php
/**
 * Interface for classes needing to use an assets handler
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Interfaces\Uses;

use DevKit\Plugin\Interfaces\Handlers;

/**
 * Define service requirements
 *
 * @subpackage Interfaces
 */
interface Assets
{
    /**
     * Setter for asset handler
     *
     * @param string $asset_handler : instance of asset handler
     *
     * @return void
     */
    public function setAssetHandler( Handlers\Assets $asset_handler ) : void;
    /**
     * Getter for asset handler
     *
     * @return Handlers\Assets
     */
    public function getAssetHandler() : Handlers\Assets;
}