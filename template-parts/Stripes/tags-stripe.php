<?php
$stripe = wp_parse_args(
    $args["args"]
);
if(empty($stripe) || empty($stripe['title']) || $stripe['title'] == '' || empty($stripe['tags']) || count($stripe['tags']) < 1 )
    return;

$tags = pods( 'tags', podsParams($stripe['tags']));

$colors = array(
    '#70C6D1',
    '#F1595A',
    '#FDCC07',
    '#46b01b',
    '#ee8e2b'
);
$rand_color = $colors[rand(0,4)];
?>

<div class="home-page-tags-stripe" >
    <div class="back-img-1" ></div>
    <div class="back-img-2" ></div>
    <div class="tags-stripe-header">
        <span style="background: <?php echo $rand_color?>"></span>
        <h1><?php echo $stripe['title'] ?></h1>
    </div>
    <div class="tags-div">
        <?php
        while ($tags->fetch()) { // tags Loop
            $tag_name = $tags->display('name');
                ?>
            <div class="tag-item" >
                <a href="https://www.google.com/">
                    <p><?php echo $tag_name ?></p>
                </a>
            </div>
            <?php } ?>
    </div>
</div>