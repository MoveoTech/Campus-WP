<?php

namespace Campus;

class Campus_Card_Program extends Campus_Card_Base{


    /**
     * @param $program_id
     * @var $program
     */
    public $program;

    public function __construct($program_id)
    {
        parent::__construct();
        $this->program = pods( 'programs', $program_id, true);
    }

    public function getName():string {

        $name = $this->language !== 'he' ? $this->program->display($this->language.'_name') : $this->program->display('name');
        $name = $name === '' ? $this->program->display('name') : $name;
        return $name;
    }

    public function getImageUrl() {
        return $this->program->display('course_image');
    }

    public function getBanner() {
        $url = $this::getImageUrl();
        $name = $this::getName();
        ?>
        <img src="<?= $url ?>"/>
        <h1><?= $name ?></h1>
        <?php
    }

    public function getLearn() {
        $learn = $this->program->display('learn');
        ?>
        <h1><?= $learn ?></h1>
        <?php
    }

    public function getSpecialNote() {
        $special_note_title = $this->language !== 'he' ? $this->program->display('special_note_title_'.$this->language) : $this->program->display('special_note_title');
        $special_note_title = $special_note_title === '' ? $this->program->display('related_courses_title') : $special_note_title;

        $special_note_text = $this->program->display('special_note_text');
        ?>
        <h1><?= $special_note_title ?></h1>
        <p><?= $special_note_text ?></p>
        <?php
    }

    public function getRelatedCoursesSection() {
        $related_courses_title = $this->language !== 'he' ? $this->program->display('related_courses_title_'.$this->language) : $this->program->display('related_courses_title');
        $related_courses_title = $related_courses_title === '' ? $this->program->display('related_courses_title') : $related_courses_title;

        $related_courses_arr = $this->program->field('related_courses');
        ?>
        <h1><?= $related_courses_title ?></h1>
        <?php
        foreach ($related_courses_arr as $course){ ?>
            <p><?= $course['name'] ?></p>
        <?php } ?>
        <?php
    }
}
