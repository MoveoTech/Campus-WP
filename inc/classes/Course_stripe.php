<?php
class Course_stripe {

    //Properties
    private $title;
//    private $post_type;
//    private $url;
    private $institution;
    private $img_url;
    private $tags;

    // Methods
    function __construct($id) {
        $mypod = pods( 'courses', $id );
        $this->title = $mypod->display( 'name' );
        $this->img_url = $mypod->display( 'image' );
        $this->tags = $mypod->display( 'tags' );
        $this->institution = $mypod->display( 'institutions' );

    }

//    function get_url() {
//        return $this->url;
//    }
//
//    function get_post_type() {
//         return $this->post_type;
//    }

    function get_title() {
        return $this->title;
    }

    function get_institution_name() {
        return $this->institution;
    }

    function get_img_url() {

        return $this->img_url;
    }

    function get_tags() {
        return $this->tags;
    }
}

?>