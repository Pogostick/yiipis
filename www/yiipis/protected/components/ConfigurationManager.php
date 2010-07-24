<?php
/*
 * ConfigurationManager.php
 * 
 * Copyright (c) 2010 Jerry Ablan <jablan@pogostick.com>.
 * @link http://www.pogostick.com Pogostick, LLC.
 * @license http://www.pogostick.com/licensing
 * 
 * This file is part of YiiPIS.
 * 
 * We share the same open source ideals as does the jQuery team, and
 * we love them so much we like to quote their license statement:
 * 
 * You may use our open source libraries under the terms of either the MIT
 * License or the Gnu General Public License (GPL) Version 2.
 * 
 * The MIT License is recommended for most projects. It is simple and easy to
 * understand, and it places almost no restrictions on what you can do with
 * our code.
 * 
 * If the GPL suits your project better, you are also free to use our code
 * under that license.
 * 
 * You don’t have to do anything special to choose one license or the other,
 * and you don’t have to notify anyone which license you are using.
 */

//	Include Files
//	Constants
//	Global Settings

/**
 * ConfigurationManager
 *
 * @package 	YiiPIS
 * @subpackage
 *
 * @author 		Jerry Ablan <jablan@pogostick.com>
 * @version 	SVN $Id$
 * @since 		v1.0.0
 *
 * @filesource
 */
class ConfigurationManager extends CPSComponent
{
	//********************************************************************************
	//* Member Variables
	//********************************************************************************
	
	/**
	 * The list of paths in which to search for files
	 * @var array
	 */
	protected $_pathList = array();
	public function getPathList() { return $this->_pathList; }
	public function setPathList( $pathList ) { $this->_pathList = $pathList; $this->loadFiles( true ); }

	/**
	 * The list of allowed extensions for these types of files
	 * @var array
	 */
	protected $_extensionList = array();
	public function getExtentsionList() { return $this->_extensionList; }
	public function setExtentsionList( $extensionList ) { $this->_extensionList = $extensionList; $this->loadFiles( true ); }

	/**
	 * The list of files that I'm managing
	 * @var array
	 */
	protected $_fileList = array();
	public function getFileList() { return $this->_fileList; }

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/**
	 * Create our file manager
	 * @param array $config
	 */
	public function __construct( $config = array() )
	{
		parent::__construct( $config );
		
		//	Set default paths
		$this->_pathList = array(
			$_SERVER['DOCUMENT_ROOT'] . '/library/config'
		);

		//	And default extensions
		$this->_extensionList = array(
			'xml',
			'php',
			'conf',
			'ini',
			'config',
		);

		//	Get files
		$this->loadFiles();
	}

	/**
	 * Load files in our directories
	 */
	public function loadFiles( $clearFirst = false )
	{
		if ( $clearFirst ) $this->_fileList = array();

		foreach ( $this->_pathList as $_path )
		{
			$_dir = opendir( $_path );

			while ( false !== ( $_file = readdir( $_dir ) ) )
			{
				if ( $_file != '.' && $_file != '..' )
				{
					$_fullPath = $_path . DIRECTORY_SEPARATOR . $_file;
					
					//	Allowed?
					if ( in_array( end( explode( '.', $_fullPath ) ), $this->_extensionList ) )
					{
						//	File!
						$this->_fileList[] = array(
							'path' => $_path,
							'file' => $_file,
							'lastModified' => filemtime( $_fullPath ),
						);
					}
				}
			}
		}
	}

	//********************************************************************************
	//* Private Methods
	//********************************************************************************
}
