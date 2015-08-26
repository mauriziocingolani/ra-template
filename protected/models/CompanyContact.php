<?php

/**
 * @property integer $ContactID
 * @property integer $CompanyID
 * @property string $FirstName
 * @property string $LastName
 * @property string $Role
 * @property string $Phone
 * @property string $Email
 * @property string $Notes
 * 
 * @property Company $Company
 */
class CompanyContact extends AbstractDatabaseObject {

    public function attributeLabels() {
        return array(
            'FirstName' => 'Nome',
            'LastName' => 'Cognome',
            'Role' => 'Ruolo',
            'Phone' => 'Telefono',
            'Notes' => 'Note',
        );
    }

    public function relations() {
        return array(
            'Company' => array(self::BELONGS_TO, 'Company', 'CompanyID'),
        );
    }

    public function rules() {
        return array(
            array('FirstName', 'required', 'message' => 'Inserisci il nome'),
            array('LastName', 'required', 'message' => 'Inserisci il cognome'),
            array('Phone', 'match', 'pattern' => '/^[+]?[0-9 ]+$/u', 'message' => 'Numero di telefono non valido'),
            array('Email', 'email', 'message' => 'Indirizzo email non valido'),
            array('Role, Notes', 'safe'),
        );
    }

    public function tableName() {
        return 'company_contacts';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Eventi */
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

    public function getCompleteName($lastNameFirst = false) {
        return $lastNameFirst ? "$this->LastName $this->FirstName" : "$this->FirstName $this->LastName";
    }

    /* Metodi statici */

    public static function ImportNewContact(XlsContatto $xls) {
        $contatto = new CompanyContact;
        $contatto->CompanyID = Company::GetByCode($xls->Codice);
        $contatto->FirstName = $xls->Nome;
        $contatto->LastName = strlen($xls->Cognome) > 0 ? $xls->Cognome : '.';
        $contatto->Role = $xls->Ruolo;
        $contatto->Phone = $xls->Telefono;
        $contatto->Email = $xls->Email;
        $contatto->Notes = $xls->Note;
        $contatto->save();
    }

    /* Ajax */
}
