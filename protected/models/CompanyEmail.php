<?php

/**
 * @property integer $CompanyEmailID
 * @property integer $CompanyID
 * @property integer $Address
 * @property Company $Company
 */
class CompanyEmail extends AbstractDatabaseObject {

    public function attributeLabels() {
        return array(
            'Address' => 'Indirizzo',
        );
    }

    public function relations() {
        return array(
            'Company' => array(self::BELONGS_TO, 'Company', 'CompanyID'),
        );
    }

    public function rules() {
        return array(
            array('Address', 'required', 'message' => 'Inserisci l\'indirizzo email'),
            array('Address', 'email', 'message' => 'Indirizzo email non valido'),
        );
    }

    public function tableName() {
        return 'company_emails';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Eventi */
    /* Implementazione interfaccia DatabaseObject */

    public static function CreateRecord(array $parameters) {
        $email = new CompanyEmail;
        $email->CompanyID = $parameters['CompanyID'];
        $email->Address = $parameters['Address'];
        $email->save();
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
