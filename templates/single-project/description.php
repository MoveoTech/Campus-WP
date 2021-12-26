<?php
global $fields;
?>
<div class="container">
    <div class="content_single_project">
        <div class="row">
             <div class="col-12 col-lg-7 content-single-course">
                <?php
                if (!empty( get_the_content() )) : ?>
                    <p class="title-description"><?= wrap_text_with_char($fields['desc_title_text']); ?></p>
                    <div class="text-description-of-course">
                         <span class="read-more-text">
                               <?php echo wpautop(get_the_content()); ?>
                         </span>
                    </div>
                    <button class="course_test_type_readmore course_test_readmore_collapse collapsed" aria-hidden="false">
                        <span aria-label="<?= __('read more','single_corse'); ?>"><?= __('Read More','single_corse'); ?></span>
                        <span aria-label="<?= __('read less','single_corse'); ?>"><?= __('Read Less','single_corse'); ?></span>
                    </button>
                <?php endif;?>
             </div>
            <div class="col-12 col-lg-5">
                <?php $fields['desc_button_target'] ? $target='_blank' : $target='';
                if($fields['desc_button_text']):
                ?>
                <a class="activity_btn_project" href="<?php echo $fields['desc_button_url']?>" target="<?php echo $target?>"><?php echo wrap_text_with_char($fields['desc_button_text'])?></a>
            <?php endif; ?>
            </div>
        </div>
    </div>
</div>