<?php
/**
 * Route Definition
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/MDMDevOps/mwf-cornerstone
 * @since   1.0.0
 */

namespace MWF\Plugin\Abstracts;

use MWF\Plugin\Interfaces,
	MWF\Plugin\Traits;

/**
 * Route class
 *
 * @subpackage Route
 */
abstract class Route
extends Service 
implements Interfaces\Route, Interfaces\Uses\Styles, Interfaces\Uses\Scripts
{
	use Traits\Uses\Styles,
		Traits\Uses\Scripts;
}
