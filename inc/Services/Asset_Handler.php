<?php
/**
 * Admin Service Definition
 *
 * PHP Version 8.0.28
 *
 * @package DevKit\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/bob-moore/Devkit-Plugin-Framework
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace DevKit\Plugin\Services;

use DevKit\Plugin\Abstracts,
    DevKit\Plugin\Interfaces,
	DevKit\Plugin\Traits;

/**
 * Service class to control admin functions
 * - Enqueues Admin CSS
 * - Enqueues Admin JS
 * - Adds Metaboxes
 *
 * @subpackage Services
 */
class Asset_Handler 
extends Abstracts\Service 
implements Interfaces\Handlers\Assets, Interfaces\Handlers\Directory, Interfaces\Handlers\Url
{
    use Traits\UrlHandler,
        Traits\DirectoryHandler;

	protected string $asset_dir;
	/**
	 * Construct new instance of service
	 *
	 * @param string $asset_dir : Directory path to the assets folder.
	 * @param string $asset_url : URL path to the assets folder.
	 */
	public function __construct( 
        string $asset_dir = 'dist',
        string $app_dir,
        string $app_url
	) {
		$this->setAssetDir( $asset_dir );
        $this->setDir( $app_dir );
        $this->setUrl( $app_url );
		parent::__construct();
	}
    /**
     * Setter for the asset directory
     *
     * @param string $directory : path to the assets directory
     *
     * @return void
     */
    public function setAssetDir( string $directory ) : void
    {
        $this->asset_dir = untrailingslashit( ltrim( $directory, '/' ) );
    }
	/**
	 * Get script assets from {handle}.asset.php
	 *
	 * @param string             $path : relative path to script.
	 * @param array<int, string> $dependencies : current dependencies passed, if any.
	 * @param string             $version : current version passed, if any.
	 *
	 * @return array<string, mixed>
	 */
	private function scriptAssets( string $path, array $dependencies, string $version ): array
	{
		$asset_file = sprintf(
			'%s/%s.asset.php',
			$this->dir( $this->asset_dir ),
			str_ireplace( '.js', '', $path )
		);

		if ( is_file( $asset_file ) ) {
			$args = include $asset_file;

			$assets = [
				'dependencies' => wp_parse_args( $args['dependencies'], $dependencies ),
				'version'      => empty( $version ) ? $args['version'] : $version,
			];
		} else {
			$assets = [
				'dependencies' => $dependencies,
				'version'      => $version,
			];
		}

		return $assets;
	}
	/**
	 * Enqueue a script in the build/dist directories
	 *
	 * @param string             $handle : handle to register.
	 * @param string             $path : relative path to script.
	 * @param array<int, string> $dependencies : any set dependencies not in assets file, optional.
	 * @param string             $version : version of JS file, optional.
	 * @param boolean            $in_footer : whether to enqueue in footer, optional.
	 *
	 * @return void
	 */
	public function enqueueScript(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = '',
		$in_footer = true
	): void {
		/**
		 * Get full file path
		 */
        $file = $this->dir( "{$this->asset_dir}/{$path}" );
		/**
		 * If not a file, or empty, bail...
		 */
		if ( ! is_file( $file ) || ! filesize( $file ) ) {
			return;
		}
		/**
		 * Get assets
		 */
		$assets = $this->scriptAssets( $path, $dependencies, $version );
		/**
		 * Enqueue script
		 */
		wp_enqueue_script(
			str_replace( [ '/', '\\', ' ' ], '-', $this->package ) . '-' . $handle,
			$this->url( "{$this->asset_dir}/{$path}" ),
			apply_filters( "{$this->package}_{$handle}_script_dependencies", $assets['dependencies'] ),
			$assets['version'] ?? filemtime( $file ),
			$in_footer
		);
	}
	/**
	 * Enqueue a style in the dist/build directories
	 *
	 * @param string             $handle : handle to register.
	 * @param string             $path : relative path to css file.
	 * @param array<int, string> $dependencies : any dependencies that should be loaded first, optional.
	 * @param string             $version : version of CSS file, optional.
	 * @param string             $screens : what screens to register for, optional.
	 *
	 * @return void
	 */
	public function enqueueStyle(
		string $handle,
		string $path,
		array $dependencies = [],
		string $version = null,
		$screens = 'all'
	): void {
		/**
		 * Get full file path
		 */
        $file = $this->dir( "{$this->asset_dir}/{$path}" );
		/**
		 * If not a file, or empty, bail...
		 */
		if ( ! is_file( $file ) || ! filesize( $file ) ) {
			return;
		}
		/**
		 * Enqueue Style
		 */
		wp_enqueue_style(
			str_replace( [ '/', '\\', ' ' ], '-', $this->package ) . '-' . $handle,
			$this->url( "{$this->asset_dir}/{$path}" ),
			apply_filters( "{$this->package}_{$handle}_style_dependencies", $dependencies ),
			$version ?? filemtime( $file ),
			$screens
		);
	}
}
