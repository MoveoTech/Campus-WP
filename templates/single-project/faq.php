<?php
global $fields;
$faq_title = $fields['faq_title'];
$faq = $fields['faq'];
$more_faq_link = $fields['more_faq_link'];
if ($faq):
    echo get_faq($faq_title,$faq,$more_faq_link);
endif;