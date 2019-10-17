<?php
declare( strict_types=1 );
/**
 * File containing the SetupAfterCache class
 *
 * @copyright 2019, Stephan Gambke
 * @license   https://www.gnu.org/licenses/gpl-3.0.html GNU General Public License, version 3 (or later)
 *
 * This file is part of the MediaWiki extension Bootstrap.
 * The Bootstrap extension is free software: you can redistribute it and/or
 * modify it under the terms of the GNU General Public License as published by
 * the Free Software Foundation, either version 3 of the License, or
 * (at your option) any later version.
 *
 * The Bootstrap extension is distributed in the hope that it will be useful,
 * but WITHOUT ANY WARRANTY; without even the implied warranty of
 * MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
 * GNU General Public License for more details.
 *
 * You should have received a copy of the GNU General Public License
 * along with this program.  If not, see <https://www.gnu.org/licenses/>.
 *
 * @file
 * @ingroup FontAwesome
 */

namespace FontAwesome\Hooks;

/**
 * @see https://www.mediawiki.org/wiki/Manual:Hooks/SetupAfterCache
 *
 * @since 1.0
 * @ingroup FontAwesome
 */
class SetupAfterCache {

	protected $configuration;
	private $rlModuleTemplate;

	/**
	 * @param array $configuration
	 * @since  1.0
	 */
	public function __construct( array &$configuration ) {
		$this->configuration = &$configuration;
	}

	/**
	 * @return bool
	 * @since  1.0
	 */
	public function process(): bool {

		$this->initResourceModuleTemplate();

		$this->registerResourceModule( 'ext.fontawesome.styles', 'fontawesome.css' );
		$this->registerResourceModule( 'ext.fontawesome.styles.regular', 'regular.css' );
		$this->registerResourceModule( 'ext.fontawesome.styles.solid', 'solid.css' );
		$this->registerResourceModule( 'ext.fontawesome.styles.brands', 'brands.css' );

		return true;
	}

	private function initResourceModuleTemplate() {

		$relativePath = '/FontAwesome/res/fontawesome-free/css/';
		$remoteBasePath = $this->configuration[ 'wgExtensionAssetsPath' ] . $relativePath;
		$localBasePath = $this->configuration[ 'wgExtensionDirectory' ] . $relativePath;

		$this->rlModuleTemplate =
			[
				'localBasePath'  => $localBasePath,
				'remoteBasePath' => $remoteBasePath,
				//'position'       => 'top',
			];
	}

	/**
	 * @param string $moduleName
	 * @param string $styleFileName
	 */
	private function registerResourceModule( string $moduleName, string $styleFileName ) {
		$this->configuration[ 'wgResourceModules' ][ $moduleName ] = $this->rlModuleTemplate +
			[ 'styles' => [ $styleFileName ] ];
	}

}
