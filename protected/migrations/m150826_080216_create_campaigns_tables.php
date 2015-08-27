<?php

class m150826_080216_create_campaigns_tables extends DbMigration {

    public function safeUp() {
        # campaigns
        $this->createTable('campaigns', array(
            'CampaignID' => self::Pk(),
            'Created' => self::TypeDate(true),
            'CreatedBy' => self::TypeInt(),
            'Name' => self::TypeVarchar(25),
            'ScriptTable' => self::TypeVarchar(),
            'Pin' => "varchar(3) NOT NULL DEFAULT '0'",
            'StartDate' => self::TypeDate(),
            'EndDate' => self::TypeDate(),
            'Notes' => 'text',
            self::Pk('CampaignID'),
            'UNIQUE KEY unique_campaigns_name (Name)',
                ), self::TableOptions());
        $this->addForeignKey('fk_campaigns_createdby', 'campaigns', 'CreatedBy', 'users', 'UserID');
        # campaigns_companies
        $this->createTable('campaigns_companies', array(
            'CampaignCompanyID' => self::Pk(),
            'CampaignID' => self::TypeInt(true),
            'CompanyID' => self::TypeInt(true),
            self::Pk('CampaignCompanyID'),
            'UNIQUE KEY unique_campaignscompanies_camapaigncompany (CampaignID,CompanyID)',
                ), self::TableOptions());
        $this->addForeignKey('fk_campaignscompanies_campaign', 'campaigns_companies', 'CampaignID', 'campaigns');
        $this->addForeignKey('fk_campaignscompanies_company', 'campaigns_companies', 'CompanyID', 'companies');
        # users_campaigns
        $this->createTable('users_campaigns', array(
            'UserCampaignID' => self::Pk(),
            'UserID' => self::TypeInt(true),
            'CampaignID' => self::TypeInt(true),
            self::Pk('UserCampaignID'),
            'UNIQUE KEY unique_userscampaigns_usercampaign (UserID,CampaignID)',
                ), self::TableOptions());
        $this->addForeignKey('fk_userscampaigns_campaign', 'users_campaigns', 'CampaignID', 'campaigns');
        $this->addForeignKey('fk_userscampaigns_user', 'users_campaigns', 'UserID', 'users');
        # script di esempio
        $this->createTable('script_1a0f3f9_test', array(
            'ScriptID' => self::Pk(),
            'Created' => self::TypeDate(true),
            'CreatedBy' => self::TypeInt(),
            'CampaignID' => self::TypeInt(true),
            'CompanyID' => self::TypeInt(true),
            self::Pk('ScriptID'),
            'Q1' => "text NOT NULL",
            'Q2' => "enum('Opzione1','Opzione2','Altro') NOT NULL",
            'Q2t' => 'text DEFAULT NULL',
                ), self::TableOptions());
        $this->addForeignKey('fk_script1a0f3f9test_createdby', 'script_1a0f3f9_test', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_script1a0f3f9test_campaign', 'script_1a0f3f9_test', 'CampaignID', 'campaigns');
        $this->addForeignKey('fk_script1a0f3f9test_company', 'script_1a0f3f9_test', 'CompanyID', 'companies');
        # activity_types
        $this->createTable('activity_types', array(
            'ActivityTypeID' => self::Pk(),
            'Description' => self::TypeVarchar(255, true),
            'Category' => "enum('R','C','S') NOT NULL",
            'Ordering' => 'tinyint(3) NOT NULL',
            self::Pk('ActivityTypeID'),
                ), self::TableOptions());
        $this->insertMultiple('activity_types', array(
            array('ActivityTypeID' => '1', 'Description' => 'Richiamo', 'Category' => 'R', 'Ordering' => 50),
            array('ActivityTypeID' => '2', 'Description' => 'Numero errato', 'Category' => 'C', 'Ordering' => 45),
            array('ActivityTypeID' => '3', 'Description' => 'Non risponde', 'Category' => 'C', 'Ordering' => 40),
            array('ActivityTypeID' => '4', 'Description' => 'Successo', 'Category' => 'S', 'Ordering' => 35),
            array('ActivityTypeID' => '5', 'Description' => 'Insuccesso', 'Category' => 'C', 'Ordering' => 30),
            array('ActivityTypeID' => '6', 'Description' => 'Fuori target', 'Category' => 'C', 'Ordering' => 25),
            array('ActivityTypeID' => '7', 'Description' => 'Cessata attività', 'Category' => 'C', 'Ordering' => 20),
        ));
        # activities
        $this->createTable('activities', array(
            'ActivityID' => self::Pk(),
            'Created' => self::TypeDate(true),
            'CreatedBy' => self::TypeInt(),
            'CompanyID' => self::TypeInt(true),
            'CampaignID' => self::TypeInt(true),
            'ContactID' => self::TypeInt(),
            'ActivityTypeID' => self::TypeInt(true),
            'RecallDateTime' => self::TypeDate(true),
            'RecallPrioritary' => "tinyint(1) DEFAULT '0'",
            'Notes' => 'text DEFAULT NULL',
            self::Pk('ActivityID'),
                ), self::TableOptions());
        $this->addForeignKey('fk_activities_createdby', 'activities', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_activities_company', 'activities', 'CompanyID', 'companies');
        $this->addForeignKey('fk_activities_campaign', 'activities', 'CampaignID', 'campaigns');
        $this->addForeignKey('fk_activities_contact', 'activities', 'ContactID', 'company_contacts');
        $this->addForeignKey('fk_activities_activitytype', 'activities', 'ActivityTypeID', 'activity_types');
    }

    public function safeDown() {
        $this->dropTable('activity_types');
        $this->dropTable('activities');
        $this->dropTable('campaigns');
        $this->dropTable('script_1a0f3f9_test');
        $this->dropTable('users_campaigns');
        $this->dropTable('campaigns_companies');
    }

}
