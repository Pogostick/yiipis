<?php
//	Load some scripts...
//CPSEnhanceJSTree::create( 'files', array( 'target' => '#files' ) );
CPSjqUIWrapper::create( 'jstree', array( 'target' => '#navigation', 'plugins' => array( 'themes', 'html_data' ) ) );
CPSjqUIAlerts::loadScripts();
$this->pageTitle = Yii::app()->name;

?>
<h1>Welcome to <i><?php echo CHtml::encode(Yii::app()->name); ?></i></h1>

<div id="navigation">
	<ul id="files">
		<li>
			<a href="configs">Configurations</a>
			<?php
				$_config = new ConfigurationManager();
				echo CPSTransform::asUnorderedListFromArray( $_config->getFileList(), array( 'listOptions' => array( 'id' => 'configs' ) ) );
			?>
		</li>
		<li><a href="applications">My Applications</a>
			<ul>
				<li><a href="documents/YiiPIS/">YiiPIS</a>
					<ul>
						<li><a href="#">YiiPIS</a></li>
						<li><a href="#">Cover-letter.doc</a></li>
						<li><a href="#">Gift Registry.doc</a></li>
					</ul>
				</li>
				<li><a href="documents/Other/">Other</a>
					<ul>
						<li><a href="#">Birthday Parties.doc</a></li>
						<li><a href="#">Area Playgrounds.doc</a></li>
					</ul>
				</li>
				<li><a href="documents/Travel_Ideas/">Travel Ideas</a>
					<ul>
						<li><a href="#">Potential Places.doc</a></li>
						<li><a href="#">Travel Funds.doc</a></li>
					</ul>
				</li>
				<li><a href="documents/Wedding_Plan/">Wedding Plan</a>
					<ul>
						<li><a href="#">Guests.doc</a></li>
						<li><a href="#">Services.doc</a></li>
					</ul>
				</li>
			</ul>
		</li>
		<li><a href="modules">My Modules</a>
			<ul>
				<li><a href="#">The Big Lebowski.m4v</a></li>
				<li><a href="#">Planet Earth.m4v</a></li>
			</ul>
		</li>
		<li><a href="music">My Controllers</a>
			<ul>
				<li><a href="#">Bloc Party - Pioneers.mp3</a></li>
				<li><a href="#">Fleet Foxes - Blue Ridge Mountains.mp3</a></li>
			</ul>
		</li>
		<li><a href="photos">My Models</a>
			<ul>
				<li><a href="#">yellow-flower.jpg</a></li>
				<li><a href="#">orange-flower.jpg</a></li>
				<li><a href="#">red-flower.jpg</a></li>
				<li><a href="#">white-flower.jpg</a></li>
				<li><a href="#">bumblebees.jpg</a></li>
			</ul>
		</li>
	</ul>
</div>
