<?php
/**
 * Template Name: TEST
 */
require_once 'inc/classes/Course_stripe.php';

require_once 'template-parts/Stripes/stripeTypes.php';


?>
<div style="height: 100px"></div>

<?php

//---------- STRIPES SECTION ----------
$cookieValue = $_COOKIE['prod-olivex-user-info'];
if($cookieValue && str_contains($cookieValue,"username"))
    $stripes = $fields['loggedin_users_stripes'];
else
    $stripes = $fields['anonymous_users_stripes'];


foreach($stripes as $stripeId ) {
    getStripeType($stripeId);
}

//---------- STRIPES SECTION ----------

?>


