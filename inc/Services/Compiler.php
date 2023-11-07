<?php
/**
 * Compiler Service Definition
 *
 * PHP Version 8.0.28
 *
 * @package MWF\Plugin
 * @author Bob Moore <bob.moore@midwestfamilymadison.com>
 * @link https://github.com/MDMDevOps/mwf-cornerstone
 * @license GPL-2.0+ <http://www.gnu.org/licenses/gpl-2.0.txt>
 * @since 1.0.0
 */

namespace MWF\Plugin\Services;

use MWF\Plugin\Abstracts,
	MWF\Plugin\Interfaces,
	MWF\Plugin\Traits,
	Timber\Timber,
	Timber\Loader,
	Timber\Twig_Function,
	Timber\Twig_Filter,
	Twig\Environment,
	Twig\Error\SyntaxError;

use DI\Attribute\Inject;

/**
 * Service class to compile twig files and provide timber functions
 * - Add twig functions & filters
 * - Define template locations
 * - Filter timber context
 * - Add render and compile functions
 *
 * @subpackage Services
 */
class Compiler
extends Abstracts\Service
implements Interfaces\Services\Compiler, Interfaces\Handlers\Directory
{
	use Traits\DirectoryHandler;

	/**
	 * Twig functions to add
	 *
	 * @var array<string, array<string, mixed>>
	 */
	private array $functions = [];
	/**
	 * Twig filters to add
	 *
	 * @var array<string, array<string, mixed>>
	 */
	private array $filters = [];
	/**
	 * Cached template locations for timber to search for templates
	 *
	 * @var array<string>
	 */
	private array $template_locations = [];
	/**
	 * Instance of twig
	 *
	 * @var ?Environment
	 */
	protected ?Environment $twig;
	/**
	 * Constructor for new service instance
	 *
	 * @param string $dir : path to template files.
	 */
	public function __construct(
		#[Inject( 'app.templates.dir' )] protected string $template_directory = 'template-parts'
	) {
		parent::__construct();
	}
	/**
	 * Set the template directory
	 *
	 * @param string $template_directory : relative path to the template directory
	 *
	 * @return void
	 */
	public function setTemplateDirectory( string $template_directory ): void
	{
		$this->$template_directory = trim( $template_directory );
	}
	/**
	 * Load actions and filters, and other setup requirements
	 *
	 * Package specific actions/filters are loaded by the service directly. This
	 * method allows child classes extending this class to inherit those
	 * actions & have them loaded.
	 *
	 * Actions/filters that should not be duplicated are loaded by a controller.
	 *
	 * @return void
	 */
	public function onLoad(): void
	{
		add_action( "{$this->package}_render_template", [ $this, 'render' ], 10, 2 );
		add_filter( "{$this->package}_compile_template", [ $this, 'compileByFilter' ], 10, 3 );

		add_action( "{$this->package}_render_string", [ $this, 'renderString' ], 10, 2 );
		add_filter( "{$this->package}_compile_string", [ $this, 'compileString' ], 10, 2 );

		add_filter( "{$this->package}_compiled", [ $this, 'removeEmptyP' ], 99 );
		add_filter( "{$this->package}_compiled", 'trim', 99 );
	}
	/**
	 * Add the 'post' to context, if not already present.
	 *
	 * @param array<string, mixed> $context : optional context to merge.
	 *
	 * @return array<int, string>
	 */
	public function context( array $context = [] ): array
	{
		$context = array_merge( Timber::context(), $context );

		if ( ! isset( $context['post'] ) ) {
			global $post;

			if ( is_object( $post ) ) {
				$context['post'] = Timber::get_post( $post->ID );
			} elseif ( is_int( $post ) ) {
				$context['post'] = Timber::get_post( $post );
			}
		}

		return $context;
	}
	/**
	 * Filters the default locations array for twig to search for templates. We never use some paths, so there's
	 * no reason to waste overhead looking for templates there.
	 *
	 * @param array<int, string> $locations : Array of absolute paths to
	 *                                        available templates.
	 *
	 * @return array<int, string> $locations
	 */
	public function templateLocations( array $locations ): array
	{
		if ( empty( $this->template_locations ) ) {
			$this->template_locations = array_filter( $locations, function( $location ) {
				return str_contains( $locations, $this->dir() );
			} );
			$this->template_locations[] = $this->dir( $this->template_directory );
		}
		return $this->template_locations;
	}
	/**
	 * Compile a twig/html template file using Timber
	 *
	 * @param string|array<int, string> $template_file : relative path to template file.
	 * @param array<string, mixed>      $context : additional context to pass to twig.
	 *
	 * @return string
	 */
	public function compile( $template_file, array $context = [] ): string
	{
		try {
			$template_file = is_array( $template_file ) ? $template_file : [ $template_file ];

			ob_start();

			Timber::render( $template_file, $this->context( $context ), 600, Loader::CACHE_NONE );

			$contents = ob_get_contents();

			return apply_filters( "{$this->package}_compiled", $contents );
		} catch ( SyntaxError $e ) {
			return '';
		} finally {
			ob_end_clean();
		}
	}
	/**
	 * Compile a template file and return the content via a filter
	 *
	 * @param string                    $content : default content.
	 * @param string|array<int, string> $template_file : relative path of templates to compile.
	 * @param array<string, mixed>      $context : additional context to pass to templates.
	 *
	 * @return string
	 */
	public function compileByFilter( string $content, $template_file, array $context = [] ): string
	{
		$compiled = $this->compile( $template_file, $context );

		return ! empty( $compiled ) ? $compiled : $content;
	}
	/**
	 * Compile a string with timber/twig
	 *
	 * @param string               $content : string content to compile.
	 * @param array<string, mixed> $context : additional context to pass to twig.
	 *
	 * @return string
	 */
	public function compileString( string $content, array $context = [] ): string
	{
		try {
			ob_start();

			Timber::render_string( $content, $this->context( $context ) );

			return apply_filters( "{$this->package}_compiled", ob_get_contents() );
		} catch ( SyntaxError $e ) {
			return $e->getMessage();
		} finally {
			ob_end_clean();
		}
	}
	/**
	 * Render a frontend twig template with timber/twig
	 *
	 * Wrapper for `compile` but outputs the content instead of returning it
	 * Ignored by PHPCS because we cannot escape at this time. Values should be
	 * escaped at the template level.
	 *
	 * @param string|array<int, string> $template_file : file to render.
	 * @param array<string, mixed>      $context : additional context to pass to twig.
	 *
	 * @return void
	 */
	public function render( $template_file, array $context = [] ): void
	{
        // phpcs:ignore
        echo $this->compile( $template_file, $context );
	}
	/**
	 * Render a string with timber/twig
	 *
	 * Wrapper for `compileString` but outputs the content instead of returning it
	 * Ignored by PHPCS because we cannot escape at this time. Values should be
	 * escaped at the template level.
	 *
	 * @param string               $content : string content to compile.
	 * @param array<string, mixed> $context : additional context to pass to twig.
	 *
	 * @return void
	 */
	public function renderString( string $content, array $context = [] ): void
	{
        // phpcs:ignore
        echo $this->compileString( $content, $context );
	}
	/**
	 * Getter for $functions that runs a filter once
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public function getFunctions(): array
	{
		return did_filter( "{$this->package}_twig_functions" )
			? $this->functions
			: apply_filters( "{$this->package}_twig_functions", $this->functions );
	}
	/**
	 * Getter for $filters that runs a filter once
	 *
	 * @return array<string, array<string, mixed>>
	 */
	public function getFilters(): array
	{
		return did_filter( "{$this->package}_twig_filters" )
			? $this->filters
			: apply_filters( "{$this->package}_twig_filters", $this->filters );
	}
	/**
	 * Register custom function with TWIG
	 *
	 * @param Environment $twig : instance of twig environment.
	 *
	 * @return Environment
	 */
	public function loadFunctions( Environment $twig ): Environment
	{
		foreach ( $this->getFunctions() as $name => $args ) {
			try {
				$twig->AddFunction( new Twig_Function( $name, $args['callback'], $args['args'] ) );
			} catch ( \LogicException $e ) {
				unset( $this->functions[ $name ] );
			}
		}
		return $twig;
	}
	/**
	 * Register custom filters with TWIG
	 *
	 * @param Environment $twig : instance of twig environment.
	 *
	 * @return Environment
	 */
	public function loadFilters( Environment $twig ): Environment
	{
		foreach ( $this->getFilters() as $name => $args ) {
			try {
				$twig->AddFilter( new Twig_Filter( $name, $args['callback'], $args['args'] ) );
			} catch ( \LogicException $e ) {
				unset( $this->filters[ $name ] );
			}
		}
		return $twig;
	}
	/**
	 * Add a function to collection of twig functions
	 *
	 * @param string                   $name : name of function to bind.
	 * @param string|array<int, mixed> $callback : callback function.
	 * @param array<string, mixed>     $args : args to add to twig function.
	 *
	 * @see https://twig.symfony.com/doc/3.x/advanced.html
	 * @see https://timber.github.io/docs/guides/extending-timber/
	 *
	 * @return void
	 */
	public function addFunction( string $name, string|array $callback, array $args = [] ): void
	{
		$this->functions[ $name ] = [
			'callback' => $callback,
			'args'     => $args,
		];
	}
	/**
	 * Add a filter to collection of twig functions
	 *
	 * @param string                   $name : name of filter to bind.
	 * @param string|array<int, mixed> $callback : callback function.
	 * @param array<string, mixed>     $args : args to add to twig filter.
	 *
	 * @see https://twig.symfony.com/doc/3.x/advanced.html
	 * @see https://timber.github.io/docs/guides/extending-timber/
	 *
	 * @return void
	 */
	public function addFilter( string $name, string|array $callback, array $args = [] ): void
	{
		$this->filters[ $name ] = [
			'callback' => $callback,
			'args'     => $args,
		];
	}
	/**
	 * Use twig to check if a given template exists in the defined paths
	 *
	 * @param string $name : which template to search for.
	 *
	 * @return boolean
	 */
	public function templateExists( string $name ): bool
	{
		if ( is_null( $this->twig ) ) {
			$loader = new Loader();

			$this->twig = $loader->get_twig();
		}
		return $this->twig->getLoader()->exists( $name );
	}
}
