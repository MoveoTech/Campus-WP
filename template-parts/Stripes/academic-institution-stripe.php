<?php
$stripe = wp_parse_args(
    $args["args"]
);

if(empty($stripe) || empty($stripe['id']) || empty($stripe['carousel']) || count($stripe['carousel']) < 1)
    return;

$academic_institutions = pods( 'academic_institution', podsParams($stripe['carousel']));

$colors = array(
    '#70C6D1',
    '#F1595A',
    '#FDCC07',
    '#46b01b',
    '#ee8e2b'
);
$rand_color = $colors[rand(0,4)];
?>

<div class="home-page-institutions_stripe"  >
    <div hidden id="<?php echo $stripe['id']; ?>" class="academic-institutions-ids" value="<?php  print_r(json_encode($stripe['carousel'])); ?>" ></div>
    <?php
    if(!empty($stripe['title']) && $stripe['title'] != ""){
        ?>
        <div class="institution-header">
            <span style="background: <?php echo $rand_color?>"></span>
            <h1><?php echo $stripe['title'] ?></h1>
        </div>
    <?php } ?>
    <div class="institutions-slider" >
        <?php
        while ($academic_institutions->fetch()) { // academic_institution Loop
            $thumb = $academic_institutions->display('image');
            if($thumb){
                ?>
                <div class="course-stripe-item" style="margin: auto">
                    <div class="course-img" style="background-image: url(<?php echo $thumb ?>);  "></div>
                </div>
            <?php } } ?>
    </div>
</div>
