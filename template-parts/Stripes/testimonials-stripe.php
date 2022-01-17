<?php
$stripe = wp_parse_args(
    $args["args"]
);

if(empty($stripe) || empty($stripe['id']) || empty($stripe['carousel']) || count($stripe['carousel']) < 1)
    return;

$testimonials = pods( 'testimonials', podsParams($stripe['carousel']));
global $sitepress;
?>

<div class="home-page-testimonials_stripe"  >
    <div hidden id="<?php echo $stripe['id']; ?>" class="testimonials-ids" value="<?php  print_r(json_encode($stripe['carousel'])); ?>" ></div>
    <?php
    if(!empty($stripe['title']) && $stripe['title'] != ""){
        ?>
        <div class="testimonials-stripe-header">
            <span style="background: <?php echo randomColor();?>"></span>
            <h1><?php echo $stripe['title'] ?></h1>
        </div>
    <?php } ?>
    <div class="testimonials-slider" >
        <?php
        while ($testimonials->fetch()) { // Testimonials Loop
            $title = getFieldByLanguage($testimonials['hebrew_name'], $testimonials['english_name'], $testimonials['arabic_name'], $sitepress->get_current_language());
            $description = getFieldByLanguage($testimonials['hebrew_description'], $testimonials['english_description'], $testimonials['arabic_description'], $sitepress->get_current_language());
            $thumb = $testimonials->display('image');
            if($thumb){ ?>
                <div class="testimonial-img-container">
                    <img src="<?php echo $thumb ?>" />
                </div>
                <div class="testimonial-item-content">
                    <h1><?php echo $title ?></h1>
                    <p><?php echo $description ?></p>
                </div>


            <?php } } ?>
    </div>
</div>
