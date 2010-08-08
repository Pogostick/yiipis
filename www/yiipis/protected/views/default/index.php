<?php
$this->pageTitle = Yii::app()->name;
?>
<div>

	<h1 style="padding-top:10px;font-size:3.5em">What is <span class="yiipis">YiiPIS</span>?</h1>
	<p style="margin:15px 25px 0;font-size:2em;line-height:1.15em;">Simply put, <span class="yiipis">YiiPIS</span> is a site dedicated to building tools that make the <a href="http://yiiframework.com/" target="_blank">Yii Framework</a> more powerful and easier to use. In addition we will be showcasing what can be done with Yii. <strong>Everything</strong> on this site, including the site itself, was created with <a href="http://yiiframework.com/" target="_blank">Yii</a> and is available for download.</p>

	<h1 style="padding-top:10px;font-size:3.5em">What can I do here?</h1>
	<p style="margin:15px 25px 0;font-size:2em;line-height:1.15em;">
		Not much yet. We are slowly rolling out new features. Watch this space and the Yii forums for announcements.
	</p>

	<h1 style="padding-top:10px;font-size:3.5em">How can I contribute?</h1>
	<p style="margin:15px 25px 0;font-size:2em;line-height:1.15em;">
		This site and its contents are hosted on <a href="http://github.com/lucifurious/yiipis" target="_blank">Github</a>. Feel free to fork or clone. If you want to be a collaborator, contact us at <a href="mailto:opensource@pogostick.com?subject=I+want+to+help+YiiPIS">opensource@pogostick.com</a> and we'll chat.
	</p>

	<script type="text/javascript">
		$(function(){
			//	Cool little neon-like animation....
			$('h1 span.yiipis')
				.effect('pulsate',{times:5,easing:'easeInBack'},10)
				.effect('pulsate',{times:3,easing:'easeOutExpo'},100)
				.effect('pulsate',{times:2},200,function(){
					$(this).addClass('yiipis-neon');
				});
		});
	</script>
</div>
