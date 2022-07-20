<?php

namespace Campus;

class Campus_Card_Program extends Campus_Card_Base{
    /**
     * @param $program_id
     * @param $stripe_id
     * @var $program
     * @var $single_program_slug
     */

    public $program;
    public $single_program_slug;

    public function __construct($program_id)
    {
        parent::__construct();
        $this->program = pods( 'programs', $program_id, true);
        $this->single_program_slug = 'program/';
    }

    /**
     * getting all data for program card
     */

    public function getName(){
        $name = $this->language !== 'he' ? $this->program->display($this->language.'_name') : $this->program->display('name');
        $name = $name === '' ? $this->program->display('name') : $name;
        return $name;
    }
    public function getPodType(){
        return $this->program->display('pod_type');
    }

    public function getImageUrl(){
        return $this->program->display('image');
    }

    public function getAcademicInstitution(){
        if($this->language == 'en'){
            return $this->program->field( 'institutions.english_name' );
        } elseif ($this->language == 'ar'){
            return $this->program->field( 'institutions.arabic_name' );
        } else {
            return $this->program->field( 'institutions.name' );
        }
    }
    public function getMarketingTags(){
        return sortTagsByOrder($this->program->field( 'marketing_tags' ));

//        if($this->language == 'en'){
//            return $this->program->field( 'marketing_tags' );
//        } elseif ($this->language == 'ar'){
//            return $this->program->field( 'marketing_tags' );
//        } else {
//            return $this->program->field( 'marketing_tags' );
//        }
    }
    public function getPermalink(){
        return $this->program->display('permalink');
    }

    /** create catalog card html template */
    public function getStripeCard($program_id, $stripe_id){
        $pod_type = $this::getPodType();
        $title = $this::getName();
        $image_url = $this::getImageUrl();
        $institutions = $this::getAcademicInstitution();
        $tags = $this::getMarketingTags();
        $permalink = $this::getpermalink();
        $site_url = getHomeUrlWithoutQuery();
        $url = $site_url . $this->single_program_slug . $permalink;
        $multiple_institutes = getFieldByLanguage("ארגונים שונים", "Different organizations","ארגונים בערבית", $this->language);
        ?>

        <div id="<?php echo $program_id . $stripe_id ?>" class="course-stripe-item" >

            <div class="course-img" style="background-image: url(<?= $image_url ?>);">
                <a href="<?= $url ?>"></a>
                <span class="info-button"></span>
            </div>
            <div class="item-content">
                <h3 ><a href="<?= $url ?>"><?= $title ?></a></h3>
                <?php if ($institutions && count($institutions) > 0) :
                    if(count($institutions) == 1){ ?>
                        <p><?= $institutions[0] ?></p>
                            <?php } else { ?>
                        <p> <?= count($institutions) ." ". $multiple_institutes ?></p>

                 <?php  } ?>

                <?php endif; ?>
            </div>
            <div class="tags-div">
                <?php
                if (count($tags) > 0 && $tags[0] != '' ) {
                    $index = 0;
                    while ($index < 2 && $index < count($tags) && $tags[$index] != '') :
                        $tag = getFieldByLanguage($tags[$index]['name'], $tags[$index]['english_name'], $tags[$index]['arabic_name'], $this->language); // todo - think on other way
                        $tag_length = mb_strlen($tag, 'utf8');
                        $class = 'regular-tag';

                        if($tag_length >= 8) $class = 'ellipsis-text'; ?>
                        <?php if($index == 1) { ?>
                        <span class="<?php echo $class ?> tag-2"><p class="<?php echo $class ?>"><?php echo $tag ?></p></span>
                    <?php } else { ?>
                        <span class="<?php echo $class ?>"><p class="<?php echo $class ?>"><?php echo $tag ?></p></span>
                    <?php } $index++;
                    endwhile;
                    if(count($tags) > 2){ ?>
                        <span class="extra-tags">+</span>
                    <?php }
                    if(count($tags) >= 2) { ?>
                        <span class="extra-tags-mobile">+</span>
                    <?php } }?>
            </div>
        </div>
        <?php


    }

    public function getCatalogCard($program_id){
        $pod_type = $this::getPodType();
        $name = $this::getName();
        $image_url = $this::getImageUrl();
        $institutions = $this::getAcademicInstitution();
        $marketing_tags = $this::getMarketingTags();
        $permalink = $this::getpermalink();
        ?>
        <div>
            <p> <?= $pod_type ?></p>
            <p> <?= $name ?></p>
            <p> <?= $image_url ?></p>
            <p> <?= $institutions[0] ?></p>
            <p> <?= $marketing_tags[0] ?></p>
            <p> <?= $marketing_tags[1] ?></p>
            <p> <?= $marketing_tags[2] ?></p>
            <p> <?= $marketing_tags ?></p>
            <p> <?= $permalink ?></p>
        </div>
        <?php
    }

}
