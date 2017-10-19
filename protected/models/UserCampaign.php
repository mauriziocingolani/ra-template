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
        $criteria = new CDbCriteria;
        $criteria->with = array();
        $criteria->join = 'INNER JOIN campaigns_companies cc USING(CompanyID)';
        $criteria->addCondition('CampaignID=:campaignid');
        $criteria->addCondition('NOT EXISTS (' .
                'SELECT * FROM activities ' .
                'JOIN activity_types USING(ActivityTypeID) ' .
                'WHERE CampaignID=cc.CampaignID ' .
                'AND CompanyID=cc.CompanyID ' .
                "AND Category NOT IN ('N') " .
                ')');
        $criteria->params = array(':campaignid' => $this->CampaignID);
        return Company::model()->findAll($criteria);
    }

    public function getRecallCompanies() {
        $criteria = new CDbCriteria;
        $criteria->with = array('Creator', 'Company');
        $criteria->addCondition('CampaignID=:campaignid');
        $criteria->addCondition('NOT EXISTS (SELECT * FROM activities WHERE CampaignID=:campaignid AND CompanyID = t.CompanyID AND ActivityTypeID NOT IN (1,8))');
        $criteria->addCondition('RecallDateTime=(SELECT MAX(RecallDateTime) FROM activities WHERE CampaignID=:campaignid AND CompanyID = t.CompanyID AND ActivityTypeID = 1)');
        $criteria->params = array(':campaignid' => $this->CampaignID);
        $criteria->order = 'CASE WHEN RecallPrioritary = 1 AND RecallDateTime<NOW() THEN 0 ELSE 1 END, RecallDateTime';
        return Activity::model()->findAll($criteria);
    }

    /* Metodi statici */
    /* Ajax */
}
