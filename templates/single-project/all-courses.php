<?php
global $fields;
//if(get_field('all_courses_btn_text_project','option')):
?>
<div class="all_courses">
    <div class="container">
        <div class="row">
            <a class="all_courses_btn_project" href="<?php echo get_post_type_archive_link( "course" )?>"><?php echo get_field('all_courses_btn_text_project','option') ?></a>
        </div>
    </div>
</div>
<?php //endif; ?>