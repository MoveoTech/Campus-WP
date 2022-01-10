<?php
class Course_stripe {

    //Properties
    private $title;
//    private $url;
    private $institution;
    private $img_url;
    private $tags;

    // Methods
    function __construct($id) {
        global $sitepress;
        $mypod = pods( 'courses', $id );
        $this->title = getFieldByLanguage($mypod->display( 'name' ), $mypod->display( 'english_name' ), $mypod->display( 'arabic_name' ),$sitepress->get_current_language());
        $this->img_url = $mypod->display( 'image' );
        $this->tags = $mypod->field('tags');
        $this->institution = getFieldByLanguage($mypod->field( 'academic_institution.name' ), $mypod->field( 'academic_institution.english_name' ), $mypod->field( 'academic_institution.arabic_name' ), $sitepress->get_current_language());
    }

//    function get_url() {
//        return $this->url;
//    }
//
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