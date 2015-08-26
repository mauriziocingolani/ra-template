<?php

/**
 * @property integer $ActivityTypeID
 * @property string $Description
 * @property string $Category
 * @property integer $Ordering
 * 
 * @property boolean $isRecall
 * @property boolean $isClosed
 * @property boolean $isSuccess
 */
class ActivityType extends CActiveRecord {

    public function tableName() {
        return 'activity_types';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Metodi */

    public function getIsRecall() {
        return $this->Category == 'R';
    }

    public function getIsClosed() {
        return $this->Category == 'C';
    }

    public function getIsSuccess() {
        return $this->Category == 'S';
    }

    /* Metodi statici */

    public static function GetAll() {
        return self::model()->findAll();
    }

}
