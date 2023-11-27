# Huawei Cloud OBS download for WordPress

This repository contains a PHP snippet code for WordPress to provide temporary
links to [Huawei Cloud OBS][obs] objects.

When used together with [PublishPress Permissions][publishpress-permissions]
plugin, it is possible to have full control over your Media files, that is,
control which roles/user groups can download a file.

Tested in WordPress 6.4.1 and PHP 8.3.

## Huawei Cloud preparation instructions

1. Create an IAM User in your Huawei Cloud account, selecting only
   "Programmatic access" as Access Type. Do not assign it to any
   group neither give any permission. Download the credentials file
   which contains the AK and SK;
2. Create an OBS bucket, selecting "Private" as Bucket Policy;
3. Create a Bucket Policy, using the "Bucket read-only" template and
   configuring the IAM User in the "Principal" section;
4. In the bucket Overview section, copy the "Access Domain Name" attribute.

## WordPress install instructions

1. Install [WPCode Lite plugin][wpcode];
2. In the side menu, under "Code Snippets", click on "+ Add Snippet";
3. Click on "create your own" or search for "Add Your Custom Code (New
   Snippet)";
4. Name it "OBS Download Button";
5. Select "PHP Snippet" as Code Type;
6. Copy all this code and paste in the Code Preview section;
7. Update `$ACCESS_KEY`, `$SECRET_KEY` and `$OBS_ACCESS_DOMAIN_NAME`. Also
   update `$LINK_EXPIRATION_SECS`, `$DOWNLOAD_EXPIRED_TEXT` and
   `$BUTTON_TEMPLATE` if you wish;
8. Select "Shortcode" as Insert Method;
9. Add "object_path" as Shortcode Attributes;
10. Back to the top of the page, toggle the "Inactive" switch (it will become
    "Active") and then click on "Save Snippet";

## Usage Instructions

1. In the Huawei Cloud OBS Console, upload a file to the OBS bucket
2. In the WordPress dashboard, go to the Code Snippets list and click on
   the "OBS Download Button" snippet.
3. In Insertion > Shortcode, click on "Copy"
4. In the WordPress post, add a Shortcode block
5. Paste the Shortcode that was copied in the step 3
6. In the Huawei Cloud OBS Console, in the OBS object "Operation" column,
   click on "More" and then on "Copy Path"
7. Paste the object path inside the double quotes of object_path short code
   attribute.

## References

- Accessing OBS Using a Temporary URL:
  <https://support.huaweicloud.com/intl/en-us/perms-cfg-obs/obs_40_0009.html>
- Authentication of Signature in a URL:
  <https://support.huaweicloud.com/intl/en-us/api-obs/obs_04_0011.html>

[obs]: <https://support.huaweicloud.com/intl/en-us/obs/index.html>
[publishpress-permissions]: <https://wordpress.org/plugins/press-permit-core/>
[wpcode]: <https://wordpress.org/plugins/insert-headers-and-footers/>
