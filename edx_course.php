<?php
/**
 * Template Name: Edx Course
 */


//get_and_insert_Courses_from_edx();

// header('Access-Control-Allow-Origin: *');

// header('Access-Control-Allow-Methods: GET, POST');

// header("Access-Control-Allow-Headers: X-Requested-With");



echo 123;

?>

<button id="edex-request" type="button">Click Me!</button>


<script>

jQuery.ajax({
    method: "GET",
    url: "https://campus-dev.opencraft.hosting/api/enrollment/v1/enrollment",
    headers: {
          "Accept": "application/json",
          "Content-Type": "application/json"
    },
    data: JSON.stringify({
            "course_details": {
                "course_id": "course-v1:AAC+ACD_AAC_statisticsA+2018_1"
            }
        }),
    xhrFields: {
        withCredentials: true
    },
    success: function(data) {
        console.log('succeeded: authenticated');
        console.log(data);
        console.log(data[0].user);
    },
    error: function() {
        console.error("Not authenticated");
        console.error(arguments);
    }
});

    // jQuery.ajax({
    //     method: "GET",
    //     url: "https://campus-dev.opencraft.hosting/api/enrollment/v1/enrollment",
    //    
    //     headers: {
    //         "Accept": "application/json",
    //         "Content-Type": "application/json"
    //     },
    //     xhrFields: {
    //         withCredentials: true
    //     },
    //     success: function(d){
    //         console.log(d);
    //         console.log('suucceeded');
    //     }
    // })

</script>