<?php
/**
 * Service interface
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
interface Service
{
	/**
	 * Setter for the $enabled flag
	 *
	 * Only set enabled if not previously set. This allows child classes to not
	 * be overridden by parents.
	 *
	 * @param boolean $enabled bool value to set if class is enabled.
	 *
	 * @return bool
	 */
	public function setEnabled( bool $enabled ): bool;
	/**
	 * Getter for enabled flag
	 *
	 * @return bool
	 */
	public function isEnabled(): bool;
}
