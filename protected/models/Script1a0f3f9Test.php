<?php

class Script1a0f3f9Test extends ScriptActiveRecord {

    public $Q1;
    public $Q2;
    public $Q2t;

    public function attributeLabels() {
        return array(
            'Q1' => 'Domanda 1',
            'Q2' => 'Domanda 2',
        );
    }

    public function rules() {
        return array(
            array('Q1', 'required', 'message' => 'Devi inserire un valore'),
            array('Q2', 'required', 'message' => 'Devi selezionare una voce'),
            array('Q2t', 'safe'),
        );
    }

    public function tableName() {
        return 'script_1a0f3f9_test';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Implementazione interfaccia DatabaseObject */

    public static function CreateRecord(array $parameters) {
        
    }

    public static function DeleteRecord($pk) {
        
    }

    public static function ReadRecord($pk) {
        
    }

    public static function UpdateRecord($pk, array $parameters) {
        
    }

    /* Eventi */

    protected function beforeSave() {
        if (parent::beforeSave()) :
            if ($this->Q2 != 'Altro')
                $this->Q2t = null;
            return true;
        endif;
        return false;
    }

    /* Metodi */

    public function getAnswers() {
        return array(
            $this->getAttributeLabel('Q1') => $this->getAttribute('Q1'),
            $this->getAttributeLabel('Q2') => $this->getAttribute('Q2') . ($this->getAttribute('Q2') == 'Altro' ? ' (' . $this->getAttribute('Q2t') . ')' : ''),
        );
    }

    public function getFieldValues() {
        return array(
            $this->Q1,
            $this->Q2,
            $this->Q2t,
        );
    }

    /* Metodi statici */

    public static function GetDummyFieldValues() {
        return array('', '', '');
    }

    public static function GetFieldNames() {
        return array(
            'Domanda 1',
            'Domanda 2',
            'Domanda 2 altro',
        );
    }

    /* Ajax */
}
