<?php
/**
 * Interface for classes needing to use an assets handler
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Interfaces\Uses;

use MWF\Plugin\Interfaces\Dispatchers;

/**
 * Define service requirements
 *
 * @subpackage Interfaces
 */
interface Scripts
{
    /**
     * Setter for asset handler
     *
     * @param Dispatchers\Scripts $script_handler : instance of asset handler
     *
     * @return void
     */
    public function setScriptHandler( Dispatchers\Scripts $script_handler ): void;
    /**
     * Getter for asset handler
     *
     * @return ?Dispatchers\Scripts
     */
    public function getScriptHandler() : ?Dispatchers\Scripts;
}