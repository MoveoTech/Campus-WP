<?php

$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['id']) || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
    return;
global $sitepress;
$current_language = $sitepress->get_current_language();

$courses_url = home_url('/catalog/?stripe_id=') . $stripe['id'];
// TO DO - change url slugs
$countShow = getFieldByLanguage("הצג את", "Show all", "أعرض", $current_language);
$countCourses = getFieldByLanguage("הקורסים", "Courses", "مساق", $current_language);
$countNumber = count($stripe['carousel']);

/** translate numbers to arabic */
if($current_language == 'ar'){
    $english_numbers = array('0','1','2','3','4','5','6','7','8','9');
    $arabic_numbers = array('٠','١','٢','٣','٤','٥','٦','٧','٨','٩');
    $countNumber = str_replace($english_numbers, $arabic_numbers, $countNumber);
}

?>

<div class="home-page-courses-stripe">
    <div class="stripe-container">
        <div class="stripe-header">
        <div class="header-title">
            <?php if($stripe['title'] != '' && !empty($stripe['title'])) : ?>
            <h1><?php echo $stripe['title'] ?></h1>
            <?php endif; ?>

            <?php if($stripe['subtitle'] && $stripe['subtitle'] !== '') : ?>
                <p><?php echo $stripe['subtitle'] ?></p>
            <?php endif; ?>
        </div>
        <div class="show-all-courses"><a href="<?php echo $courses_url ?>"><p> <?php echo $countShow ." ". $countNumber ." ". $countCourses ?></p></a></div>
    </div>
        <?php
    get_template_part('template', 'parts/Stripes/courses-carousel',
        array(
            'args' => array(
                'courses' => $stripe['carousel'],
                'id' => $stripe['id'],
            )
        ));
    ?>
    </div>
</div>
