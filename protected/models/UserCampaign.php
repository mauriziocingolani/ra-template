<?php

/**
 * @property integer $UserCampaignID
 * @property integer $UserID
 * @property integer $CampaignID
 * 
 * Getters
 * @property Company[] $toDoCompanies
 * @property Company[] $recallCompanies
 * 
 * Relazioni
 * @property Campaign $CampaignID
 * @property User $UserID
 */
class UserCampaign extends CActiveRecord {

    public function relations() {
        return array(
            'Campaign' => array(self::BELONGS_TO, 'Campaign', 'CampaignID'),
            'User' => array(self::BELONGS_TO, 'User', 'UserID'),
        );
    }

    public function tableName() {
        return 'users_campaigns';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Eventi */
    /* Implementazione interfaccia DatabaseObject */
    /* Metodi */

    public function getTodoCompanies() {
        return Company::model()->findAll(array(
                    'join' => 'INNER JOIN campaigns_companies cc USING(CompanyID)',
                    'condition' => 'CampaignID=:campaignid AND NOT EXISTS (' .
                    'SELECT * FROM activities ' .
                    'JOIN activity_types USING(ActivityTypeID) ' .
                    'WHERE CampaignID=cc.CampaignID ' .
                    'AND CompanyID=cc.CompanyID ' .
                    ')',
                    'params' => array(':campaignid' => $this->CampaignID),
        ));
    }

    public function getRecallCompanies() {
        return Activity::model()->findAll(array(
                    'condition' => 'CampaignID=:campaignid AND NOT EXISTS (' .
                    'SELECT * FROM activities WHERE CampaignID=:campaignid AND CompanyID = t.CompanyID AND ActivityTypeID<>1)' .
                    'AND RecallDateTime=(' .
                    'SELECT MAX(RecallDateTime) FROM activities WHERE CampaignID=:campaignid AND CompanyID = t.CompanyID AND ActivityTypeID = 1)',
                    'params' => array(':campaignid' => $this->CampaignID),
                    'order' => 'CASE WHEN RecallPrioritary = 1 AND RecallDateTime<NOW() THEN 0 ELSE 1 END, RecallDateTime',
        ));
    }

    /* Metodi statici */
    /* Ajax */
}
