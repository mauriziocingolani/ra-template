<?php

/**
 * @property integer $UserID
 * @property integer $RoleID
 * @property string $UserName
 * @property string $FirstName
 * @property string $LastName
 * @property string $Gender
 * @property string $Password
 * @property string $Email
 * @property integer $Enabled
 * 
 * Getters
 * @property Company[] $lastCompanies;
 * 
 * Relazioni
 * @property Role $role
 * @property UserCampaign[] $Campaigns
 */
class User extends AbstractUserObject {

    public function relations() {
        return array(
            'Role' => array(self::BELONGS_TO, 'Role', 'RoleID'),
            'Campaigns' => array(self::HAS_MANY, 'UserCampaign', 'UserID', 'with' => array('Campaign'), 'together' => false),
        );
    }

    public function tableName() {
        return 'users';
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
        
    }

    public static function UpdateRecord($pk, array $parameters) {
        
    }

    /* Metodi */

    public function hasCampaign($campaignid) {
        foreach ($this->Campaigns as $cam) :
            if ($cam->CampaignID == $campaignid)
                return true;
        endforeach;
        return false;
    }

    public function getLastCompanies() {
        /*
         * non è chiaro perchè mettendo distinct=true di perdono
         * le aziende con attività multiple...
         */
        $lastUpdated = Company::model()->findAll(array(
            'join' => 'LEFT JOIN company_addresses ca USING(CompanyID) ' .
            'LEFT JOIN company_contacts cc USING(CompanyID) ' .
            'LEFT JOIN company_phones cp USING(CompanyID) ' .
            'LEFT JOIN company_emails ce USING(CompanyID) ' .
            'LEFT JOIN activities a USING(CompanyID) ',
            'condition' => 't.UpdatedBy=:userid OR ' .
            'ca.UpdatedBy=:userid OR cc.UpdatedBy=:userid OR ' .
            'cp.UpdatedBy=:userid OR ce.UpdatedBy=:userid OR ' .
            'a.CreatedBy=:userid',
            'distinct' => false,
            'params' => array(':userid' => $this->UserID),
            'order' => 'GREATEST(' .
            'CASE WHEN t.Updated IS NOT NULL THEN t.Updated ELSE 1 END,' .
            'CASE WHEN ca.Updated IS NOT NULL THEN ca.Updated ELSE 1 END,' .
            'CASE WHEN cc.Updated IS NOT NULL THEN cc.Updated ELSE 1 END,' .
            'CASE WHEN cp.Updated IS NOT NULL THEN cp.Updated ELSE 1 END,' .
            'CASE WHEN ce.Updated IS NOT NULL THEN ce.Updated ELSE 1 END,' .
            'CASE WHEN a.Created IS NOT NULL THEN a.Created ELSE 1 END) DESC',
            'limit' => 30,
        ));
        $data = array();
        $ids = new CList;
        foreach ($lastUpdated as $c) :
            if (!$ids->contains($c->CompanyID)) :
                $ids->add($c->CompanyID);
                $data[] = $c;
            endif;
            if (count($data) == 5)
                break;
        endforeach;
        return $data;
    }

    public function getActiveCampaigns() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'UserID=:user';
        $criteria->params = array(':user' => $this->UserID);
        $criteria->with = array('Campaign');
        $criteria->order = 'StartDate DESC';
        $campaigns = UserCampaign::model()->findAll($criteria);

        return $campaigns;
    }

    /* Metodi statici */

    public static function GetUserByUsername($username) {
        return self::model()->find(array(
                    'condition' => 'UserName=:username',
                    'params' => array(':username' => $username),
        ));
    }

    public static function GetOperatori() {
        return self::model()->findAll(array(
                    'condition' => 'Enabled=1 AND RoleID=:role',
                    'params' => array(':role' => Role::ROLE_OPERATORE),
                    'order' => 'UserName',
        ));
    }

    /* Ajax */
}
