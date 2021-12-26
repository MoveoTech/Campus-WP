<?php
global $fields;
if ($trailer = $fields['trailer']) {
    $query_string = array();
    parse_str(parse_url($trailer, PHP_URL_QUERY), $query_string);

    $video_id = $query_string["v"];
    $video_on_banner = '<div id="single_project_video_wrap">
        <a href="#" aria-haspopup="true" role="button" tabindex="0" title="' . get_the_title() . '" data-url="https://www.youtube.com/embed/' . $video_id . '?autoplay=1&showinfo=1&autohide=1&rel=0&enablejsapi=1&wmode=transparent"  class="popup-about-course-video open-popup-button-2020"></a>
    </div>';
//  aria-pressed="true"  data-popup data-classtoadd="popup-about-course"
} else {
    $video_on_banner = '';
}
$text_on_banner_content_output = '';
$text_on_banner_content_output .= '<h1 class="title-opacity-on-banner">'. $fields['title_on_banner'] .'</h1>';
if($fields['banner_logo']){
    $text_on_banner_content_output .= '<img src="'.$fields['banner_logo']['url'].'" class="img-academic" alt="'.$fields['banner_logo']['alt'] .'"/>';
}


$url_banner_desktop = $fields['banner_image_desktop'];
$url_banner_mobile = $fields['banner_image_mobile'] ? $fields['banner_image_mobile'] : $url_banner_desktop;

$class_output = 'institution-page';
if ( function_exists('yoast_breadcrumb') ) {
    $breadcrumbs = yoast_breadcrumb('<div class="' . $class_output . ' breadcrumbs-campus" id="breadcrumbs"><p class="container">', '</p></div>');
}

echo "<div id='single_project_banner' class='banner-wrapper has_background_image'>
    <div class='container'>
        <div class='text-on-banner'>
            $text_on_banner_content_output
        </div>
    </div>
    $video_on_banner
    $breadcrumbs
</div>

<style>
@media(min-width: 992px){
    #single_project_banner{
        background-image: url($url_banner_desktop);
    }
}
@media(max-width: 991px){
    #single_project_banner{
        background-image: url($url_banner_mobile);
    }
}
</style>
";
?>
<style>
    #single_project_banner .container{
        height: 100%;
    }
    #single_project_banner .container:after{
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
    }
    #single_project_banner .text-on-banner{
        display: inline-block;
        vertical-align: middle;
        max-width: 99%;
    }
    #single_project_video_wrap {
        position: absolute;
        height: 100%;
        width: 60%;
        left: 0;
        top: 0;
        text-align: center;
    }
    html[lang="en-US"] #single_project_video_wrap{
        left: auto;
        right: 0;
    }
    #single_project_video_wrap:after{
        content: '';
        display: inline-block;
        height: 100%;
        vertical-align: middle;
    }
    @media(max-width: 767px) {
        #single_project_video_wrap .popup-about-course-video {
            transform: scale(0.8);
            -webkit-transform: scale(0.8);
        }
    }
    @media(max-width: 991px) {
        .banner-wrapper{
            height: 200px;
        }
    }
</style>