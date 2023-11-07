<?php
/**
 * Trait definition for classes that use an asset handler
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Traits\Uses;

use MWF\Plugin\Interfaces;

/**
 * Asset Handler User Trait
 *
 * @subpackage Traits
 */
trait Assets
{

    protected Interfaces\Dispatchers\Scripts $script_handler;
    protected Interfaces\Dispatchers\Styles $style_handler;

    public function setScriptHandler( Interfaces\Dispatchers\Scripts $script_handler ) : void
    {
        $this->script_handler = $script_handler;
    }

    public function setStyleHandler( Interfaces\Dispatchers\Styles $style_handler ) : void
    {
        $this->style_handler = $style_handler;
    }
}
