<?php
$stripe = wp_parse_args(
    $args["args"]
);

if(empty($stripe) || empty($stripe['carousel']) || count($stripe['carousel']) < 1 )
    return;

?>

<div class="home-page-goals-stripe" >
    <div class="stripe-container">
        <div class="back-img-1" ></div>
        <div class="back-img-2" ></div>
        <div class="goals-stripe-header">
            <?php if($stripe['title'] != '' && !empty($stripe['title'])) : ?>
                <div class="stripe-title">
                    <span style="background: <?php echo randomColor();?>"></span>
                    <h1 ><?php echo $stripe['title'] ?></h1>
                </div>
            <?php endif; ?>
        </div>
        <div id="<?php echo $stripe['id'] ?>" class="goals-slider">
        <?php
        global $sitepress;

        if($stripe['carousel'] && count($stripe['carousel']) > 0):
            foreach ($stripe['carousel'] as $goal_item) :

                $title = getFieldByLanguage($goal_item['title']['hebrew_title'], $goal_item['title']['english_title'], $goal_item['title']['arabic_title'], $sitepress->get_current_language());

                $buttonText = getFieldByLanguage($goal_item['button_text']['hebrew_button_text'], $goal_item['button_text']['english_button_text'], $goal_item['button_text']['arabic_button_text'], $sitepress->get_current_language());
//                ?>
                <div class="goal-item" style="background-image: url(<?php echo $goal_item['image']['url'] ?>)" >
                    <div class="bg-gradient-hover"></div>
                    <div class="bg-gradient"></div>
                    <div class="goal-item-content">
                        <h1><?php echo $title ?></h1>
                        <a href="#"><span><?php echo $buttonText ?></span></a>
                    </div>
                </div>
            <?php endforeach;
        endif;
        ?>
    </div>
    </div>
</div>
