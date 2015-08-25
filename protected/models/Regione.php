<?php

/**
 * @property string $RegioneID
 * @property string $AreaID
 * @property string $Regione
 * @property string $Residenti
 * @property double $ResidentiPerc
 * @property string $Superficie
 * @property double $SuperficiePerc
 * @property double $Densita
 * @property string $Comuni
 * @property string $Province
 */
class Regione extends CActiveRecord {

    /**
     * @return string the associated database table name
     */
    public function tableName() {
        return 'regioni';
    }
    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

}
