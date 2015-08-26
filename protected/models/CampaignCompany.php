<?php

/**
 * @property Campaign $Campaign
 * @property Company $Company
 */
class CampaignCompany extends AbstractDatabaseObject {

    public $CampaignCompanyID;
    public $CampaignID;
    public $CompanyID;

    public function relations() {
        return array(
            'Campaign' => array(self::BELONGS_TO, 'Campaign', 'CampaignID'),
            'Company' => array(self::BELONGS_TO, 'Company', 'CompanyID'),
        );
    }

    public function tableName() {
        return 'campaigns_companies';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Eventi */
    /* Implementazione interfaccia DatabaseObject */

    public static function CreateRecord(array $parameters) {
        $cc = new CampaignCompany;
        $cc->CampaignID = $parameters['CampaignID'];
        $cc->CompanyID = $parameters['CompanyID'];
        $cc->save();
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
