<?php

/**
 * 
 * @property integer $CompanyPhoneID
 * @property integer $CompanyID
 * @property string $PhoneNumber
 * @property string $PhoneType
 * @property Company $Company
 */
class CompanyPhone extends AbstractDatabaseObject {

    public function attributeLabels() {
        return array(
            'PhoneNumber' => 'Numero',
            'PhoneType' => 'Tipologia'
        );
    }

    public function relations() {
        return array(
            'Company' => array(self::BELONGS_TO, 'Company', 'CompanyID'),
        );
    }

    public function rules() {
        return array(
            array('PhoneNumber', 'required', 'message' => 'Inserisci il numero di telefono'),
            array('PhoneNumber', 'match', 'pattern' => '/^[+]?[0-9 ]+$/u', 'message' => 'Numero di telefono non valido'),
            array('PhoneType', 'safe'),
        );
    }

    public function tableName() {
        return 'company_phones';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Eventi */
    /* Implementazione interfaccia DatabaseObject */

    public static function CreateRecord(array $parameters) {
        $phone = new CompanyPhone;
        $phone->CompanyID = $parameters['CompanyID'];
        $phone->PhoneType = isset($parameters['PhoneType']) ? $parameters['PhoneType'] : 'Fisso';
        $phone->PhoneNumber = $parameters['PhoneNumber'];
        $phone->save();
    }

    public static function DeleteRecord($pk) {
        
    }

    public static function ReadRecord($pk) {
        
    }

    public static function UpdateRecord($pk, array $parameters) {
        
    }

    /* Metodi */
    /* Metodi statici */
    /* Ajax */
}
