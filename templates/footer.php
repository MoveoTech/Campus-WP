<?php 
global $sitepress;
$current_language = $sitepress->get_current_language();
?>
    <footer class="clearfix" id = "page_footer" role = "contentinfo" >
        <div class="footer-section">
            <div class="container" >
                <div class="footer-section_wrap" >
                    <div class="" id="footer_content_campus_logo" >
                        <?php
                        $campus_logo_footer = get_field('campus_logo_footer', 'options');
                        $url_campus_footer = $campus_logo_footer['url'];
                        $alt_campus_logo = $campus_logo_footer['alt'];
                        ?>
                       <div class='logo-footer'>
                           <img src='<?= $url_campus_footer ?>' alt='<?= cin_get_str('footer_first_logo_alt'); ?>' title='' />
                       </div>
                        <div class="footer-content"><?php the_field('footer_text_after_logo', 'options'); ?></div>
                    </div>
                    <div class="" id="footer_content_social_logo" >
                        <?php
                        $social_equality_logo_footer = get_field('social_equality_logo_footer', 'options');
                        $url_social_equality_footer = $social_equality_logo_footer['url'];
                        $alt = $social_equality_logo_footer['alt'];
                        ?>
                        <div class='logo-footer'>
                            <img src='<?= $url_social_equality_footer ?>' alt="<?= cin_get_str('footer_second_logo_alt'); ?>" title='' />
                        </div>
                        <div class="footer-content"><?php the_field('footer_text_after_social_equality_logo', 'options'); ?></div>
                    </div>
                    <div class="inners-footer-items sahring_wrap">
                        <?php $column_2_title = get_field('column_2_title', 'options');
                        $social_networks = get_field('social_networks', 'options'); ?>
                        <span class="d-block" role="heading" aria-level="4"><?php echo $column_2_title  ?></span>
                        <ul id="" role="navigation">
                            <?php
                            if($social_networks){
                                $go_to_label = cin_get_str('go_to_social_network');
                              foreach ($social_networks as $social_network){
                                  $label = str_replace('%', $social_network['name_of_class'], $go_to_label);
                                  ?>
                                  <li>
                                      <a aria-label="<?= $label; ?>" target="_blank" class="socials-icon <?php echo $social_network['name_of_class'];?>" href="<?php echo $social_network['url'];?>"></a>
                                  </li>
                            <?php  }
                            }?>
                        </ul>
                    </div>
                    <div class="inners-footer-items links_wrap">
                        <?php $column_1_title = get_field('column_1_title', 'options'); ?>
                        <nav id="footer_nav" role="navigation">
<!--                            <h4 aria-level="2">--><?php //echo $column_1_title  ?><!--</h4>-->
                            <?php
                            if (has_nav_menu('footer_menu')) :
                                wp_nav_menu(['theme_location' => 'footer_menu', 'menu_class' => 'nav']);
                            endif;
                            ?>
                        </nav>
                    </div>
                </div>
            </div>
        </div>
        <a href="#" class="scroll-top  d-none" role="button" tabindex="0" aria-label="<?=  __('scroll to the top of page','single_corse') ?>">
                <i class="fa fa-chevron-up"></i>
        </a>
        <div class="copyright">
            <?php $copyright = get_field('copyright', 'options'); ?>
            <p><?php echo date('Y');  ?> &copy; <?php echo $copyright ?></p>
        </div>
        <input type="hidden" id="current_lang" name="current_lang" value="<?= $current_language; ?>">
<!--        empty html to popup course-->
        <div id="popup-course-hp">
            <div class="popup-loader" style="background-image:url(<?= get_bloginfo('stylesheet_directory') . '/assets/images/loader-popup.gif'; ?>)"></div>
            <div class="close-popup-course">
                <button  aria-label="<?= cin_get_str('close_btn_popup'); ?>" class="close-popup-course-button last-popup-element first-popup-element close-popup-button"></button>
            </div>
            <div class="row">
                <div class="col-xl-8 -col-sm-12 col-lg-12 col-md-12 col-xs-12">
                    <div class="iframe_wrap">
                        <iframe class="popup-video" title="" src="">
                        </iframe>
                    </div>
                </div>
                <div class="col-sm-12 col-xl-4 col-lg-12 col-md-12 col-xs-12">
                    <div class="popup_left_side">
                        <h2 class="pupup_text">&nbsp</h2>
                        <P class="p_border-bottom excerpt">&nbsp</P>
                        <div class="mediapupup">
                            <div class="mediapupup-right">
                                <div class="img-circle popup-lecturer-thumbnail" style="background-image: url(<?= get_bloginfo('stylesheet_directory') . '/assets/images/campus_avatar.png' ?>)"></div>
                            </div>
                            <div class="mediapupup-body">
                                <p class="mediapupup-heading">&nbsp</p>
                                <p class="popup-academic-institution-title">&nbsp</p>
                            </div>
                        </div>
                        <div class="time course-item-duration popup-duration-popup-course">&nbsp</div>
                        <span class="popup-course-link"><a href="" class="rounded-rectangle-16 popup-course-link-inner">
                            <span data-type="course"><?= cin_get_str('Course_Page') ?></span>
                            <span data-type="event"><?= cin_get_str('to_event_page') ?></span>
                        </a></span>
                    </div>
                </div>
            </div>
        </div>
<!--        End empty html to popup course-->
        <div id="popup_overlay">
            <div aria-hidden="true" id="popup" class="dialog" role="dialog" aria-model="true">
                <button aria-label="<?= cin_get_str('close_btn_popup'); ?>" class="last-popup-element first-popup-element close-popup-button close-popup-iframe" role="button" tabindex="0"></button>
                <div class="pop_iframe">

                </div>
            </div>
        </div>
<!--        03/06/2020 new version popups     -->
        <div id="popup_overlay_2020" tabindex="0"><?php do_action('site_popups')?></div>
<!--      End 03/06/2020 new version popups     -->
    </footer>
    <div class="background-popup"></div>
<script>
    function ajax_dir(){
        return '<?php echo get_bloginfo('stylesheet_directory');  ?>/assets/ajax/';
    }
</script>
