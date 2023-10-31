<?php
/**
 * Provider definition file
 *
 * Providers interface with 3rd party plugins
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author  Bob Moore <bob.moore@midwestfamilymadison.com>
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @link    https://github.com/bob-moore/Devkit-Plugin-Framework
 * @since   1.0.0
 */

namespace DevKit\Plugin\Abstracts;

use DevKit\Plugin\Interfaces,
	DevKit\Plugin\Traits;

/**
 * Abstract provider class
 *
 * @subpackage Abstracts
 */
abstract class Provider extends Service implements Interfaces\Provider
{
	use Traits\EnvironmentHandler;
}
