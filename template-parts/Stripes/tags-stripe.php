<?php
$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe)  || empty($stripe['tags']) || count($stripe['tags']) < 1 )
    return;

$tags = pods( 'tags', podsParams($stripe['tags']));

global $sitepress;
?>

<div class="home-page-tags-stripe" >
    <div class="back-img-1" ></div>
    <div class="back-img-2" ></div>
    <div class="stripe-container">
        <div class="tags-stripe-header">
        <?php if($stripe['title'] != '' && !empty($stripe['title'])) : ?>
                <span style="background: <?php echo randomColor();?>"></span>
                <h1><?php echo $stripe['title'] ?></h1>
        <?php endif; ?>
            </div>
        <div class="tags-div">
        <?php
        while ($tags->fetch()) { // tags Loop
            $tag_id = $tags->id();
            $tag_name = getFieldByLanguage($tags->display('name'), $tags->display('english_name'), $tags->display('arabic_name'), $sitepress->get_current_language());
            $english_name = $tags->display('english_name');
                ?>
            <div class="tag-item" >
                <a href="/catalog/?tags_Stripe=<?= $tag_id.'-'.$english_name?>">
                    <p><?php echo $tag_name ?></p>
                </a>
            </div>
            <?php } ?>
    </div>
    </div>
</div>