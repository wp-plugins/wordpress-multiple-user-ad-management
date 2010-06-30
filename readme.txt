=== Plugin Name ===
Contributors: Manthan
Plugin Homepage: http://www.ravall.com/2010/06/28/wordpress-multiple-user-ad-management-plugin/
Tags: multiple authors, ad management, ravall, advertisements, banners, php, monitize posts
Requires at least: 2.0.2
Tested up to: 3.0
Stable tag: 1.0

The plugin is ideal for blogs with multiple authors and acts as an incentive for making quality posts. 

== Description ==

The plugin is ideal for blogs with multiple authors and acts as an incentive for making quality posts. When the add-on is enabled, users will have full control over the advertisements displayed on their own posts. Using a space preallocated by the blog administrator, authors will be able to display various forms of advertisements in addition to accepting Paypal donations. This, in turn will also motivate writers to increase the frequency and quality of posts in order to reach a higher popularity and maximize the ability to monetize. 

Features:

   1. Ability to change advertisement settings through a graphical interface on the fly.
   2. Users can display image ads, input their own <HTML> codes (with admin verification), or accept donations by entering their Paypal account. With respect to image ads, users can also specify a time limit until the advertisement expires.
   3. As an added layer of security, the plugin will not be seen by users with a subscriber status. Since users with the power to post on your blog are typically trusted, the worry of misuse should be minimized. Despite this, we have sanitized all the inputs besides the Code textarea. To eliminate it’s misuse, the field is disabled until access is granted by an administrator.


== Installation ==

1. Without changing anything (Not even the folder name), place the extracted multiauthor folder into the `/wp-content/plugins/` directory of your WordPress installation.
2. Login to the administrative panel of the WordPress installation and activate the plugin. At this point in time, a MU Ad management option should appear on the admin navigation bar. This option will be visible to authors on your blog as well.
3. In order to actually display the ads, we need to call the function: `<?php mu_sidebar(get_the_author_id()); ?>`. Wherever this function is placed, the ad will show. As you may be able to tell, on Ravall.com we have included this function at the bottom of the sidebar.

*If for some reason these installation instructions do not appear normal, please go to: http://www.ravall.com/2010/06/28/wordpress-multiple-user-ad-management-plugin/

== Frequently Asked Questions ==

= There is something wrong with my installation. Where can I get help? =
In order to receive assistance from the author of the plugin, feel free to click the following link and leave a comment requesting assistance. Please visit: [Ravall](http://ravall.com/ "The everything interesting blog") to further discuss this plugin with the author.

= Will this plugin be updated in the future? =
Of course! We plan on expanding and refining this plugin significantly based on the input received by our users. The feedback we receive from you will ultimately shape future releases.

= Am I allowed to modify the code? =
We encourage modification and redistribution of the code as long as it remains free.

== Screenshots ==

1. This image displays the settings that can be configured through the administrative panel. Normal subscribers cannot see these settings. `/tags/1.0/screenshot-1.jpg`

== Changelog ==

This is the first release. No Changelog at the moment.

== Upgrade Notice ==

No upgrades at the moment

== Configuration ==

1. The first thing we need to configure is, the maximum size of custom (image) ads allowed. To do so, open the file, adminpanel.php and edit the variables, `$maximagewidth & $maximageheight`. The default values for these two variables are 152X172. Users will not be able to link to image files that are larger than the maximum restriction set by these two variables.
   
2. All the actual outputting is done by 'multiauthorcommerce.php'. If you dislike any message displayed by the script, simply navigate to this file and make the change.