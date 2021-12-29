<?php
class Course_stripe {

    //Properties
    private $post;
    private $title;
    private $post_type;
    private $url;
    private $institution;
    private $img_url;

    // Methods
    function __construct($id) {
        $this->post = get_post($id);
        $this->title = get_the_title($id);
        $this->institution = get_field('org',$id);
        $this->institution = $this->institution->post_title;
        $this->img_url = get_the_post_thumbnail_url($id);
        $this->url = $this->post->guid;
        $this->post_type = $this->post->post_type;
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
}

?>