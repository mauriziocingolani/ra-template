<?php

/**
 * @property integer $CompanyAddressID
 * @property integer $CompanyID
 * @property integer $NazioneID
 * @property integer $RegioneID
 * @property integer $ProvinciaID
 * @property string $City
 * @property string $Address
 * @property string $ZipCode
 * @property string $AddressType
 * 
 * @property Provincia $Province
 * @property Regione $Regione
 * @property Nazione $Nazione
 */
class CompanyAddress extends AbstractDatabaseObject {

    public function init() {
        $this->NazioneID = 106; # default Italia
    }

    public function attributeLabels() {
        return array(
            'Address' => 'Indirizzo',
            'City' => 'Comune',
            'ZipCode' => 'CAP',
            'AddressType' => 'Tipologia',
            'ProvinciaID' => 'Provincia',
            'RegioneID' => 'Regione',
            'NazioneID' => 'Nazione',
        );
    }

    public function relations() {
        return array(
            'Company' => array(self::BELONGS_TO, 'Company', 'CompanyID'),
            'Nazione' => array(self::BELONGS_TO, 'Nazione', 'NazioneID'),
            'Regione' => array(self::BELONGS_TO, 'Regione', 'RegioneID'),
            'Provincia' => array(self::BELONGS_TO, 'Provincia', 'ProvinciaID'),
        );
    }

    public function rules() {
        return array(
            array('Address', 'required', 'message' => 'Inserisci l\'indirizzo'),
            array('City', 'required', 'message' => 'Inserisci il comune'),
            array('ZipCode', 'match', 'pattern' => '/^[0-9]{5}$/u', 'message' => 'CAP non valido (5 cifre)'),
            array('AddressType, ProvinciaID, RegioneID, NazioneID', 'safe'),
        );
    }

    public function tableName() {
        return 'company_addresses';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Eventi */

    protected function beforeSave() {
        if (parent::beforeSave()) :
            if ((int) $this->ProvinciaID <= 0)
                $this->ProvinciaID = null;
            if ((int) $this->RegioneID <= 0)
                $this->RegioneID = null;
            return true;
        endif;
        return false;
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

    /* Metodi */
    /* Metodi statici */

    public static function CreateFromXls(XlsAzienda $xls, $companyid, $nazioneid = 106) {
        $address = new CompanyAddress;
        $address->CompanyID = $companyid;
        $address->AddressType = 'Sede';
        $address->Address = $xls->Indirizzo;
        $address->City = $xls->Comune;
        $address->ProvinciaID = $xls->Provincia;
        $address->NazioneID = $nazioneid; # Italia di default 
        $address = $address->save();
    }

    /* Ajax */
}
