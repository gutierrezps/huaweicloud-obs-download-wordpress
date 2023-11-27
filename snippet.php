<?php
/**
 * OBS Download Button - PHP Code Snippet for WordPress
 * Author: Gabriel Gutierrez PS
 * Available at: <https://github.com/gutierrezps/huaweicloud-obs-download-wordpress>
 * Version: 1.0 - 2023-11-27
 */

// Parameters that must be updated with your data
$ACCESS_KEY = "...";
$SECRET_KEY = "...";
$OBS_ACCESS_DOMAIN_NAME = "example.obs.la-south-2.myhuaweicloud.com";

// ----------------------------------------------------------------------------
// Parameters that can be customized if you wish
$LINK_EXPIRATION_SECS = 10 * 60;
$DOWNLOAD_EXPIRED_TEXT = "Download expired, please refresh the page";

// Make sure to add href="{{download_url}}" and id="{{button_id}}"
// to the <a> tag.
$BUTTON_TEMPLATE = <<<TEMPLATE
<div class="wp-block-buttons is-layout-flex wp-block-buttons-is-layout-flex">
	<div class="wp-block-button has-custom-width wp-block-button__width-100 has-custom-font-size is-style-fill has-medium-font-size">
		<a class="wp-block-button__link wp-element-button" style="padding-top:var(--wp--preset--spacing--10);padding-right:0;padding-bottom:var(--wp--preset--spacing--10);padding-left:0" href="{{download_url}}" id="{{button_id}}" target="_blank">Download</a>
	</div>
</div>
TEMPLATE;

// ----------------------------------------------------------------------------
// SNIPPET CODE
// References:
// - Accessing OBS Using a Temporary URL
//   <https://support.huaweicloud.com/intl/en-us/perms-cfg-obs/obs_40_0009.html>
// - Authentication of Signature in a URL
//   <https://support.huaweicloud.com/intl/en-us/api-obs/obs_04_0011.html>

$now_secs = time();
$expires = $now_secs + $LINK_EXPIRATION_SECS;

$bucket_name = explode(".", $OBS_ACCESS_DOMAIN_NAME)[0];
// canonicalized_headers is empty, so it's not present in string_to_sign
$canonicalized_resource = "/$bucket_name/$object_path";

$string_to_sign  = "GET\n";		// HTTP Verb
$string_to_sign .= "\n";		// Content-MD5 (empty)
$string_to_sign .= "\n";		// Content-Type (empty)
$string_to_sign .= "$expires\n";
$string_to_sign .= "$canonicalized_resource";

$signature_bin = hash_hmac("sha1", $string_to_sign, $SECRET_KEY, true);
$signature = urlencode(base64_encode($signature_bin));

$download_url  = "https://$OBS_ACCESS_DOMAIN_NAME/$object_path"
$download_url .= "?AccessKeyId=$ACCESS_KEY&Expires=$expires"
$download_url .= "&Signature=$signature";

// Random ID is generated in case multiple buttons are added to the same page
$download_id = uniqid("", true);    // no prefix, more_entropy=true
$button_id = "download-$download_id";
$function_id = "download_${download_id}_expired";

$js_code = <<<JSCODE
<script>
function $function_id() {
	let download_button = document.getElementById('$button_id');
	download_button.setAttribute('href', '#');
	download_button.setAttribute('target', '_self');
	download_button.innerHTML = "$DOWNLOAD_EXPIRED_TEXT"
}
setTimeout($function_id, $LINK_EXPIRATION_SECS * 1000);
</script>
JSCODE;

$button_code = strtr(
  $BUTTON_TEMPLATE,
  array(
    "{{download_url}}" => $download_url,
    "{{button_id}}" => $button_id
  ));

echo $button_code;
echo $js_code;
?>
