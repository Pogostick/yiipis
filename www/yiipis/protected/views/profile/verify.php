<?php
/**
 * verify view file
 *
 * @filesource
 * @author Jerry Ablan <jablan@intopicmedia.com>
 * @copyright Copyright &copy; 2009 InTopic Media, LLC
 * @link http://www.intopicmedia.com InTopic Media, LLC.
 * @package itm.modules.advertiser
 * @subpackage views
 * @version SVN: $Revision: 95 $
 * @modifiedby $LastChangedBy: jablan $
 * @lastmodified  $Date: 2010-04-18 23:37:31 -0400 (Sun, 18 Apr 2010) $
 */

//	Include files...
Yii::app()->clientScript->registerCssFile( '/css/form.css' );

?>
<div class="copy">
	<h1>Email Verification Not Completed</h1>

<?php
	if ( $sent )
		echo '<p>We have resent your verification email. If you do not receive it within one hour, please email support@' . Yii::app()->params['siteEmailDomain'] . '.</p>';
	else
	{
?>
	<p>Before you can log into your account, you must verify your email address.</p>
	<p>You should have received your welcome email from <?php echo Yii::app()->params['systemName']; ?> with your verification code and link. If you did not receive this or wish to be sent a new one, please click the <b>Resend</b> button below.</p>

	<div class="yiiForm">
<?php
		echo PS::beginForm( '/client/dashboard/verify', 'POST' );
			echo PS::submitButtonBar( 'Resend', array( 'noBorder' => true, 'jqui' => true, 'icon' => 'mail-closed' ) );
		echo PS::endForm();
		echo '</div>';
	}
?>
</div>