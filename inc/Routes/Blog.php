<?php
/**
 * Blog Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Routes;

use MWF\Plugin\Abstracts,
	MWF\Plugin\Services;

/**
 * Blog router class
 *
 * @subpackage Route
 */
class Blog extends Archive
{
    public function __construct()
    {
        parent::__construct( is_home() );
    }
}
