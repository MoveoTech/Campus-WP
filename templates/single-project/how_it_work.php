<?php
$frontpage_id = get_option( 'page_on_front' );

$how_it_works_title = get_field('how_it_works_title', $frontpage_id);
$video_boxes = get_field('video_boxes', $frontpage_id);
if ($how_it_works_title) :
    echo get_how_it_works($how_it_works_title,$video_boxes);
endif;