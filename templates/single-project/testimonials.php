
<?php
global $fields;
$choose_testimonials = $fields['choose_testimonials'];
$testimonials_title = $fields['testimonials_title'];
if( $choose_testimonials ): ?>
    <div class="testimonials-slider-section">
        <div class="container">
            <h3 aria-level="2" class="title-section"><?php echo $testimonials_title; ?></h3>
            <label for="right-button-slider-testimonials" class="sr-only"><?php _e('next recommendation' ,'single_corse')?></label>
            <label for="left-button-slider-testimonials" class="sr-only"><?php _e('previous recommendation' ,'single_corse')?></label>
            <div class="testimonials-slider" id="testimonials-slider-slick">
                <?php
                foreach ($choose_testimonials as $choose_testimonial){
                    $testimonial_id = $choose_testimonial->ID;
                    $role = get_field('role', $testimonial_id);
                    $academic_institution =  get_field('academic_institution', $testimonial_id)
                    ?>
                    <div class="item-testimonials">
                        <div class="item-testimonials-inner">
                            <div class="img-testimonials">
                                <?php  $img_exsist = get_the_post_thumbnail_url( $testimonial_id) ? get_the_post_thumbnail_url( $testimonial_id,'medium') : get_bloginfo('stylesheet_directory') .'/assets/images/campus_avatar.png' ;?>
                                <div class="img-testimonials-inner" style="background-image: url(<?= $img_exsist ?>)"></div>
                            </div>
                            <div class="content-item-testimonials">
                                <h3 class="name-testimonial"><?php echo $choose_testimonial->post_title; ?></h3>
                                <p class="roll-testimonial"><?php echo $role ." | " . $academic_institution ?></p>
                                <?php $img_testimonial = get_bloginfo('stylesheet_directory') . '/assets/images/quotesmall.png'; ?>
                                <div class="img-quotesmall" style="background-image: url(<?= $img_testimonial ?>)" class="quotesmall"></div>
                                <div class="excerpt-testimonial"><?php echo $choose_testimonial->post_content; ?></div>
                            </div>
                        </div>

                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
<?php endif; ?>