<?php

/**
 * @property string $CompanyID
 * @property string $Created
 * @property string $CreatedBy
 * @property string $Updated
 * @property string $UpdatedBy
 * @property string $CompanyName
 * @property string $CompanyLegalName
 * @property string $CompanyGroup
 * @property strinf $CompanyCode
 * @property string $Notes
 * @property string $Slug
 */
class Company extends AbstractDatabaseObject {

    public $searchCity; # campo di ricerca città
    public $searchPhone; # campo di ricerca telefoni
    public $searchEmail; # campo di ricerca email
    private static $_codes;

    public function attributeLabels() {
        return array(
            'CompanyID' => 'ID',
            'CompanyName' => 'Ragione Sociale',
            'CompanyLegalName' => 'Forma giuridica',
            'CompanyGroup' => 'Gruppo',
            'CompanyCode' => 'Codice',
            'Notes' => 'Note',
        );
    }

    public function relations() {
        return array(
            'Creator' => array(self::BELONGS_TO, 'User', 'CreatedBy'),
            'Updater' => array(self::BELONGS_TO, 'User', 'UpdatedBy'),
            'Addresses' => array(self::HAS_MANY, 'CompanyAddress', 'CompanyID'),
            'Contacts' => array(self::HAS_MANY, 'CompanyContact', 'CompanyID'),
            'Phones' => array(self::HAS_MANY, 'CompanyPhone', 'CompanyID', 'order' => 'PhoneType,PhoneNumber'),
            'Emails' => array(self::HAS_MANY, 'CompanyEmail', 'CompanyID', 'order' => 'Emails.Address'),
//            'Activities' => array(self::HAS_MANY, 'Activity', 'CompanyID', 'order' => 'Campaign.StartDate DESC,Activities.Created DESC', 'with' => array('Creator', 'Campaign')),
//            'Campaigns' => array(self::HAS_MANY, 'CampaignCompany', 'CompanyID', 'with' => 'Campaign', 'together' => false),
        );
    }

    public function rules() {
        return array(
            array('CompanyName', 'required', 'message' => 'Inserisci la ragione sociale'),
            array('CompanyCode', 'numerical', 'min' => 1, 'tooSmall' => 'Il codice non pu&ograve; essere minore o uguale a zero'),
            array('CompanyID, CompanyLegalName, CompanyGroup, Notes', 'safe'),
        );
    }

    public function tableName() {
        return 'companies';
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
        return self::SimpleReadRecord(self::model(), $pk);
    }

    public static function UpdateRecord($pk, array $parameters) {
        
    }

    /* Eventi */
    /* Metodi */

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('Addresses', 'Phones', 'Emails');
        $criteria->together = true;
        $criteria->compare('t.CompanyID', $this->CompanyID, true);
        $criteria->compare('CompanyName', $this->CompanyName, true);
        $criteria->compare('CompanyLegalName', $this->CompanyLegalName, true);
        $criteria->compare('CompanyGroup', $this->CompanyGroup, true);
        $criteria->compare('CompanyCode', $this->CompanyCode, true);
        $criteria->compare('Addresses.City', $this->searchCity->City, true);
        $criteria->compare('Phones.PhoneNumber', $this->searchPhone->PhoneNumber, true);
        $criteria->compare('Emails.Address', $this->searchEmail->Address, true);
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
        ));
    }

    /* Metodi statici */
    /* Ajax */
}
