<?php

class m150825_135134_create_companies_tables extends DbMigration {

    public function safeUp() {
        #companies
        $this->createTable('companies', array(
            'CompanyID' => self::Pk(),
            'Created' => self::TypeDate(true),
            'CreatedBy' => self::TypeInt(),
            'Updated' => self::TypeDate(true),
            'UpdatedBy' => self::TypeInt(),
            'CompanyName' => self::TypeVarchar(500, true),
            'CompanyLegalName' => self::TypeVarchar(500),
            'CompanyGroup' => self::TypeVarchar(500),
            'CompanyCode' => self::TypeVarchar(50),
            'Notes' => 'text',
            'Slug' => self::TypeVarchar(500, true),
            self::Pk('CompanyID'),
            'KEY index_companies_companyname (CompanyName)',
            'KEY index_companies_companycode (CompanyCode)',
                ), self::TableOptions());
        $this->addForeignKey('fk_companies_createdby', 'companies', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companies_updatedby', 'companies', 'UpdatedBy', 'users', 'UserID');
        #company_addresses
        $this->createTable('company_addresses', array(
            'CompanyAddressID' => self::Pk(),
            'Created' => self::TypeDate(true),
            'CreatedBy' => self::TypeInt(),
            'Updated' => self::TypeDate(true),
            'UpdatedBy' => self::TypeInt(),
            'CompanyID' => self::TypeInt(true),
            'NazioneID' => self::TypeInt(true),
            'RegioneID' => self::TypeInt(),
            'ProvinciaID' => self::TypeInt(),
            'City' => self::TypeVarchar(255, true),
            'Address' => self::TypeVarchar(500, true),
            'ZipCode' => self::TypeChar(5),
            'AddressType' => "enum('Sede','Fatturazione') NOT NULL",
            self::Pk('CompanyAddressID'),
                ), self::TableOptions());
        $this->addForeignKey('fk_companyaddresses_createdby', 'company_addresses', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyaddresses_updatedby', 'company_addresses', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyaddresses_company', 'company_addresses', 'CompanyID', 'companies');
        $this->addForeignKey('fk_companyaddresses_nazione', 'company_addresses', 'NazioneID', 'nazioni');
        $this->addForeignKey('fk_companyaddresses_regione', 'company_addresses', 'RegioneID', 'regioni');
        $this->addForeignKey('fk_companyaddresses_provincia', 'company_addresses', 'ProvinciaID', 'province');
        #company_contacts
        $this->createTable('company_contacts', array(
            'ContactID' => self::Pk(),
            'Created' => self::TypeDate(true),
            'CreatedBy' => self::TypeInt(),
            'Updated' => self::TypeDate(true),
            'UpdatedBy' => self::TypeInt(),
            'CompanyID' => self::TypeInt(true),
            'FirstName' => self::TypeVarchar(255, true),
            'LastName' => self::TypeVarchar(255, true),
            'Role' => self::TypeVarchar(255),
            'Phone' => self::TypeVarchar(255),
            'Email' => self::TypeVarchar(255),
            'Notes' => 'text',
            self::Pk('ContactID'),
                ), self::TableOptions());
        $this->addForeignKey('fk_companycontacts_createdby', 'company_contacts', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companycontacts_updatedby', 'company_contacts', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companycontacts_company', 'company_contacts', 'CompanyID', 'companies');
        #company_emails
        $this->createTable('company_emails', array(
            'CompanyEmailID' => self::Pk(),
            'Created' => self::TypeDate(true),
            'CreatedBy' => self::TypeInt(),
            'Updated' => self::TypeDate(true),
            'UpdatedBy' => self::TypeInt(),
            'CompanyID' => self::TypeInt(true),
            'Address' => self::TypeVarchar(255, true),
            self::Pk('CompanyEmailID'),
            'UNIQUE KEY unique_companyemails_companyaddress (CompanyID,Address)',
                ), self::TableOptions());
        $this->addForeignKey('fk_companyemails_createdby', 'company_emails', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyemails_updatedby', 'company_emails', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyemails_company', 'company_emails', 'CompanyID', 'companies');
        #company_phones
        $this->createTable('company_phones', array(
            'CompanyPhoneID' => self::Pk(),
            'Created' => self::TypeDate(true),
            'CreatedBy' => self::TypeInt(),
            'Updated' => self::TypeDate(true),
            'UpdatedBy' => self::TypeInt(),
            'CompanyID' => self::TypeInt(true),
            'PhoneNumber' => self::TypeVarchar(50, true),
            'PhoneType' => "enum('Fisso','Cellulare','Fax') NOT NULL",
            self::Pk('CompanyPhoneID'),
            'UNIQUE KEY unique_companyphones_companynumbertype (CompanyID,PhoneNumber,PhoneType)',
                ), self::TableOptions());
        $this->addForeignKey('fk_companyphones_createdby', 'company_phones', 'CreatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyphones_updatedby', 'company_phones', 'UpdatedBy', 'users', 'UserID');
        $this->addForeignKey('fk_companyphones_company', 'company_phones', 'CompanyID', 'companies');
    }

    public function safeDown() {
        $this->dropTable('company_phones');
        $this->dropTable('company_emails');
        $this->dropTable('company_contacts');
        $this->dropTable('company_addresses');
        $this->dropTable('companies');
    }

}
