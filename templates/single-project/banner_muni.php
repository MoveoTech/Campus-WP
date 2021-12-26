<?php
global $fields;

$content = '';
if ($fields['banner_logo']) {
    if ($fields['banner_image_link']) {
        $content = '<a href="' . $fields['banner_image_link'] . '" target="_blank" class="img_wrap" aria-label="'.cin_get_str("logo_municipality") .'"><img src="' . $fields['banner_logo']['url'] . '" alt="' . $fields['banner_logo_alt'] . '"/></a>';
    } else {
        $content = '<span class="img_wrap"><img src="' . $fields['banner_logo']['url'] . '" alt="' . $fields['banner_logo_alt'] . '"/></span>';

    }
}
$title = $fields['title_on_banner'];
$title = wrap_text_with_char($title);

$content .= "<h1 id='muni_page_banner'>
    <span>{$title}</span>
    <span>{$fields['subtitle_on_banner']}</span>
</h1>";

$args = array(
    'banner_image_desktop' => $fields['banner_image_desktop'],
    'banner_image_mobile' => $fields['banner_image_mobile'],
    'content' => $content
);

set_query_var('banner_args', $args);
get_template_part('templates/banner', 'half_img');
?>