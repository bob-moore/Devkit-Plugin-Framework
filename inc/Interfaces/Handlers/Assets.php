<?php
/**
 * Asset Handler interface
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Interfaces\Handlers;

/**
 * Define asset handler requirements
 *
 * @subpackage Controllers
 */

interface Assets
{
    /**
     * Setter for the asset directory
     *
     * @param string $directory : path to the assets directory
     *
     * @return void
     */
    public function setAssetDir( string $directory ) : void;
}