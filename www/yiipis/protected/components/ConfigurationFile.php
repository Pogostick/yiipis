<?php
/*
 * ConfigurationFile.php
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
 * ConfigurationFile
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
class ConfigurationFile extends CPSFile
{
	//********************************************************************************
	//* Member Variables
	//********************************************************************************

	protected $m_oXml = null;
	public function getXml() { return $this->m_oXml; }
	public function setXml( $oXml ) { $this->m_oXml = $oXml; }

	//********************************************************************************
	//* Public Methods
	//********************************************************************************

	/**
	 * Opens and reads the file into our xml object
	 * @return boolean
	 */
	public function open()
	{
		$this->m_oXml = null;
		
		if ( file_exists( $this->m_sFileName ) )
		{
			try
			{
				$this->m_oXml = simplexml_load_file( $this->m_sFileName );
				return true;
			}
			catch ( Exception $_ex )
			{
				$this->m_oXml = null;
			}
		}

		return false;
	}

	public function asUnorderedList( $sId, $sClass = 'tree', $sRole = 'tree' )
	{
		$_sOut = PS::openTag( 'ul', array( 'id' => $sId, 'class' => $sClass, 'role' => 'tree' ) );

		foreach ( $this->m_oXml->configurations as $_oConfig )
		{
			$_sOut .= PS::tag(
				'li',
				array( 'role' => 'treeitem', 'aria-expanded' => false ),
				PS::link( $_oConfig->configuration['name'], $_oConfig->configuration['id'] )
			);

			if ( count( $_oConfig->configuration->children() ) > 0 )
			{
				foreach ( $_oConfig->configuration->children() as $_oItem )
					$_sOut .= PS::tag( 'li', array(), PS::link( $_oItem->key, $_oItem->key ) );
			}
		}

		$_sOut .= PS::closeTag( 'ul' );

		echo $_sOut;
	}
}

/*
<ul id="files" role="tree" class="tree">
	<li role="treeitem" aria-expanded="true"><a href="applications" tabindex="0" class="tree-parent">My Applications</a>
		<ul role="group" class=" ">
			<li role="treeitem" aria-expanded="false"><a href="documents/YiiPIS/" tabindex="-1" class="tree-parent tree-parent-collapsed">YiiPIS</a>
				<ul role="group" class="tree-group-collapsed">
					<li role="treeitem"><a href="#" tabindex="-1">YiiPIS</a></li>
					<li role="treeitem"><a href="#" tabindex="-1">Cover-letter.doc</a></li>
					<li role="treeitem"><a href="#" tabindex="-1">Gift Registry.doc</a></li>
				</ul>
			</li>
			<li role="treeitem" aria-expanded="false"><a href="documents/Other/" tabindex="-1" class="tree-parent tree-parent-collapsed">Other</a>
				<ul role="group" class="tree-group-collapsed">
					<li role="treeitem"><a href="#" tabindex="-1">Birthday Parties.doc</a></li>
					<li role="treeitem"><a href="#" tabindex="-1">Area Playgrounds.doc</a></li>
				</ul>
			</li>
			<li role="treeitem" aria-expanded="false"><a href="documents/Travel_Ideas/" tabindex="-1" class="tree-parent tree-parent-collapsed">Travel Ideas</a>
				<ul role="group" class="tree-group-collapsed">
					<li role="treeitem"><a href="#" tabindex="-1">Potential Places.doc</a></li>
					<li role="treeitem"><a href="#" tabindex="-1">Travel Funds.doc</a></li>
				</ul>
			</li>
			<li role="treeitem" aria-expanded="false"><a href="documents/Wedding_Plan/" tabindex="-1" class="tree-parent tree-parent-collapsed">Wedding Plan</a>
				<ul role="group" class="tree-group-collapsed">
					<li role="treeitem"><a href="#" tabindex="-1">Guests.doc</a></li>
					<li role="treeitem"><a href="#" tabindex="-1">Services.doc</a></li>
				</ul>
			</li>
		</ul>
	</li>
	<li role="treeitem" aria-expanded="false"><a href="modules" tabindex="-1" class="tree-parent tree-parent-collapsed">My Modules</a>
		<ul role="group" class="tree-group-collapsed">
			<li role="treeitem"><a href="#" tabindex="-1">The Big Lebowski.m4v</a></li>
			<li role="treeitem"><a href="#" tabindex="-1">Planet Earth.m4v</a></li>
		</ul>
	</li>
	<li role="treeitem" aria-expanded="false"><a href="music" tabindex="-1" class="tree-parent tree-parent-collapsed">My Controllers</a>
		<ul role="group" class="tree-group-collapsed">
			<li role="treeitem"><a href="#" tabindex="-1">Bloc Party - Pioneers.mp3</a></li>
			<li role="treeitem"><a href="#" tabindex="-1">Fleet Foxes - Blue Ridge Mountains.mp3</a></li>
		</ul>
	</li>
	<li role="treeitem" aria-expanded="false"><a href="photos" tabindex="-1" class="tree-parent tree-parent-collapsed">My Models</a>
		<ul role="group" class="tree-group-collapsed">
			<li role="treeitem"><a href="#" tabindex="-1">yellow-flower.jpg</a></li>
			<li role="treeitem"><a href="#" tabindex="-1">orange-flower.jpg</a></li>
			<li role="treeitem"><a href="#" tabindex="-1">red-flower.jpg</a></li>
			<li role="treeitem"><a href="#" tabindex="-1">white-flower.jpg</a></li>
			<li role="treeitem"><a href="#" tabindex="-1">bumblebees.jpg</a></li>
		</ul>
	</li>
</ul>
 */