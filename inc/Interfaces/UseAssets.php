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

namespace DevKit\Plugin\Interfaces;

/**
 * Define service requirements
 *
 * @subpackage Interfaces
 */
interface UseAssets
{
    /**
     * Setter for the asset directory
     *
     * @param string $directory : path to the assets directory
     *
     * @return void
     */
    public function setAssetHandler( AssetHandler $asset_handler ) : void;
}
