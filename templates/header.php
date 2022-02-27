<?php
$user_courses = get_user_courses_link();
$user_name = get_user_hello();
$user_login = get_user_login();
$user_menu = get_user_menu();
wp_head();

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
                        <img class="social-logo" src="<?= $url_logo_header_extra ?>" alt="<?= cin_get_str('header_second_logo_alt') ?>" />
                        <img class="social-logo digital-isreal-logo" src="<?= $url_social_equality_logo_header ?>"
                             alt="<?= cin_get_str('header_third_logo_alt') ?>"/>
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
                    <span class="search-button"><img src="<?= get_bloginfo('stylesheet_directory') . '/assets/images/search-mobile.svg' ?>" /></span>
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
                    <?= lang_button(); ?>
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
    if ($current_lang === 'en') :
        {
            $login = 'Log in';
            $register = 'Register';
        }
    elseif ($current_lang === 'he') :
        {
            $login = 'התחברות';
            $register = 'הרשמה';
        }
    elseif ($current_lang === 'ar') :
        {
            $login = 'تسجيل الدخول';
            $register = 'تسجيل';
        }
    endif;

    return '
    <div class="header_login has_profile_icon">
        <a class="login-item"
           href="'. get_field('link_to_login_and_register', 'option') .'/login?next=/home' . $encoded_path .'">'. __($login, 'single_corse') .'</a>
        <a class="register-item signin_'.$current_lang.'"
           href="'. get_field('link_to_login_and_register', 'option') .'/register?next=/home' . $encoded_path .'"> ' . __($register, 'single_corse') .'</a>
    </div>';
}
function lang_button()
{
    $current = cin_get_str('header_current_languages');
    if ($current === 'עברית') :
        {
            $new = 'עב';
        }
    elseif ($current === 'English') :
        {
            $new = 'en';
        }
    elseif ($current === 'العربية') :
        {
            $new = 'ar';
        }
    endif;

    return '
     
                 <button role="combobox" aria-expanded="false" class="dropdown_langs_btn">' . $new .'</button>

     ';
}
function get_user_menu() {
    global $sitepress;
    $current = $sitepress->get_current_language();

    if ($current === 'he') :
        {
            $language = 'שינוי שפה';
            $profile = 'פרופיל';
            $controlpanel = 'לוח בקרה';
            $logout = 'התנתקות';
        }
    elseif ($current === 'en') :
        {
            $language = 'Change Language';
            $profile = 'Profile';
            $controlpanel = 'Control Panel';
            $logout = 'Log out';


        }
    elseif ($current === 'ar') :
        {
            $language = 'تغيير اللغة';
            $profile = 'الملف الشخصي';
            $controlpanel = 'لوحة المراقبة';
            $logout = 'تسجيل خروج';
        }
    endif;

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
        <li class="user-list-item user-logged-out"><a class="a-link logout-button" target="_blank"></a><img src="' . get_bloginfo('stylesheet_directory') . '/assets/images/logout.svg' .'"><span class="list-item-content">'.$logout.'</span></li>         
    </ul>
    
    
       ';
}

