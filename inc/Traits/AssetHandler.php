<?php
/**
 * URL Handler definition
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Traits;

use DI\Attribute\Inject;

/**
 * URL Handler Trait
 *
 * Allows classes that use this trait to work with URL helpers
 *
 * @subpackage Traits
 */
trait AssetHandler
{
    protected string $asset_dir;
    /**
     * Setter for the asset directory
     *
     * @param string $directory : path to the assets directory
     *
     * @return void
     */
    #[Inject] 
    public function setAssetDir( #[Inject( 'app.assets.dir' )] string $directory ) : void
    {
        $this->asset_dir = untrailingslashit( ltrim( $directory, '/' ) );
    }
}
