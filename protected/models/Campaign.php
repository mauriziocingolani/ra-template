<?php

/**
 * @property integer $CampaignID
 * @property string $Name
 * @property string $ScriptTable
 * @property string $Pin
 * @property integer $StartDate
 * @property integer $EndDate
 * @property string $Notes
 * 
 * Relazioni
 * @property User[] $Users
 * @property integer $Companies
 * @property CampaignCompany[] $CampaignsCompanies
 * @property Company[] $CampaignCompanies
 */
class Campaign extends AbstractDatabaseObject {

    public $searchUser; # campo di ricerca operatori
    private $_users; # lista id degli utenti assegnati
    private $_script;
    private static $_scripts;

    public function attributeLabels() {
        return array(
            'CampaignID' => 'ID',
            'Name' => 'Nome (max 25 car.)',
            'ScriptTable' => 'Tabella script',
            'StartDate' => 'Data inizio',
            'Pin' => 'Pin di uscita',
            'EndDate' => 'Data fine',
            'Notes' => 'Note',
            'Companies' => 'Agenzie',
        );
    }

    public function behaviors() {
        return array(
            'CampaignReports' => array('class' => 'application.extensions.behaviors.CampaignReports'),
        );
    }

    public function relations() {
        return array(
            'Users' => array(self::HAS_MANY, 'UserCampaign', 'CampaignID', 'with' => 'User', 'together' => false, 'order' => 'UserName'),
            'Companies' => array(self::STAT, 'CampaignCompany', 'CampaignID'),
            'CampaignsCompanies' => array(self::HAS_MANY, 'CampaignCompany', 'CampaignID'),
            'CampaignCompanies' => array(self::HAS_MANY, 'Company', array('CompanyID' => 'CompanyID'), 'through' => 'CampaignsCompanies'),
        );
    }

    public function rules() {
        return array(
            array('Name', 'required', 'message' => 'Inserisci il nome della campagna'),
            array('Name', 'length', 'max' => 25, 'tooLong' => 'Il nome non deve superare i 25 caratteri di lunghezza'),
            array('ScriptTable', 'required', 'message' => 'Seleziona lo script per la campagna'),
            array('StartDate', 'required', 'message' => 'Inserisci la data di inizio'),
            array('EndDate', 'compare', 'compareAttribute' => 'StartDate', 'operator' => '>', 'allowEmpty' => true, 'message' => 'La data di fine deve essere successiva a quella di inizio'),
            array('CampaignID, ScriptTable,Notes', 'safe'),
            array('Pin', 'default', 'value' => '0'),
            array('Pin', 'length', 'max' => 3, 'tooLong' => 'Il Pin di uscita pu&ograve; essere lungo al massimo 3 cifre'),
        );
    }

    public function tableName() {
        return 'campaigns';
    }

    public static function model($className = __CLASS__) {
        return parent::model($className);
    }

    /* Eventi */

    protected function beforeSave() {
        if (parent::beforeSave()) :
            if (strlen($this->EndDate) == 0 || $this->EndDate == '0000-00-00')
                $this->EndDate = null;
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

    public function getDates() {
        return date('d/m/Y', strtotime($this->StartDate)) .
                ($this->EndDate ? ' - ' . date('d/m/Y', strtotime($this->EndDate)) : '');
    }

    public function getProfileModel() {
        if (!$this->_script)
            $this->_script = new ScriptObject($this->ScriptTable);
        return $this->_script->objectName;
    }

    public function getStatistiche() {
# totali
        $command = Yii::app()->db->createCommand("SELECT COUNT(*) AS N FROM campaigns_companies WHERE CampaignID=$this->CampaignID");
        $data['totali'] = (int) $command->queryScalar();
# da gestire
        $command = Yii::app()->db->createCommand(
                "SELECT COUNT(*) AS N FROM campaigns_companies cc WHERE CampaignID=$this->CampaignID " .
                "AND NOT EXISTS (SELECT * FROM activities WHERE CampaignID=cc.CampaignID AND CompanyID=cc.CompanyID)");
        $data['dagestire'] = (int) $command->queryScalar();
# chiusi
        $command = Yii::app()->db->createCommand(
                "SELECT COUNT(*) AS N FROM campaigns_companies cc WHERE CampaignID=$this->CampaignID " .
                "AND EXISTS (SELECT * FROM activities " .
                "JOIN activity_types USING(ActivityTypeID) " .
                "WHERE CampaignID=cc.CampaignID AND CompanyID=cc.CompanyID AND Category IN ('C','S'))");
        $data['chiusi'] = (int) $command->queryScalar();
# successi
        $command = Yii::app()->db->createCommand(
                "SELECT COUNT(*) AS N FROM campaigns_companies cc WHERE CampaignID=$this->CampaignID " .
                "AND EXISTS (SELECT * FROM activities " .
                "JOIN activity_types USING(ActivityTypeID) " .
                "WHERE CampaignID=cc.CampaignID AND CompanyID=cc.CompanyID AND Category='S')");
        $data['successi'] = (int) $command->queryScalar();
# richiami
        $command = Yii::app()->db->createCommand(
                "SELECT COUNT(*) AS N FROM campaigns_companies cc WHERE CampaignID=$this->CampaignID " .
                "AND EXISTS (SELECT * FROM activities " .
                "JOIN activity_types USING(ActivityTypeID) " .
                "WHERE CampaignID=cc.CampaignID AND CompanyID=cc.CompanyID AND Category='R')" .
                "AND NOT EXISTS (SELECT * FROM activities " .
                "JOIN activity_types USING(ActivityTypeID) " .
                "WHERE CampaignID=cc.CampaignID AND CompanyID=cc.CompanyID AND Category NOT IN ('R','N'))");
        $data['richiami'] = (int) $command->queryScalar();
# percentuali
        $data['dagestireperc'] = $data['totali'] > 0 ? sprintf("%.1f%%", $data['dagestire'] / $data['totali'] * 100) : '0.0%'; # da gestiere su totali
        $data['chiusiperc'] = $data['totali'] - $data['dagestire'] > 0 ? sprintf("%.1f%%", $data['chiusi'] / ($data['totali'] - $data['dagestire']) * 100) : '0.0%'; # chiusi su lavorati (totali - dagestire)
        $data['successiperc'] = $data['chiusi'] > 0 ? sprintf("%.1f%%", $data['successi'] / $data['chiusi'] * 100) : '0.0%'; # successi su chiusi 
        $data['avanzamentoperc'] = $data['totali'] > 0 ? sprintf("%.1f%%", $data['chiusi'] / $data['totali'] * 100) : '0.0%'; # successi su chiusi 
        return $data;
    }

    public function search() {
        $criteria = new CDbCriteria;
        $criteria->with = array('Users');
        $criteria->together = true;
        $criteria->compare('CampaignID', $this->CampaignID, true);
        $criteria->compare('Name', $this->Name, true);
        $criteria->compare('ScriptTable', $this->ScriptTable, true);
        $criteria->compare('Pin', $this->Pin, true);
        $criteria->compare('StartDate', $this->StartDate, true);
        $criteria->compare('EndDate', $this->EndDate, true);
        $criteria->compare('Notes', $this->Notes, true);
//        $criteria->compare('UserName', $this->searchUser->UserName, true);
        if ($this->searchUser->UserName) :
            $criteria->addCondition('EXISTS (' .
                    'SELECT * FROM users_campaigns ' .
                    'JOIN users USING(UserID) ' .
                    'WHERE CampaignID=t.CampaignID ' .
                    'AND UserName LIKE (:user) ' .
                    ')');
            $criteria->params = array(':user' => '%' . $this->searchUser->UserName . '%');
        endif;
        $criteria->order = 'StartDate DESC';
        return new CActiveDataProvider($this, array(
            'criteria' => $criteria,
            'pagination' => false,
        ));
    }

    /**
     * 
     * @param array $parameters
     */
    public function setOperators(array $parameters) {
        UserCampaign::model()->deleteAll('CampaignID=:campaignid', array(':campaignid' => $this->CampaignID));
        /* Per far comparire l'elemento 'CampaignOperators' in $_POST durante il submit della form
         * l'array contiene sempre il parametro dummy 'foo'. Quindi gli operatori vanno assegnati solo se
         * l'array ha >=2 elementi. */
        if (count($parameters) > 1) :
            foreach ($parameters as $userid => $xxx) :
                if ($userid == 'foo')
                    continue;
                $model = new UserCampaign;
                $model->UserID = $userid;
                $model->CampaignID = $this->CampaignID;
                $model->save();
            endforeach;
        endif;
    }

    public function hasUser($userid) {
        if ($this->_users == null) :
            $this->_users = new CList;
            foreach ($this->Users as $u) :
                $this->_users->add((int) $u->UserID);
            endforeach;
        endif;
        return $this->_users->contains((int) $userid);
    }

    /* Metodi statici */

    public static function GetAll() {
        return self::model()->findAll(array('order' => 'StartDate DESC'));
    }

    public static function GetAssociable($companyid) {
        if ($companyid) :
            $criteria = new CDbCriteria;
            $criteria->addCondition('NOT EXISTS (' .
                    'SELECT * FROM campaigns_companies ' .
                    "WHERE CompanyID=:companyid " .
                    "AND CampaignID=t.CampaignID" .
                    ')');
            $criteria->params = array(':companyid' => $companyid);
            $criteria->order = 'StartDate DESC';
            return self::model()->findAll($criteria);
        endif;
        return array();
    }

    public static function GetScripts() {
        $tables = Yii::app()->db->schema->getTableNames();
        $scripts = array();
        foreach ($tables as $table) :
            if (strpos($table, 'script_') !== false) :
                $scr = new ScriptObject($table);
                if (!self::$_scripts)
                    self::$_scripts = new CList;
                self::$_scripts->add($scr);
                $scripts[$scr->tableName] = $scr->tableName;
            endif;
        endforeach;
        return $scripts;
    }

    public static function ReportCampaign(array $parameters) {
        $startdate = $parameters['startdate'];
        $enddate = $parameters['enddate'];
        # campagna
        $campaign = Campaign::model()->
                with('CampaignCompanies', 'CampaignCompanies.Addresses', 'CampaignCompanies.Contacts', 'CampaignCompanies.Phones', 'CampaignCompanies.Emails', 'CampaignCompanies.Addresses.Provincia', 'CampaignCompanies.Addresses.Regione', 'CampaignCompanies.Addresses.Nazione', 'CampaignCompanies.Activities', 'CampaignCompanies.Activities.ActivityType')->
                findByPk((int) $parameters['campaignid']);
        return $campaign->createXlsxReport($campaign, $startdate, $enddate); # metodo definito nel behavior CampaignReports
    }

    /* Ajax */
}
