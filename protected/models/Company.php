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
 * 
 * @property User $createdBy
 * @property User $updatedBy
 * @property CompaniesTags[] $companiesTags
 * @property CompanyAddresses[] $Addresses
 * @property CompanyContact[] $Contacts
 * @property CompanyPhones[] $Phones
 * @property CompanyEmails[] $Emails
 * @property Activity[] $Activities
 * @property CompanyRevenue[] $Revenues
 * @property CompanyVoucher[] $Vouchers
 * @property CampaignCompany[] $Campaigns
 * @property CampaignCompany[] $ActiveCampaigns
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
            'Activities' => array(self::HAS_MANY, 'Activity', 'CompanyID', 'order' => 'Campaign.StartDate DESC,Activities.Created DESC', 'with' => array('Creator', 'Campaign')),
            'Campaigns' => array(self::HAS_MANY, 'CampaignCompany', 'CompanyID', 'with' => 'Campaign', 'together' => false),
        );
    }

    public function rules() {
        return array(
            array('CompanyName', 'required', 'message' => 'Inserisci la ragione sociale'),
            array('CompanyID, CompanyLegalName, CompanyGroup, CompanyCode, Notes', 'safe'),
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

    public function getActiveCampaigns() {
        $criteria = new CDbCriteria;
        $criteria->addCondition('CompanyID=:companyid');
        $criteria->addCondition('NOT EXISTS (' .
                'SELECT * FROM activities ' .
                'JOIN activity_types USING(ActivityTypeID) ' .
                'WHERE CompanyID=t.CompanyID ' .
                'AND CampaignID=t.CampaignID ' .
                "AND Category NOT IN ('R','N') " .
                ')');
        $criteria->params = array(':companyid' => $this->CompanyID);
        if (!Yii::app()->user->isDeveloper()) :
            # per gli utenti normali limito le campagne attive a quelle assegnate loro
            $criteria->addCondition('EXISTS (' .
                    'SELECT * FROM users_campaigns ' .
                    'WHERE UserID=:userid ' .
                    'AND CampaignID=t.CampaignID ' .
                    ')');
            $criteria->params[':userid'] = Yii::app()->user->id;
        endif;
        return CampaignCompany::model()->findAll($criteria);
    }

    public function getAllActivities($campaignid = null) {
        $data = array();
        foreach ($this->Activities as $act) {
            if (!$campaignid || $campaignid == $act->CampaignID) :
                if (!isset($data[$act->CampaignID])) :
                    $data[$act->CampaignID] = array('campaign' => $act->Campaign, 'activities' => array());
                endif;
                $data[$act->CampaignID]['activities'][] = $act;
            endif;
        }
        return $data;
    }

    public function getAllProfiles() {
        $data = array();
        foreach ($this->Campaigns as $camp) {
            $n = $camp->Campaign->profileModel;
            $p = $n::FindUnique($n::model(), $camp->CampaignID, $this->CompanyID);
            if ($p)
                $data[$camp->Campaign->Name] = array(
                    'answers' => $p->getAnswers(),
                    'timestamp' => strtotime($p->Created),
                );
        }
        return $data;
    }

    public function getFieldsValuesForXlsx() {
        return array(
            $this->CompanyID,
            $this->CompanyName,
            $this->CompanyLegalName,
            $this->CompanyGroup,
            $this->CompanyCode,
            $this->Notes,
        );
    }

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

    public static function GetFieldsLabelsForXlsx() {
        return array(
            'CompanyID',
            'Ragione Sociale',
            'Forma giuridica',
            'Gruppo',
            'Codice',
            'Note',
        );
    }

    /* Ajax */
}
