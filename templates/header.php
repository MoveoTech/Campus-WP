<?php
$user_courses = get_user_courses_link();
$user_name = get_user_hello();
$user_login = get_user_login();
$user_menu = get_user_menu();
echo get_no_script_tags();

$language_short = __('en', 'General');

?>
    <header class="above-banner header_section header_wrap" role="above_banner">
        <div class="flex-div">
            <div class=" nav-mobile-btn-wrap ">
                <button class="navbar-toggle navbar-light navbar-mobile-button" type="button"
                        aria-expanded="false"
                        aria-label="Toggle navigation">
                    <span></span>
                    <span></span>
                    <span></span>
                </button>
            </div>
            <div class="logo-container">
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
                    <div class="logo_items">
                        <img class="social-logo" src="<?= $url_logo_header_extra ?>" alt="<?= cin_get_str('header_third_logo_alt') ?>" />
                        <img class="social-logo digital-isreal-logo" src="<?= $url_social_equality_logo_header ?>"
                             alt="<?= cin_get_str('header_second_logo_alt') ?>"/>
                    </div>
                </div>
            </div>
            <div class="control-container">
                <div class="header_menu ">
                    <nav class="header-nav" id="header_primary_nav" role="menu">
                        <?php
                        if (has_nav_menu('primary_navigation')) :
                            wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
                        endif;
                        ?>
                    </nav>
                </div>
                <div class="search-form login_search_lang_wrap ">
                        <span class="search-button"><a  href="<?= esc_url(home_url("/catalog")); ?>"><img src="<?= get_bloginfo('stylesheet_directory') . '/assets/images/search-mobile.svg' ?>" /></a></span>
                        <div class="header-courses">
                            <?php get_search_form(); ?>
                        </div>
                </div>
            </div>
            <div class="user-login-container">
                <div class="header_login_area">
                    <span class="header_login login-register"><?= $user_login; ?></span>
                    <div class="d-block d-md-none d-lg-inline-block user-connect show_for_connected_user">
                        <div id="connected_user_desktop_and_mobile" class="has_profile_icon">

                            <?= $user_name; ?>
                            <div id="user-menu" class="menu-user-menu-container">
                                <?= $user_menu ?>
                            </div>
                            <span class="d-inline-block d-lg-none header_connected_label"><?= cin_get_str('header_connected'); ?></span>

                        </div>
                    </div>
                </div>
                <div class="header_login lang languages_menu_wrap">
                    <button role="combobox" aria-expanded="false" class="dropdown_langs_btn"><?= $language_short ?></button>
                    <div class="menu-language-menu-container">
                        <ul id="menu-language-menu-1" class="nav-lang">
                            <li id="wpml-ls-item-he" class="wpml-ls-menu-item wpml-ls-item-he <?= current_active_lang( 'he' ) ?>"><a href="<?= get_lang_url( 'he' ) ?>"><span class="wpml-ls-native">עב</span></a></li>
                            <li id="wpml-ls-item-ar" class="wpml-ls-menu-item wpml-ls-item-ar <?= current_active_lang( 'ar' ) ?>"><a href="<?= get_lang_url( 'ar' ) ?>"><span class="wpml-ls-native">العر</span></a></li>
                            <li id="wpml-ls-item-en" class="wpml-ls-menu-item wpml-ls-item-en <?= current_active_lang( 'en' ) ?>"><a href="<?= get_lang_url( 'en' ) ?>"><span class="wpml-ls-native">En</span></a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>
    </header>

<?php

function get_user_courses_link()
{
    return '
    <a class="link-my-courses show_for_connected_user" target="_blank" href="'. get_field('link_to_dashboard_for_campus', 'option') .'">
        '. cin_get_str('my_courses') .'
    </a>';
} /** לוח בקרה */
function get_user_hello()
{
    return '
    <div class="user-information show_for_connected_user">
        <img width="30px" src="' . get_bloginfo('stylesheet_directory') . '/assets/images/cactus.svg' .'" alt="user icon">
                  <span class="name-user"></span>            
         <img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/vector.svg' .'" />
    </div>';
}
function get_user_login()
{
    global $sitepress;
    $encoded_path = urlencode($_SERVER['REQUEST_URI']);
    $current_lang = $sitepress->get_current_language();
    $login = __('Log in', 'General');
    $register = __('Register', 'General');

    return '
    <div class="header_login has_profile_icon">
        <a class="login-item"
           href="'. get_field('link_to_login_and_register', 'option') .'/login?next=/home' . $encoded_path .'">'.$login .'</a>
        <a class="register-item signin_'.$current_lang.'"
           href="'. get_field('link_to_login_and_register', 'option') .'/register?next=/home' . $encoded_path .'"> ' . $register .'</a>
    </div>';
}

function get_user_menu() {
    global $sitepress;
    $current = $sitepress->get_current_language();
    $language = __('Change Language', 'General');
    $profile = __('Profile', 'General');
    $controlpanel = __('Control Panel', 'General');
    $logout = __('Log out', 'General');

    return '
    <ul id="menu-user-menu-1" class="nav-user">
       <li class="user-list-item change-lang-menu"><a class="a-link"></a><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/lang-logo.svg' .'"><span class="list-item-content">'.$language.'</span><img class="mobile-menu-vector" src="' . get_bloginfo('stylesheet_directory') . '/assets/images/vector-black.svg' .'"/> 
           <div class="secondary-lang-menu">
               <ul id="menu-language-menu-1" class="nav-lang">
                    <li id="wpml-ls-item-he" class="wpml-ls-menu-item wpml-ls-item-he ' . current_active_lang( 'he' ) . '"><a href="' . get_lang_url( 'he' ) . '"><span class="wpml-ls-native">עב</span></a></li>
                    <li id="wpml-ls-item-en" class="wpml-ls-menu-item wpml-ls-item-en ' . current_active_lang( 'en' ) . '"><a href="' . get_lang_url( 'en' ) . '"><span class="wpml-ls-native">En</span></a></li>
                    <li id="wpml-ls-item-ar" class="wpml-ls-menu-item wpml-ls-item-ar ' . current_active_lang( 'ar' ) . '"><a href="' . get_lang_url( 'ar' ) . '"><span class="wpml-ls-native">العر</span></a></li>
                </ul>
            </div>
       </li>
        <li class="user-list-item "><a class="a-link profile-button" target="_blank"></a><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/profile.svg' .'"><span class="list-item-content">'.$profile.'</span></li>
        <li class="user-list-item"><a class="a-link" target="_blank" href="'. get_field('link_to_dashboard_for_campus', 'option') .'"></a><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/equalizer.svg' .'"><span class="list-item-content">'.$controlpanel.'</span></li>
        <li class="user-list-item user-logged-out"><a class="a-link logout-button"></a><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/logout.svg' .'"><span class="list-item-content">'.$logout.'</span></li>         
    </ul>
    
    
       ';
}
function get_no_script_tags() {
    return '    <!-- Google Tag Manager (noscript) -->

    <noscript><iframe src="https://www.googletagmanager.com/ns.html?id=GTM-MS8JL77" height="0" width="0" style="display:none;visibility:hidden"></iframe></noscript>

    <!-- End Google Tag Manager (noscript) -->';
}

