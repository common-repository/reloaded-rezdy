 <div id="wpbody">
    <div id="wpbody-content">
        <div class="wrap">
            <h2>
                <?php _e("Rezdy Reloaded Settings","reloaded-rezdy"); ?>
            </h2>
            
            <div id="rzd_setting_save_msg">
                <?php _e('Settings updated successfully','reloaded-rezdy') ?>
            </div>
        
            <div class="rzd_settings_left">
                <div class="rzd_settings_left_heading">
                    <h3><?php  _e("Settings","reloaded-rezdy") ?></h3>
                </div>

                <div class="rzd_settings_left_wrap">
                    <form method="post">

                        <table width="100%" border="0" cellspacing="4" cellpadding="2">
                            <tr>
                                <td width="21%">
                                    <strong><?php _e("Customise Base Slug","reloaded-rezdy"); ?></strong>
                                </td>
                                <td colspan="3">
                                    <input type="text" name="rzd_post_name_slug" id="rzd_post_name_slug" value="<?php echo RZD_POST_NAME_SLUG ?>" />
                                    <input type="hidden" name="rzd_post_name_slug_old" id="rzd_post_name_slug_old" value="<?php echo RZD_POST_NAME_SLUG ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="3">
                                    <span>
                                        <em><?php _e("Please use only letters and dashes. Special characters(!@#$%^&*()+=:;<>,_.?/\|~`) are prone to breakage","reloaded-rezdy"); ?></em>
                                      <br /><br />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong><?php _e("Show Categories","reloaded-rezdy"); ?></strong>
                                    <br /><br />
                                </td>
                                <td colspan="3">
                                    <?php _e('Check for showing categories','reloaded-rezdy')?>
                                    <input type="checkbox" name="rzd_post_category" id="rzd_post_category" <?php checked(RZD_POST_CATEGORY, 'on'); ?> />
                                    <br /><br />
                                </td>
                            </tr>
                            <tr>
                                <td><strong><?php _e("Thumbnail Width","reloaded-rezdy"); ?></strong></td>
                                <td width="30%">
                                    <input type="text" name="rzd_thumbnail_width" id="rzd_thumbnail_width" value="<?php echo RZD_THUMBNAIL_WIDTH ?>" style="width:80%;" />
                                </td>
                                <td width="19%"><strong><?php _e("Thumbnail Height","reloaded-rezdy"); ?></strong></td>
                                <td width="30%">
                                    <input type="text" name="rzd_thumbnail_height" id="rzd_thumbnail_height" value="<?php echo RZD_THUMBNAIL_HEIGHT ?>" style="width:80%;" />
                                </td>
                            </tr>
                            <tr>
                                <td><strong><?php _e("Main Image Width","reloaded-rezdy"); ?></strong></td>
                                <td width="30%">
                                    <input type="text" name="rzd_image_width" id="rzd_image_width" value="<?php echo RZD_IMAGE_WIDTH ?>" style="width:80%;" />
                                </td>
                                <td width="19%"><strong><?php _e("Main Image Height","reloaded-rezdy"); ?></strong></td>
                                <td width="30%">
                                    <input type="text" name="rzd_image_height" id="rzd_image_height" value="<?php echo RZD_IMAGE_HEIGHT ?>" style="width:80%;" />
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="3">
                                    <span>
                                        <em><?php _e("It is best to set image dimensions here BEFORE you start uploading items. Images may become warped if you change this setting later.","reloaded-rezdy");	?></em>
                                      <br /><br />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>
                                    <strong><?php _e("Rezdy Link","reloaded-rezdy"); ?></strong>
                                </td>
                                <td colspan="3">
                                    <input type="text" name="rzd_api_link" id="rzd_api_link" value="<?php echo RZD_API_LINK ?>" />
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="3">
                                    <span>
                                        <em><?php _e("This is your Rezdy catalog URL eg. https://yourcompany.rezdy.com","reloaded-rezdy"); ?></em>
                                        <br /><br />
                                    </span>
                                </td>
                            </tr>
                            <tr>
                                <td>&nbsp;</td>
                                <td colspan="3" align="right">
                                    <input type="button" name="rzd_save_settings_btn" id="rzd_save_settings_btn" value="<?php _e("Save Changes","reloaded-rezdy") ?>" />
                                </td>
                            </tr>
                        </table>
                    </form>
                </div>

                <div>
                    <h3>
                        <?php  _e("About this Plugin","reloaded-rezdy") ?>
                    </h3>
                    <p>
                        <?php  _e("Rezdy Reloaded is a neat integration between Rezdy booking software and WordPress. It is based on a WordPress custom post type, allowing you to manage your tour info on the WordPress side, giving you full control over content, visual design and SEO. It displays the Rezdy booking widget to the right, sending customers over to Rezdy to complete checkout.","reloaded-rezdy") ?>
                    </p>
                    <h3>
                        <?php  _e("Step by Step Setup","reloaded-rezdy") ?>
                    </h3>
                    <p>
                        <?php  _e("1.) Get setup over on the Rezdy side. At a minimum, you'll need to have a Rezdy account with some Inventory items created.","reloaded-rezdy") ?>
                    </p>
                    <p>
                        <?php  _e("2.) Customise the settings above as needed and save.","reloaded-rezdy") ?>
                    </p>
                    <p>
                        <?php  _e("3.) In WordPress, go to Rezdy Reloaded > Add Item. Add one item in WordPress for each of your Rezdy Inventory items aka the product/class/tour you want to sell.","reloaded-rezdy") ?>
                    </p>
                    <p>
                        <?php  _e("4.) When you're ready to see how it looks on the front end, visit http://yourdomain/rezdy-items. Obviously you'll need to replace yourdomain in that URL with your actual domain, and if you've customised the base slug use that instead of rezdy-items.","reloaded-rezdy") ?>
                    </p>
                    <p>
                        <?php  _e("5.) That's the basics done. Hopefully that's enough to get you started. Anything more advanced can be achieved by customising the templates and CSS (see below for more info.) Thanks and enjoy.","reloaded-rezdy") ?>
                    </p>
                    <h3>
                        <?php  _e("How do I customise the design/layout?","reloaded-rezdy") ?>
                    </h3>
                    <p>
                        <?php  _e("Developers, you can completely customise the way the post type displays by copying the plugin templates to your theme and customising them there. You may be familiar with this method of templating as used by WooCommerce. In the plugin's root directory you will find a folder called rezdy-template. You can override that folder and any of the files within, by copying them into your active theme ie. yourtheme/rezdy-template. Rezdy Reloaded plugin will automatically load any template files you have in that folder in your theme, and use them instead of its default template files. If no such folder or files exist in your theme, it will use the ones from the plugin. This is the safest way to customise the Rezdy Reloaded templates, as it means that your changes will not be overwritten when the plugin updates.","reloaded-rezdy") ?>
                    </p>
                    <h3>
                        <?php  _e("How can I customise the booking widget & checkout?","reloaded-rezdy") ?>
                    </h3>
                    <p>
                        <?php _e("The booking widget is pulled in from Rezdy using an iFrame, and your users will be redirected to checkout on your Rezdy hosted site. This is currently just the way Rezdy works - there is no way around this. Thus, if you want to customise the design of the booking widget and/or checkout then you must do so via Rezdy.","reloaded-rezdy");?> <a href="https://support.rezdy.com/hc/en-us/articles/203690694-How-to-setup-your-booking-form">Tutorial here.</a>
                    </p>
                </div>
				
            </div>

            <div class="rzd_settings_right">
                <table cellpadding="0" class="widefat donation" style="margin-bottom:10px; border:solid 2px #008001;" width="50%">
                    <thead>
                    <th scope="col">
                        <strong style="color:#008001;"><?php _e('Help Improve This Plugin!','reloaded-rezdy') ?></strong>
                    </th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border:0;">
                                <?php _e('Enjoyed this plugin? All donations are used to improve and further develop this plugin. Thanks for your contribution.','reloaded-rezdy') ?>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0;">
                                <form action="https://www.paypal.com/cgi-bin/webscr" method="post" target="_blank">
                                    <input type="hidden" name="cmd" value="_s-xclick">
                                    <input type="hidden" name="hosted_button_id" value="A74K2K689DWTY">
                                    <input type="image" src="https://www.paypalobjects.com/en_AU/i/btn/btn_donateCC_LG.gif" border="0" name="submit" alt="PayPal — The safer, easier way to pay online.">
                                    <img alt="" border="0" src="https://www.paypalobjects.com/en_AU/i/scr/pixel.gif" width="1" height="1">
                                </form>
                            </td>
                        </tr>
                        <tr>
                            <td style="border:0;"><?php _e('you can also help by','reloaded-rezdy') ?>
                                <a href="https://wordpress.org/support/view/plugin-reviews/reloaded-rezdy" target="_blank">
                                    <?php _e('rating this plugin on wordpress.org','reloaded-rezdy')?>
                                </a>
                            </td>
                        </tr>
                    </tbody>
                </table>

                <table cellpadding="0" class="widefat" border="0">
                    <thead>
                    <th scope="col"><?php _e('Need Support?','reloaded-rezdy') ?></th>
                    </thead>
                    <tbody>
                        <tr>
                            <td style="border:0;">
                                <?php _e('Please visit the','rzd') ?>
                                <a href="https://wordpress.org/plugins/reloaded-rezdy/faq/" target="_blank"><?php _e('FAQs','reloaded-rezdy'); ?></a>
                                <?php _e('or','rzd') ?>
                                <a href="https://wordpress.org/support/plugin/reloaded-rezdy" target="_blank"><?php _e('Support Forum','reloaded-rezdy') ?></a>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

