<?php
$user_courses = get_user_courses_link();
$user_name = get_user_hello();
$user_login = get_user_login();
?>
    <header class="above-banner header_wrap" role="above_banner">
        <!--    <div class="container">-->
        <div class="container-fluid">
            <div class="header_container">
                <div class="row">
                    <div class="col-12 col-lg-6 images-wrap">
                        <div class="img_logo_wrap">
                            <?php
                            $campus_logo_header = get_field('campus_logo_header', 'options');
                            $url_campus_logo_header = $campus_logo_header['url'];
                            ?>
                            <a class="campus_logo" href="<?= esc_url(home_url('/')); ?>">
                                <img src="<?= $url_campus_logo_header ?>" alt="<?= cin_get_str('header_campus_logo_alt') ?>"/>
                            </a>
                            <?php

                            $social_equality_logo_header = get_field('social_equality_logo_header', 'options');
                            $url_social_equality_logo_header = $social_equality_logo_header['url'];
                            $logo_header_extra = get_field('logo_header_extra', 'options');
                            $url_logo_header_extra = $logo_header_extra['url'];
                            ?>
                            <img class="social-logo" src="<?= $url_logo_header_extra ?>" alt="<?= cin_get_str('header_second_logo_alt') ?>" />
                            <img class="social-logo digital-isreal-logo" src="<?= $url_social_equality_logo_header ?>"
                                 alt="<?= cin_get_str('header_third_logo_alt') ?>"/>
                        </div>
                    </div>
                    <div class="d-sm-block d-inline-block nav-mobile-btn-wrap d-lg-none d-xs-none">
                        <button class="navbar-toggle navbar-light navbar-mobile-button" type="button"
                                aria-expanded="false"
                                aria-label="Toggle navigation">
                            <span></span>
                            <span></span>
                            <span></span>
                        </button>
                    </div>
                    <div class="col-12 col-lg-6 wrap-side-menu align-self-center">
                        <div class="login_search_lang_wrap d-flex justify-content-lg-end justify-content-between align-items-center">
                            <div class="search-form">
                                <?php get_search_form(); ?>
                            </div>
                            <div class="d-block d-lg-none header_login_area">
                                <?= $user_login; ?>
                                <div class="user-connect show_for_connected_user has_profile_icon">
                                    <span class="d-none d-md-inline"><?= $user_name; ?></span>
                                    <?= $user_courses; ?>
                                </div>
                            </div>
                            <div class="lang d-none d-lg-inline-block languages_menu_wrap">
                                <button role="combobox" aria-expanded="false" class="dropdown_langs_btn"><?= cin_get_str('header_current_languages'); ?></button>
                                <?= get_lang_menu(); ?>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="nav-campus-inner-wrap">
            <div class="container">
                <div class="position-header-mobile">
                    <div class="menu-header nav-mobile-campus">
                        <div id="header_flex" class="d-lg-flex justify-content-between align-items-center">
                            <div class="header_login_area">
                                <span class="d-none d-lg-inline"><?= $user_login; ?></span>
                                <div class="d-block d-md-none d-lg-inline-block user-connect show_for_connected_user">
                                    <span id="connected_user_desktop_and_mobile" class="has_profile_icon">
                                        <?= $user_name; ?>
                                        <span class="d-inline-block d-lg-none header_connected_label"><?= cin_get_str('header_connected'); ?></span>
                                    </span>
                                    <span class="d-none d-lg-inline"><?= $user_courses; ?></span>
                                </div>
                            </div>
                            <nav class="header-nav" id="header_primary_nav" role="menu">
                                <div class="nav-mobile-campus-inner">
                                    <?php
                                    if (has_nav_menu('primary_navigation')) :
                                        wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
                                    endif;
                                    ?>
                                    <div class="d-sm-block d-lg-none d-xs-block lang languages_menu_wrap">
                                        <button role="combobox" aria-expanded="false" class="dropdown_langs_btn"><?= cin_get_str('header_languages'); ?></button>
                                        <?= get_lang_menu(); ?>
                                    </div>
                                </div>
                            </nav>
                        </div>
                    </div>
                </div>
            </div>
            <!--    </div>-->
    </header>
<?php
function get_user_courses_link()
{
    return '
    <a class="link-my-courses show_for_connected_user" target="_blank" href="'. get_field('link_to_dashboard_for_campus', 'option') .'">
        '. cin_get_str('my_courses') .'
    </a>';
}
function get_user_hello()
{
    return '
    <div class="user-information show_for_connected_user">
        '. cin_get_str('hello') .'
        <span class="name-user"></span>
    </div>';
}
function get_user_login(){
    $encoded_path = urlencode($_SERVER['REQUEST_URI']);
    return '
    <div class="header_login has_profile_icon">
        <a class="login-item"
           href="'. get_field('link_to_login_and_register', 'option') .'/login?next=/home' . $encoded_path .'">'. __('Log In', 'single_corse') .'</a>
        <a class="signin"
           href="'. get_field('link_to_login_and_register', 'option') .'/register?next=/home' . $encoded_path .'">'. __('Sign Up', 'single_corse') .'</a>
    </div>';
}