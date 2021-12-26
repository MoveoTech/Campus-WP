<?php
?>

<header class="above-banner" role="above_banner">
    <div class="container">
        <div class="row header">
            <div class="col-5 col-md-5 col-xl-4 col-lg-5 col-sm-4 col-xs-4 position-header-mobile valign_middle">
                <div class="row">
                    <div class="col-sm-12 col-xs-8 col-xl-12 campus-logo">
                        <div class="row">
                            <?php
                            //                            $a = get_field('campus_logo_footer_copy', 'options');
                            //                            var_dump( $a);

                            $campus_logo_header = get_field('campus_logo_header', 'options');
                            $url_campus_logo_header = $campus_logo_header['url'];
                            ?>
                            <a class="col-sm-12 col-xl-4 col-sm-6 brand" href="<?= esc_url(home_url('/')); ?>" aria-label="<?= __( 'campus logo link to home page', 'single_corse')?>">
                                <img class="logo-header" src="<?= $url_campus_logo_header ?>" alt="<?= __( 'logo campus', 'single_corse')?>"/>
                            </a>

                        </div>
                    </div>
                    <div class="col-sm-12 col-xs-12 col-xl-12 position-header-mobile">
                        <div class="menu-header nav-mobile-campus">
                            <div class="d-flex navbar-mobile-opens navbar-expand-lg navbar-light align-items-center">
                                <nav class="header-nav" role="navigation">
                                    <div class="nav-mobile-campus-inner">
                                        <div class="d-sm-block d-md-none d-xs-block lang">
                                            <?= get_lang_menu();?>
                                        </div>
                                        <div class="d-sm-block d-md-none d-xs-block login">
                                            <ul>
                                                <li class="signin-mobile">
                                                    <a class="login-item" href="<?=get_field('link_to_login_and_register','option')?>/login?next=<?= '/home' . $encoded_path; ?>"><?= __( 'Log In', 'single_corse'); ?></a>
                                                </li>
                                                <li class="seperator">|</li>
                                                <li>
                                                    <a class="signin signin-mobile" href="<?=get_field('link_to_login_and_register','option')?>/register?next=<?= '/home' . $encoded_path; ?>"><?= __( 'Sign Up', 'single_corse'); ?></a>
                                                    <a class="link-dasboard" target="_blank" href="<?=get_field('link_to_dashboard_for_campus','option')?>"><?=get_field('text_link_to_dashboard_for_campus','option')?></a>
                                                </li>
                                            </ul>
                                        </div>
                                        <?php
                                        if (has_nav_menu('primary_navigation')) :
                                            wp_nav_menu(['theme_location' => 'primary_navigation', 'menu_class' => 'nav']);
                                        endif;
                                        ?>


                                    </div>
                                </nav>
                                <div class="search-form-header">
                                    <?php get_search_form(); ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5 col-xl-8 col-lg-7 col-sm-6 col-md-7 col-sm-2 wrap-top-menu">
                <div class="row">
                    <div class="d-none d-sm-none col-lg-7 d-md-block col-12 col-sm-6 col-12 col-sm-6 col-xl-7 col-md-8">
                        <div class="d-flex justify-content-end login_lang_wrap">

                            <div class="login login-desktop">
                                <?php
                                $encoded_path = urlencode ($_SERVER['REQUEST_URI']);
                                ?>
                                <ul>
                                    <li>
                                        <a class="login-item" href="<?=get_field('link_to_login_and_register','option')?>/login?next=<?= '/home' . $encoded_path; ?>"><?= __( 'Log In', 'single_corse'); ?></a>
                                    </li>
                                    <li class="seperator">|</li>
                                    <li>
                                        <a class="signin" href="<?=get_field('link_to_login_and_register','option')?>/register?next=<?= '/home' . $encoded_path; ?>"><?= __( 'Sign Up', 'single_corse'); ?></a>
                                    </li>
                                </ul>
                            </div>
                            <ul class="user-connect">
                                <li>
                                    <div class="user-information"><?php echo cin_get_str('hello'); ?> <span class="name-user"></span></div>
                                </li>
                                <li class="seperator">|</li>
                                <li>
                                    <a class="link-my-courses" target="_blank" href="<?=get_field('link_to_dashboard_for_campus','option')?>"><?php echo cin_get_str('my_courses'); ?></a>
                                </li>
                            </ul>
                            <div class="lang">
                                <?= get_lang_menu();?>
                            </div>
                        </div>
                    </div>
                    <div class="wrap-img-logo col-xl-5 col-lg-5 col-md-4">
                        <?php
                        $social_equality_logo_header = get_field('social_equality_logo_header', 'options');
                        $url_social_equality_logo_header = $social_equality_logo_header['url'];
                        $logo_header_extra = get_field('logo_header_extra', 'options');
                        $url_logo_header_extra = $logo_header_extra['url'];
                        //                    var_dump($logo_header_extra);
                        //                    var_dump($url_logo_header_extra);
                        ?>
                        <div class="social-equality-logo logo-header" style="background-image: url(<?= $url_logo_header_extra ?>)" alt="<?= __('Ministry of Social Equality, Headquarters for the Digital Israel', 'single_corse');?>"></div>
                        <div class="social-equality-logo logo-header" style="background-image: url(<?= $url_social_equality_logo_header ?>)" alt="<?= __('Ministry of Social Equality, Headquarters for the Digital Israel', 'single_corse');?>"></div>
                    </div>

                </div>
            </div>
            <div class="d-sm-block d-inline-block d-md-none d-xs-none col-2">
                <button class="navbar-toggle navbar-light navbar-mobile-button" type="button" aria-expanded="false" aria-label="Toggle navigation">
                    <span class="navbar-toggler-icon navbar-mobile-burger"></span>
                </button>
            </div>
        </div>
    </div>
</header>
