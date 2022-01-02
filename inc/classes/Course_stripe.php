<?php
class Course_stripe {

    //Properties
    private $post;
    private $title;
    private $post_type;
    private $url;
    private $institution;
    private $img_url;
    private $tags;

    // Methods
    function __construct($id) {
        $mypod = pods( 'courses', $id );
        $this->title = $mypod->display( 'name' );
        $this->img_url = $mypod->display( 'image' );
        $this->tags = $mypod->display( 'tags' );
        $this->institution = $mypod->display( 'academic_institution' );
//        $this->post = get_post($id);
//        $this->title = get_the_title($id);
//        $this->institution = get_field('org',$id);
//        $this->institution = $this->institution->post_title;
//        $this->img_url = get_the_post_thumbnail_url($id);
//        $this->url = $this->post->guid;
//        $this->post_type = $this->post->post_type;
    }

    function get_url() {
        return $this->url;
    }

    function get_post_type() {
         return $this->post_type;
    }

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