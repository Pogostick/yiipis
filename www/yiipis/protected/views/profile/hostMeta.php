<?php
header( 'Content-type: application/xml' );
?>
<?xml version='1.0' encoding='UTF-8'?>
<XRD xmlns='http://docs.oasis-open.org/ns/xri/xrd-1.0' xmlns:hm='http://host-meta.net/xrd/1.0'>
	<hm:Host>yiipis.com</hm:Host>
	<CanonicalID>yiipis.com</CanonicalID>
	<Service priority="0" xmlns:openid="http://openid.net/xmlns/2.5">
		<Type>http://www.iana.org/assignments/relation/describedby</Type>
		<MediaType>application/xrds+xml</MediaType>
		<openid:URITemplate>https://www.yiipis.com/~{%uri}</openid:URITemplate>
		<openid:NextAuthority>hosted-id.yiipis.com</openid:NextAuthority>
	</Service>

	<Link rel='lrdd' template='http://yiipis.com/profile/describe?uri={uri}'>
		<Title>Resource Descriptor</Title>
	</Link>
</XRD>
