<?php

namespace Campus;

abstract class Campus_Single_Page_Base {

    /**
     * @var $language
     */
    public $language;

    /**
     * Campus_Program constructor.
     */
    public function __construct() {
        $this->language = apply_filters( 'wpml_current_language', NULL );
    }


    /**
     * @param $slug
     *
     */
    public abstract function getName():string;

//    public abstract function getBanner($slug);

}