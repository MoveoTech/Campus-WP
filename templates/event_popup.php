<?php
global $site_settings, $fields, $event_id_for_popup;
$event = $event_id_for_popup ? get_post($event_id_for_popup) : $fields["choose_event"];
echo "<div style='display: none;' data-testdate=" . strtotime(date('m/d/Y')) . '"></div>';
if ($event) {
    if (get_post_status($event) == 'publish') {
        $event_fields = get_fields($event);

        // אם האירוע עבר - לא להציג את הפופאפ
        $today = strtotime(date('m/d/Y'));
        $event_date = strtotime($event_fields['event_date']);
        if ($today <= $event_date) {
            $date_event = get_event_date($event_fields['event_date'], $event_fields['event_time'], true);
            $type = $event_fields['event_type'];
            $type_img = get_field('img_popup_event', $type);
            $event_title = $event_fields['event_title'];
            $description_event = $event_fields['description_event'];
            $btn_txt = $event_fields['btn_txt'];
            $btn_link = $event_fields['btn_link'];
            $lecture = $event_fields['lecture'];
            $Location = $event_fields['Location'];
            $image_popup_event = $event_fields['image_popup_event'];
            $trailer_popup_event = $event_fields['trailer_popup_event'];
            $query_string = array();
            parse_str(parse_url($trailer_popup_event, PHP_URL_QUERY), $query_string);
            $trailer_id = ($trailer_popup_event) ? $query_string["v"] : '';
            $image_popup_event_mobile = $event_fields['image_popup_event_mobile'];
            $lecturer_single_id = $lecture->ID;
            $rol_single_course = get_field('role', $lecturer_single_id);
            $title_lecturer = $lecture->post_title;

            ?>
            <div id="popup_overlay_new_event" data-id="<?= $event->ID; ?>" class="hide"
                 data-date="<?= strtotime($event_fields['event_date']); ?>">
                <div id="popup_new_event" aria-modal="true" role="dialog" aria-hidden="false">
                    <div class="close-popup-course">
                        <button aria-label='<?= cin_get_str('close_btn_popup'); ?>'
                                class="close-popup-course-button last-popup-element first-popup-element close-popup-button"></button>
                    </div>
                    <div id="event_popup_content_container">
                        <div class="banner-wrapper about-course gray-part">
                            <div class="gray-on-banner about-course gray-part d-xs-none d-lg-inline-block"></div>
                            <div class="icons-on-banner"
                                 style="background-image: url(<?= get_bloginfo('stylesheet_directory') . '/assets/images/blue-removebg-preview.png' ?>)"></div>
                            <div class="icons-on-banner icons-on-banner-2"
                                 style="background-image: url(<?= get_bloginfo('stylesheet_directory') . '/assets/images/blue-removebg-preview.png' ?>)"></div>
                            <div class="banner-image about-course gray-part d-none d-lg-inline-block"
                                 style="background-image: url(<?= $image_popup_event; ?>)">
                                <?php if ($trailer_popup_event) {
                                    echo '<a href="#" aria-haspopup="true" role="button" title="' . $event_title . '"
                                   data-url="https://www.youtube.com/embed/' . $trailer_id . '?autoplay=1&showinfo=1&autohide=1&rel=0&enablejsapi=1&wmode=transparent"
                                   class="popup-about-course-video open-popup-button-2020"></a>';
                                } ?>
                            </div>
                            <div class="background-on-banner about-course gray-part">
                                <div class="text-on-banner about-course gray-part centering-on-banner">
                                    <h2 class="title-course"><?= wrap_text_with_char($event_title); ?></h2>
                                    <p class="excerpt-course"><?= $description_event; ?></p>
                                    <span class="signup-course-button-wrap">
                            <a class="signup-course-button con_to_course" tabindex="0" href="<?= $btn_link; ?>"><?= $btn_txt; ?></a>
                        </span>
                                </div>
                            </div>

                            <div class="banner-image about-course gray-part mobile d-sm-block d-lg-none d-xs-block"
                                 style="background-image: url(<?= $image_popup_event_mobile; ?>)">
                                <?php if ($trailer_popup_event) {
                                    echo '<a href="#" aria-haspopup="true" role="button"  title="' . $event_title . '"
                                   data-url="https://www.youtube.com/embed/' . $trailer_id . '?autoplay=1&showinfo=1&autohide=1&rel=0&enablejsapi=1&wmode=transparent"
                                   class="popup-about-course-video open-popup-button-2020"></a>';
                                } ?>
                            </div>
                        </div>
                        <div class="information-bar">
                            <div class="information-bar-inner">
                                <div class="container">
                                    <div class="warp-lecture col-3">
                                        <div class="name_lecturer"><?= $title_lecturer; ?></div>
                                        <div class="role_lecturer"><?= $rol_single_course; ?></div>
                                    </div>
                                    <div class="warp-info col-7">
                                        <div class="bar-info start-bar-info">
                                            <div class="start-date-title-bar title-bar"><?= __('Date', 'single_corse'); ?></div>
                                            <p class="text-bar-course"><?= $date_event; ?></p>
                                        </div>
                                        <div class="bar-info duration-bar-info">
                                            <div class="duration-bar title-bar"><?= cin_get_str('location'); ?></div>
                                            <p class="text-bar-course"><?= $Location; ?></p>
                                        </div>
                                        <div class="bar-info price-bar-info">
                                            <div class="price-course-bar title-bar"><?= __('Price', 'single_corse'); ?></div>
                                            <p class="text-bar-course"><?= __('free', 'single_corse'); ?></p>
                                        </div>
                                    </div>
                                    <div class="org-logo col-2">
                                        <div style="background-image: url(<?= $type_img; ?>)"
                                             class="academic-course-image"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php }
    }

} ?>

