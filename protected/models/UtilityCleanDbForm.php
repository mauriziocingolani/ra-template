<?php

class UtilityCleanDbForm extends CFormModel {

    public $text;

    public function rules() {
        return array(
            array('text', 'compare', 'compareValue' => 'CLEAN', 'message' => 'Devi digitare il testo CLEAN per poter procedere'),
        );
    }

}
