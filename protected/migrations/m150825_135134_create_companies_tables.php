<?php

class m150825_135134_create_companies_tables extends CDbMigration {

    public function safeUp() {
        #companies
        $this->createTable('companies', array(
            'CompanyID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'Created' => 'datetime DEFAULT NULL',
            'CreatedBy' => 'int(11) unsigned DEFAULT NULL',
            'Updated' => 'datetime DEFAULT NULL',
            'UpdatedBy' => 'int(11) unsigned DEFAULT NULL',
            'CompanyName' => 'varchar(500) NOT NULL',
            'CompanyLegalName' => 'varchar(500) DEFAULT NULL',
            'CompanyGroup' => 'varchar(500) DEFAULT NULL',
            'CompanyCode' => 'int(11) unsigned DEFAULT NULL',
            'Notes' => 'text',
            'Slug' => 'varchar(500) NOT NULL',
            'PRIMARY KEY (CompanyID)',
            'KEY index_companies_companyname (CompanyName)',
            'KEY index_companies_companycode (CompanyCode)',
                ), 'ENGINE = InnoDB CHARSET = latin1');
        $this->addForeignKey('fk_companies_createdby', 'companies', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companies_updatedby', 'companies', 'UpdatedBy', 'users', 'UserID');
        #company_addresses
        $this->createTable('company_addresses', array(
            'CompanyAddressID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'Created' => 'datetime DEFAULT NULL',
            'CreatedBy' => 'int(11) unsigned DEFAULT NULL',
            'Updated' => 'datetime DEFAULT NULL',
            'UpdatedBy' => 'int(11) unsigned DEFAULT NULL',
            'CompanyID' => 'int(11) unsigned NOT NULL',
            'NazioneID' => 'int(11) unsigned NOT NULL',
            'RegioneID' => 'int(11) unsigned DEFAULT NULL',
            'ProvinciaID' => 'int(11) unsigned DEFAULT NULL',
            'City' => 'varchar(255) NOT NULL',
            'Address' => 'varchar(500) NOT NULL',
            'ZipCode' => 'char(5) DEFAULT NULL',
            'AddressType' => "enum('Sede','Fatturazione') NOT NULL",
            'PRIMARY KEY (CompanyAddressID)',
                ), 'ENGINE = InnoDB CHARSET = latin1');
        $this->addForeignKey('fk_companyaddresses_createdby', 'company_addresses', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyaddresses_updatedby', 'company_addresses', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyaddresses_company', 'company_addresses', 'CompanyID', 'companies', 'CompanyID');
        $this->addForeignKey('fk_companyaddresses_nazione', 'company_addresses', 'NazioneID', 'nazioni', 'NazioneID');
        $this->addForeignKey('fk_companyaddresses_regione', 'company_addresses', 'RegioneID', 'regioni', 'RegioneID');
        $this->addForeignKey('fk_companyaddresses_provincia', 'company_addresses', 'ProvinciaID', 'province', 'ProvinciaID');
        #company_contacts
        $this->createTable('company_contacts', array(
            'ContactID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'Created' => 'datetime DEFAULT NULL',
            'CreatedBy' => 'int(11) unsigned DEFAULT NULL',
            'Updated' => 'datetime DEFAULT NULL',
            'UpdatedBy' => 'int(11) unsigned DEFAULT NULL',
            'CompanyID' => 'int(11) unsigned NOT NULL',
            'FirstName' => 'varchar(255) NOT NULL',
            'LastName' => 'varchar(255) NOT NULL',
            'Role' => 'varchar(255) DEFAULT NULL',
            'Phone' => 'varchar(50) DEFAULT NULL',
            'Email' => 'varchar(255) DEFAULT NULL',
            'Notes' => 'text',
            'PRIMARY KEY (ContactID)',
                ), 'ENGINE = InnoDB CHARSET = latin1');
        $this->addForeignKey('fk_companycontacts_createdby', 'company_contacts', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companycontacts_updatedby', 'company_contacts', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companycontacts_company', 'company_contacts', 'CompanyID', 'companies', 'CompanyID');
        #company_emails
        $this->createTable('company_emails', array(
            'CompanyEmailID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'Created' => 'datetime DEFAULT NULL',
            'CreatedBy' => 'int(11) unsigned DEFAULT NULL',
            'Updated' => 'datetime DEFAULT NULL',
            'UpdatedBy' => 'int(11) unsigned DEFAULT NULL',
            'CompanyID' => 'int(11) unsigned NOT NULL',
            'Address' => 'varchar(255) NOT NULL',
            'PRIMARY KEY (CompanyEmailID)',
            'UNIQUE KEY unique_companyemails_companyaddress (CompanyID,Address)',
                ), 'ENGINE = InnoDB CHARSET = latin1');
        $this->addForeignKey('fk_companyemails_createdby', 'company_emails', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyemails_updatedby', 'company_emails', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyemails_company', 'company_emails', 'CompanyID', 'companies', 'CompanyID');
        #company_phones
        $this->createTable('company_phones', array(
            'CompanyPhoneID' => 'int(11) unsigned NOT NULL AUTO_INCREMENT',
            'Created' => 'datetime DEFAULT NULL',
            'CreatedBy' => 'int(11) unsigned DEFAULT NULL',
            'Updated' => 'datetime DEFAULT NULL',
            'UpdatedBy' => 'int(11) unsigned DEFAULT NULL',
            'CompanyID' => 'int(11) unsigned NOT NULL',
            'PhoneNumber' => 'varchar(50) NOT NULL',
            'PhoneType' => "enum('Fisso','Cellulare','Fax') NOT NULL",
            'PRIMARY KEY (CompanyPhoneID)',
            'UNIQUE KEY unique_companyphones_companynumbertype (CompanyID,PhoneNumber,PhoneType)',
                ), 'ENGINE = InnoDB CHARSET = latin1');
        $this->addForeignKey('fk_companyphones_createdby', 'company_phones', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyphones_updatedby', 'company_phones', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyphones_company', 'company_phones', 'CompanyID', 'companies', 'CompanyID');
    }

    public function safeDown() {
        $this->dropTable('company_phones');
        $this->dropTable('company_emails');
        $this->dropTable('company_contacts');
        $this->dropTable('company_addresses');
        $this->dropTable('companies');
    }

}
