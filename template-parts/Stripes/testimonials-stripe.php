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
    <div hidden class="testimonials-ids" value="<?php  print_r(json_encode($stripe['carousel'])); ?>" ></div>
    <div class="stripe-container">
        <?php
        $have_title = 'no-header';
        if(!empty($stripe['title']) && $stripe['title'] != ""){
            $have_title = '';
            ?>
            <div class="testimonials-stripe-header">
                <span style="background: <?php echo randomColor();?>"></span>
                <h1><?php echo $stripe['title'] ?></h1>
            </div>
        <?php } ?>
        <div id="<?php echo $stripe['id']; ?>" class="testimonials-slider <?= $have_title ?>" >
        <?php
        while ($testimonials->fetch()) { // Testimonials Loop
            $title = getFieldByLanguage($testimonials->display('name'), $testimonials->display('english_name'), $testimonials->display('arabic_name'), $sitepress->get_current_language());
            $description = getFieldByLanguage($testimonials->display('hebrew_description'), $testimonials->display('english_description'), $testimonials->display('arabic_description'), $sitepress->get_current_language());
            $thumb = $testimonials->display('image');
            $color = randomBckgColor();
            if($color == 'yellow') $border_color = '#FDCC07';
            if($color == 'green') $border_color = '#91C653';
            if($color == 'blue') $border_color = '#70C6D1';

            if($thumb){?>
                <div class="testimonial-item">
                    <div class="testimonial-img-container" >
                        <div class="background-img <?php echo $color ?>">
                            <div class="testimonial-item-img" style="border-color: <?php echo $border_color ?>;background-image: url(<?php echo $thumb?>)"></div>
                        </div>
                    </div>
                    <div class="testimonial-item-content">
                        <h1><?php echo $title ?></h1>
                        <p><?php echo $description ?></p>
                    </div>
                </div>


            <?php } } ?>
    </div>
    </div>
</div>


