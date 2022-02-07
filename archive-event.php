<?php

$class = 'search-course background-instead-banner';
$text_on_banner_content = '';
$text_on_banner_content .= '<h1>'.  __('Events' ,'single_corse') .'</h1>';

echo get_banner_area( false, false , $text_on_banner_content, $class);

$today = strtotime(date('m/d/Y'));
$taxonomies = array(
    'event_type' => array(
        'label' => cin_get_str('event_type'),
        'terms' => array()
    ),
    'tag_filter' => array(
        'label' => cin_get_str('tag_filter_title'),
        'terms' => array()
    )
);
$count_future_events = 0;
$count_past_events = 0;

$output_sidebar = '';
$output_events = '';

while (have_posts()) : the_post();
    $event_date = strtotime(get_field('event_date', $post->ID));
    if ($event_date >= $today) {
        $event_status = 'future';
        $count_future_events++;
    } else {
        $event_status = 'past';
        $count_past_events++;
    }
    $my_filters = 'data-status=",' . $event_status . '," ';

    foreach ($taxonomies as $tax => $label) {
        $terms = wp_get_post_terms($post->ID, $tax);
        $my_filters .= 'data-'. $tax .'=",';
        foreach ($terms as $term) {
            if (isset($taxonomies[$tax]['terms'][$term->term_id])) {
                $taxonomies[$tax]['terms'][$term->term_id]['count']++;
            }else {
                $taxonomies[$tax]['terms'][$term->term_id] = array(
                    'count' => 1,
                    'name' => $term->name,
                    'id' => $term->term_id
                );
            }
            $my_filters .= $term->term_id .',';
        }
        $my_filters .= '" ';

    }

    $attrs = array(
        'filters' => $my_filters,
        'class' => 'col-xs-12 col-md-6 col-xl-4 course-item-with-border'
    );
    $output_events .= draw_event_item($attrs);
endwhile;

$taxonomies = array(
    'status' => array(
        'label' => '',
        'terms' => array(
            array(
                'count' => $count_past_events,
                'name' => cin_get_str('past_events_tag'),
                'id' => 'past'
            ), array(
                'count' => $count_future_events,
                'name' => cin_get_str('future_events_tag'),
                'id' => 'future'
            )
        )
    )
) + $taxonomies;
foreach($taxonomies as $tax => $details){
//    if($details['type'] == 'radio') {
//        $input = 'radio';
//        $checked = 'checked';
//    } else {
//        $input = 'checkbox';
//        $checked = '';
//    }
    $output_sidebar .= '
<div class="wrap-terms-group">
    <h2 class="search-page-tax-name">'. $details['label'] .'</h2>
    <div class="more-tags" role="list">';
        foreach($details['terms'] as $term) {
            extract($term);
            $output_sidebar .= "<div class='wrap-filter-search'>
            <label class='term-filter-search' for='{$tax}_$id'>
                <input class='checkbox-filter-search' type='checkbox' name='$tax' data-name='$tax' value='$id' id='{$tax}_$id'>
                <div class='wrap-term-and-sum'><span class='term-name'>$name</span>
                    <span class='sum'>$count</span>
                </div>
            </label>
        </div>";
        }
    $output_sidebar .= '</div>
</div>';
    if(count($details['terms']) > 5)
    $output_sidebar .= '<button class="show-more-tags collapsed" aria-hidden="true"><span>' . __('Show More Tags', 'single_corse') . '</span>
        <span>' . __('Show Less Tags', 'single_corse') . '</span></button>';
}

$events_sidebar_title = cin_get_str('events_sidebar_title');
?>

<div class="container wrap-events-page">
    <div class="row">
        <aside class="col-xs-12 col-md-12 col-lg-3 col-xl-3 col-sm-12 sidebar-search-course">
            <div class="wrap-all-filter-names">
                <div class="clear-filter-area">
                    <span class="filter-course-title" role="heading" aria-level="2"><?= $events_sidebar_title; ?></span>
                </div>
                <div class="wrap-all-tags-filter">
                    <div class="wrap-mobile-filter-title">
                        <button id="close-nav-search" class="close-nav-search" type="button"></button>
                        <p class="filter-title-mobile"><?= $events_sidebar_title; ?></p>
                        <a href="javascript: void(0);" class="clear-link" role="button" id="clear_all_filters"><?= __('Clear All', 'single_corse'); ?></a></div>
                        <?= $output_sidebar ;?>
                    <div class="wrap-button-filter"><button class="search-close-button d-md-none d-xs-block"><?= cin_get_str('events_sidebar_show'); ?></button></div></div>
            </div>
        </aside>
        <div class="col-sm-12 col-md-12 col-lg-9 col-xl-9 col-12">
            <div class="sum-all-course col-lg-12" role="alert"><h2 class="wrap-sum">
                <span><?= __('Showing', 'single_corse'); ?></span>
                <span id="add-sum-course" class="sum-of-courses-result"><?= $wp_query->found_posts; ?></span>
                <span><?= cin_get_str('matching_events'); ?></span>
            </h2></div>
            <div id="event_archive_filters" class="wrap-top-bar-search">
                <?php
                /*
                $options = array(
                    array(
                        'val' => 'desc',
                        'data' => 'future',
                        'label' => __('Show only future events', 'single_corse'),
                        'text' => 'show_event_future'
                    ),
                    array(
                        'val' => 'asc',
                        'data' => '',
                        'label' => __('Show all events', 'single_corse'),
                        'text' => 'show_event_all'
                    ),
                );
                $class = 'checked';
                foreach($options as $option) {
                    $text = cin_get_str($option['text']);
                    echo "<div class='wrap-orderby'>
                        <input $class class='sr-only' type='radio' id='{$option['text']}' name='event_order' value='{$option['val']}' data-filter='{$option['data']}'>
                        <label aria-label='{$option['label']}' class='orderby $class' for='{$option['text']}'>$text</label>
                    </div>";
                    $class = '';
                }*/
                ?>
                <div aria-label="<?= __('click here to remove filter button' ,'single_corse'); ?>" class="hidden" id="filter_dynamic_tags_demo">
                    <a role="button" aria-label="<?= __('click to remove the filter' ,'single_corse'); ?>" class="filter_dynamic_tag" data-name data-id href="javascript: void(0);"></a>
                </div>
                <div class="col-12 filter-dynamic" id="filter_dynamic_tags"></div>
            </div>
            <div class="row" id="all_events">
                <?= $output_events; ?>
            </div>
            <?php

            if($wp_query->found_posts > 15){
                $arialabel_acc = cin_get_str('load_more_events');
                echo "<button class='load-more-wrap' aria-label='$arialabel_acc' id='course_load_more' >". __('Load more' ,'single_corse') ."</button>";
            }
            ?>
        </div>
    </div>
</div>
