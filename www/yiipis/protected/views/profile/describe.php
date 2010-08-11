<?php
header( 'Content-type: application/xml' );
?>
<?xml version='1.0' encoding='UTF-8'?>
<XRD xmlns='http://docs.oasis-open.org/ns/xri/xrd-1.0'>
    <Subject><?php echo $uri; ?></Subject>
	<Alias>http://yiipis.com/~<?php echo $uri; ?></Alias>
</XRD>
