<?php

/**
 * @property integer $UserID
 * @property integer $RoleID
 * @property string $UserName
 * @property string $FirstName
 * @property string $LastName
 * @property string $Gender
 * @property string $Password
 * @property string $NewPassword
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

    public function attributeLabels() {
        return array(
            'RoleID' => 'Ruolo',
            'UserName' => 'Nome utente',
            'FirstName' => 'Nome',
            'LastName' => 'Cognome',
            'Gender' => 'Sesso',
        );
    }

    public function relations() {
        return array(
            'Role' => array(self::BELONGS_TO, 'Role', 'RoleID'),
            'Campaigns' => array(self::HAS_MANY, 'UserCampaign', 'UserID', 'with' => array('Campaign'), 'together' => false),
        );
    }

    public function rules() {
        return array(
            array('UserName, FirstName, LastName', 'required', 'message' => 'Campo obbligatorio'),
            array('Email', 'email', 'message' => 'Indirizzo email non valido'),
            array('RoleID, Gender', 'safe'),
            array('NewPassword', 'default'),
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

    public function getGenderOptions() {
        return self::GetEnumValues($this->tableName(), 'Gender', true);
    }

    public function getLastCompanies() {
        /*
         * non è chiaro perchè mettendo distinct=true si perdono
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

    public function hasCampaign($campaignid) {
        foreach ($this->Campaigns as $cam) :
            if ($cam->CampaignID == $campaignid)
                return true;
        endforeach;
        return false;
    }

    public function resetPassword() {
        try {
            $this->Password = $this->NewPassword;
            $this->NewPassword = null;
            $this->save();
            return false;
        } catch (CDbException $e) {
            return $e->getMessage();
        }
    }

    public function saveModel() {
        if ($this->validate()) {
            try {
                $transaction = Yii::app()->db->beginTransaction();
                $password = PasswordHelper::GeneratePassword(20, true);
                $this->Enabled = 1;
                $this->Password = CPasswordHelper::hashPassword($password);
                if ($this->save(false)) :
                    $message = new YiiMailMessage;
                    $message->view = 'account';
                    $message->from = 'webmaster@remoteaccount.it';
                    $message->subject = 'Remote Account Template - Account gestionale';
                    $message->setBody(array('username' => $this->UserName, 'password' => $password), 'text/html');
                    $message->setTo($this->Email ? $this->Email : Yii::app()->params['admin']['email']);
                    $message->setCc(Yii::app()->params['admin']['email']);
                    if (!Yii::app()->mail->send($message)) :
                        $transaction->rollback();
                        return 'Imposssibile inviare il messaggio email con le credenziali del nuovo utente. Creazione abortita.';
                    endif;
                endif;
                $transaction->commit();
                return true;
            } catch (CDbException $e) {
                $transaction->rollback();
                return $e->getMessage();
            }
        }
    }

    /* Metodi statici */

    public static function FindUserByKey($key) {
        # la key è generata dal metodo sendInstructions() di ForgottenPasswordForm
        return self::model()->find('NewPassword IS NOT NULL AND SHA1(CONCAT(UserID,NewPassword))=:key', array(':key' => $key));
    }

    public static function GetUserByUsername($username, $email = false) {
        $criteria = new CDbCriteria;
        $criteria->addCondition('UserName=:username');
        $criteria->params = array(':username' => $username);
        if ($email)
            $criteria->addCondition('Email=:username', 'OR');
        return self::model()->find($criteria);
    }

    public static function GetOperatori() {
        $criteria = new CDbCriteria;
        $criteria->condition = 'Enabled=1';
        $roles = array(ApplicationWebUser::ROLE_OPERATORE);
        if (Yii::app()->user->isDeveloper())
            $roles = array_merge($roles, array(ApplicationWebUser::ROLE_SUPERVISOR, ApplicationWebUser::ROLE_DEVELOPER));
        $criteria->addInCondition('RoleID', $roles);
        $criteria->order = 'UserName';
        return self::model()->findAll($criteria);
    }

    /* Ajax */
}
