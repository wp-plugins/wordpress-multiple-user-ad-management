=== Plugin Name ===
Contributors: Manthan
Donate link: http://sourceforge.net/project/project_donations.php?group_id=331492
Tags: multiple authors, ad management, ravall, advertisements, banners, php, monetize posts
Requires at least: 2.0.2
Tested up to: 3.0
Stable tag: 1.0.3

The plugin is ideal for blogs with multiple authors and acts as an incentive for making quality posts.

== Description ==

The plugin is ideal for blogs with multiple authors and acts as an incentive for making quality posts. When the add-on is enabled, users will have full control over the advertisements displayed on their own posts. Using a space preallocated by the blog administrator, authors will be able to display various forms of advertisements in addition to accepting Paypal donations. This, in turn will also motivate writers to increase the frequency and quality of posts in order to reach a higher popularity and maximize the ability to monetize. 


Features:

   1. Ability to change advertisement settings through a graphical interface on the fly.
   2. Users can display custom image ads, input their own <HTML> codes (with admin verification), enter text links or accept donations by entering their PayPal account. With respect to custom image ads, users can also specify a time limit until the advertisement expires.
   
   3. The latest revision of the scriptvadds the ability to track click/impression statistics for various ad types.
   
   4. The ability to hide advertisements from logged in users is controllable through administrative panel.
   
   5. Admins can control ad rotation ratio if 100% revenue sharing with authors is not desired.
   6. Admins can decide the minimum userlevel (Subscriber, Contributor…) needed in order to access the configuration panel
   7. We have sanitized all the inputs besides the code textarea. To eliminate it's misuse, the field is disabled until access is granted by an administrator.

== Installation ==

Installation

1. Without changing anything (Not even the folder name), place the extracted multiauthor folder into the `/wp-content/plugins/` directory of your WordPress installation.
2. Ensure that the plugin directory name is `/wordpress-multiple-user-ad-management/`. Changing it to something else may cause issues with the code verification process.
3. Login to the administrative panel of the WordPress installation and activate the plugin. At this point in time, a MU Ad management option should appear on the admin navigation bar. This option will be visible to authors on your blog as well.
4. In order to actually display the ads, we need to call the function: `<?php mu_sidebar(get_the_author_id()); ?>`. Wherever this function is placed, the ad will show. As you may be able to tell, on Ravall.com we have included this function at the bottom of the sidebar. Please note that, the function `get_the_author_id()` only works during/after the Wordpress posts loop!
5. Don't want to do 100% revenue sharing? Go to the admin settings and set a percentage value. This in turn will allow rotation between your ads and the author of the post's ads.

Configuration 

1. The first thing we need to configure is, the maximum size of custom (image) ads allowed. To do so, open the file, `adminpanel.php` and edit the variables, `$maximagewidth & $maximageheight`. The default values for these two variables are `250X250`. Users will not be able to link to image files that are larger than the maximum restriction set by these two variables.
2. All the actual outputting is done by `multiauthorcommerce.php`. If you dislike any message displayed by the script, simply navigate to this file and make the change.
3. Additional configurations can be performed by logging into a Wordpress administrative account and clicking on the "Admin Settings" submenu from the left-hand navigation.

*If for some reason these installation instructions do not appear normal, please go to: http://www.ravall.com/2010/06/28/wordpress-multiple-user-ad-management-plugin/


== Frequently Asked Questions ==

= There is something wrong with my installation. Where can I get help? =
In order to receive assistance from the author of the plugin, feel free to click the following link and leave a comment requesting assistance. Please visit: [Ravall](http://ravall.com/ "The everything interesting blog") to further discuss this plugin with the author.

= Will this plugin be updated in the future? =
Of course! We plan on expanding and refining this plugin significantly based on the input received by our users. The feedback we receive from you will ultimately shape future releases.

= Am I allowed to modify the code? =
We encourage modification and redistribution of the code as long as it remains free.

= Where can I request new features? =
Visit the plugin homepage in order to request new features.



= The plugin only displays advertisements from the Default Admin account! =

99% of the time this occurs as, `get_the_author_id()` Wordpress function is transferring a value of `0` to `mu_sidebar()`. In order to fix this, relocate the `<?php mu_sidebar(get_the_author_id()); ?>` after the Wordpress loop. Additionally, you may ` replace get_the_author_id()`  with another function that inputs a userid value.


== Screenshots ==

1. Settings within the administrative panel. This panel will be hidden from users below the minimum role threshold.



2. Administrative settings. Only visible to users who have a Administrator Role.

== Changelog ==

= 1.0.1 =
An issue present with the verification process was resolved. The folder name assigned by wordpress and the one the plugin was searching for initially differed.

= 1.0.2 =
As requested by many, added the ability to set a percentage value in order to rotate between your ads and the author of the post's ads.


= 1.0.3 =
Click/Impressions tracking for various ad types has been enabled. Fixed an issue with verify.php that individuals on a subdirectory were experiencing.
UI changes have been made. 
The ability to display text links has been added. One issue with mu_sidebar() function has been resolved. 
The ability to hide advertisements from registered users has been added.
Error messages have been replaced with the ability to display a default user ad.
The ability to decide the default advertisement user has been added.
The ability to choose the minimum userlevel needed to display ads has been added.



== Upgrade Notice ==

= 1.0.1 =
An issue present with the verification process was resolved. The folder name assigned by Wordpress and the one the plugin was searching for initially differed. Ensure the plugin directory is named `/wordpress-multiple-user-ad-management/`

= 1.0.2 =
New feature added as promised. The ability to rotate between your ads and author of the posts ads has been added.



= 1.0.3 =

Numerous significant changes and fixes have been made to the plugin. Refer to the Changelog for more information.
