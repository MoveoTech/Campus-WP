<?php
$academic_institutions_stripe = wp_parse_args(
    $args["academic_institutions_stripe"]
);

if(empty($academic_institutions_stripe) )
    return;

$academic_institutions = pods( 'academic_institution');
$academic_institutions->find(academicInstitutionsParams($academic_institutions_stripe));


while ($academic_institutions->fetch()) { // academic_institution Loop
    $thumb = $academic_institutions->display('image');
    if($thumb){
        ?>
        <div class="course-stripe-item" style="margin: 50px">
            <div class="course-img" style="background-image: url(<?php echo $thumb ?>); width: 200px; height: 200px; background-repeat: no-repeat"></div>
        </div>
        <?php
    }
}

function academicInstitutionsParams($academic_institutions_stripe){

    $where = "t.id IN (";
    $order = "FIELD(t.id,";

    foreach($academic_institutions_stripe as $academic_institution ) {
        $where = $where . $academic_institution . ",";
        $order = $order . $academic_institution . ",";

    }
    $where = substr_replace($where, ")", -1);
    $order = substr_replace($order, ")", -1);

    $params = array(
        'limit' => -1,
        'where'=>$where,
        'orderby'=> $order
    );
    return $params;

}

?>