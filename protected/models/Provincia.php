<?php

/**
 * @property string $ProvinciaID
 * @property string $RegioneID
 * @property string $Provincia
 * @property string $Residenti
 * @property double $ResidentiPerc
 * @property string $Superrficie
 * @property double $Densita
 * @property string $Comuni
 * @property string $Sigla
 *
 * @property Regioni $regione
 */
class Provincia extends CActiveRecord {

    public function tableName() {
        return 'province';
    }

    public function relations() {
        return array(
            'Regione' => array(self::BELONGS_TO, 'Regione', 'RegioneID'),
        );
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
