<?php
global $fields;

echo "<div id='cta_floor' class='has_background_image'>
    <div id='cta_container' class='container'>
        <h3 id='cta_title'>" . wrap_text_with_char($fields['cta_title']) . "</h3>
        <div id='cta_subtitle'>" . wrap_text_with_char($fields['cta_subtitle']) . "</div>
        <a data-color='lightblue' class='new_design_btn' href='{$fields['cta_btn_link']}' id='cta_btn'>{$fields['cta_btn_text']}</a>
    </div>
</div>
<style>
    @media(min-width: 768px){
        #cta_floor{
            background-image: url({$fields['cta_desktop_img']});
        }
    }
    @media(max-width: 767px){
        #cta_floor{
            background-image: url({$fields['cta_mobile_img']});
        }
    }
</style>";