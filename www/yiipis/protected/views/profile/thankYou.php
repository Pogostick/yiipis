<?php
/**
 * thankYou view file
 *
 * @filesource
 * @author Jerry Ablan <jablan@intopicmedia.com>
 * @copyright Copyright &copy; 2009 InTopic Media, LLC
 * @link http://www.intopicmedia.com InTopic Media, LLC.
 * @package itm.modules.advertiser
 * @subpackage views
 * @version SVN: $Revision: 273 $
 * @modifiedby $LastChangedBy: jablan $
 * @lastmodified  $Date: 2010-06-30 17:44:12 -0400 (Wed, 30 Jun 2010) $
 */

//	Include files...
$_sSystemName = Yii::app()->params['systemName'];

if ( ! isset( $type ) )
{
?>

<h1>Thank You For Registering For The <?php echo $_sSystemName; ?> Network!</h1>

<div class="copy">
	<p>You will soon receive an introduction e-mail containing a validation link. You must click the link to activate your account. The validation link will direct you to the Client Dashboard, where you can get started with your account.

	<p>Note: Please add <?php echo $_sSystemName; ?> to your email account's address book in order to prevent the validation email from being blocked as spam. If you do not receive your validation email within one hour, please check your spam folder.</p>

	<p>If you have any questions about activating your <?php echo $_sSystemName; ?> account, contact us at <a href="mailto:support@<?php echo strtolower($_sSystemName); ?>media.com">support@<?php echo strtolower($_sSystemName); ?>media.com</a>.</p>
</div>
<!-- Google Code for Join as Sintext Publisher Conversion Page -->
<script type="text/javascript">
<!--
var google_conversion_id = 1021941679;
var google_conversion_language = "en";
var google_conversion_format = "2";
var google_conversion_color = "ffffff";
var google_conversion_label = "UWZzCLnbxwEQr6-m5wM";
var google_conversion_value = 0;
//-->
</script>
<script type="text/javascript" src="http://www.googleadservices.com/pagead/conversion.js">
</script>
<noscript>
<div style="display:inline;">
<img height="1" width="1" style="border-style:none;" alt="" src="http://www.googleadservices.com/pagead/conversion/1021941679/?label=oVDKCIOYrgEQr6-m5wM&amp;guid=ON&amp;script=0"/>
</div>
</noscript>
<?php
}
else
{
	switch ( $type )
	{
		case JobQueue::SYS_PASSWORD_RESET:
			$_sMessage =<<<HTML
<h1>Your Request Has Been Received</h1>

<div class="copy">
	<p>You will soon receive an email containing a reset password link. You must click the link to reset your password.</p>
</div>
HTML;
			break;
	}
}

echo $_sMessage;