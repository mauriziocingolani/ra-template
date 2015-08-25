<?php

/**
 * @property string $NazioneID
 * @property string $NazioneIt
 * @property string $NazioneEn
 * @property CompanyAddress[] $Addresses
 */
class Nazione extends CActiveRecord {

    public function tableName() {
        return 'nazioni';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
