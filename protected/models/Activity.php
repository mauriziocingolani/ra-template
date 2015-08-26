<?php

/**
 * Campi db
 * @property integer $ActivityID
 * @property integer $CompanyID
 * @property integer $CampaignID
 * @property integer $ContactID
 * @property integer $ActivityTypeID
 * @property string $RecallDateTime
 * @property boolean $RecallPrioritary
 * @property string $Notes
 * 
 * Getters
 * @property boolean $isRecall
 * @property boolean $isClosed
 * @property boolean $isSuccess
 * @property string $createdString
 * 
 * Relazioni
 * @property User $Creator
 * @property Company $Company
 * @property Campaign $Campaign
 * @property CompanyContact $Contact
 * 
 * @property ActivityType $ActivityType
 */
class Activity extends AbstractDatabaseObject {

    public function attributeLabels() {
        return array(
            'ContactID' => 'Referente',
            'CampaignID' => 'Campagna',
            'ActivityTypeID' => 'Tipologia',
            'RecallDateTime' => 'Richiamo',
            'RecallPrioritary' => 'Richiamo prioritario',
            'Notes' => 'Note',
        );
    }

    public function relations() {
        return array(
            'Creator' => array(self::BELONGS_TO, 'User', 'CreatedBy'),
            'Company' => array(self::BELONGS_TO, 'Company', 'CompanyID'),
            'Campaign' => array(self::BELONGS_TO, 'Campaign', 'CampaignID'),
            'Contact' => array(self::BELONGS_TO, 'CompanyContact', 'ContactID'),
            'ActivityType' => array(self::BELONGS_TO, 'ActivityType', 'ActivityTypeID'),
        );
    }

    public function rules() {
        return array(
            array('ActivityTypeID, CompanyID, CampaignID, ContactID', 'safe'),
            array('RecallDateTime', 'richiamo', 'message' => 'Devi inserire la data e l\'ora del richiamo.'),
            array('RecallPrioritary, Notes', 'safe'),
        );
    }

    public function tableName() {
        return 'activities';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Eventi */

    protected function beforeSave() {
        if (parent::beforeSave()) :
            if ((int) $this->ContactID <= 0)
                $this->ContactID = null;
            if ($this->ActivityTypeID <> 1)
                $this->RecallDateTime = null;
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

    public function getCreatedString() {
        $d = strtotime($this->Created);
        return date('d-m-Y', $d) . ' alle ' . date('H:i', $d) . ' da <u>' . $this->Creator->UserName . '</u>';
    }

    public function richiamo($attribute, $params) {
        if ($this->ActivityType->isRecall && $this->RecallDateTime == null)
            $this->addError($attribute, $params['message']);
    }

    /* Metodi statici */
    /* Ajax */
}
