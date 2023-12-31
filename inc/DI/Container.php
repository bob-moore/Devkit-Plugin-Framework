<?php
/**
 * Container definition file
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\DI;

use DI\DependencyException,
	DI\NotFoundException,
	WP_Error;

/**
 * Service Container
 *
 * @subpackage DI
 */
final class Container extends \DI\Container
{
	/**
	 * Returns an entry of the container by its name.
	 *
	 * @param string $id : Entry name or a class name.
	 *
	 * @return mixed
	 *
	 * @throws DependencyException Error while resolving the entry.
	 * @throws NotFoundException No entry found for the given name.
	 */
	public function get( string $id ): mixed
	{
		try {
			$instance = parent::get( $id );

            if ( ! is_object( $instance ) ) {
                return $instance;
            }
			if ( $this->has( 'app.package' ) ) {
				return apply_filters( "{$this->get( 'app.package' )}_decorate_service", $instance, $this ); 
			} else {
				return $instance;
			}
		} catch ( DependencyException | NotFoundException $e ) {
			return new WP_Error( $e->getMessage() );
		}
	}
}
