<?php
$stripe = wp_parse_args(
    $args["args"]
);

if(empty($stripe) || empty($stripe['id']) || empty($stripe['carousel']) || count($stripe['carousel']) < 1)
    return;
$testimonials = pods( 'testimonial', podsParams($stripe['carousel']));

global $sitepress;
?>

<div class="home-page-testimonials_stripe"  >
    <div class="back-img-1" ></div>
    <div class="back-img-2" ></div>
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
            $title = getFieldByLanguage($testimonials->display('name'), $testimonials->display('english_name'), $testimonials->display('arabic_name'), $sitepress->get_current_language());
            $description = getFieldByLanguage($testimonials->display('hebrew_description'), $testimonials->display('english_description'), $testimonials->display('arabic_description'), $sitepress->get_current_language());
            $thumb = $testimonials->display('image');
            if($thumb){ ?>
                <div class="testimonial-item">
                    <div class="testimonial-img-container" >
<!--                        <div class="background-img">-->
<!--                            <span class="bckg-1"></span>-->
<!--                            <span class="bckg-2"></span>-->
<!--                            <span class="bckg-3"></span>-->
<!--                        </div>-->
                        <div class="testimonial-item-img" style="background-image: url(<?php echo $thumb?>)"></div>
                    </div>
                    <div class="testimonial-item-content">
                        <h1><?php echo $title ?></h1>
                        <p><?php echo $description ?></p>
                    </div>
                </div>


            <?php } } ?>
    </div>
</div>


