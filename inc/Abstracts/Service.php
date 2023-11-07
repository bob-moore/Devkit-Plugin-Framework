<?php
/**
 * Service definition file
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

use MWF\Plugin\Interfaces;

use DI\Attribute\Inject;

/**
 * Abstract Service class
 *
 * @subpackage Abstracts
 */
abstract class Service
extends Loadable
implements Interfaces\Service
{
	/**
	 * Whether or not this class shouldn't be used
	 *
	 * Used to conditionally use/not use class. For instance, if a class is
	 * dependent on a 3rd party plugin, $enabled can be used to disable the
	 * class if the plugin is not active
	 *
	 * @var boolean
	 */
	protected bool $enabled;
	/**
	 * Default constructor
	 *
	 * No parameters required. Will only continue the constructor path if class
	 * is enabled.
	 */
	public function __construct( bool $enabled = true )
	{
		if ( $this->setEnabled( $enabled ) ) {
			parent::__construct();
		}
	}
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
	public function setEnabled( bool $enabled ): bool
	{
		if ( ! isset( $this->enabled ) ) {
			$this->enabled = $enabled;
		}
		return $this->enabled;
	}
	/**
	 * Getter for enabled flag
	 *
	 * @return bool
	 */
	public function isEnabled(): bool
	{
		return $this->enabled ?? true;
	}
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * Depends on not having previously performed the load action
	 *
	 * @return void
	 */
	#[Inject]
	public function load(): void
	{
		if ( $this->isEnabled() ) {
			parent::load();
		}
	}
}
