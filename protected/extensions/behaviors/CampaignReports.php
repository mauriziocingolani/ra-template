<?php

class CampaignReports extends CActiveRecordBehavior {

    public function createXlsxReport(Campaign $campaign, $startdate, $enddate) {
        try {
            $modelName = $campaign->profileModel;
            # init excel
            $objPHPExcel = new PHPExcel;
            $sheet = $objPHPExcel->getActiveSheet();
            $sheet->setTitle($campaign->Name);
            #conteggio il numero di colonne che mi serviranno per indirizzi e contatti
            $maxAddresses = 0;
            $maxContacts = 0;
            foreach ($campaign->CampaignCompanies as $company) :
                $maxAddresses = max($maxAddresses, count($company->Addresses));
                $maxContacts = max($maxContacts, count($company->Contacts));
            endforeach;
            # HEADER
            $headers = array_merge(Company::GetFieldsLabelsForXlsx(), array('Telefoni', 'Email'));
            for ($i = 1; $i <= $maxContacts; $i++) :
                $headers = array_merge($headers, array("Nome $i", "Cognome $i", "Ruolo $i", "Telefono $i", "Email $i", "Note $i"));
            endfor;
            for ($i = 1; $i <= $maxAddresses; $i++) :
                $headers = array_merge($headers, array("Tipo indirizzo $i", "Indirizzo $i", "Comune $i", "CAP $i", "Provincia $i", "Regione $i", "Nazione $i"));
            endfor;
            $headers = array_merge($headers, $modelName::GetFieldNames());
            $headers = array_merge($headers, array('Esito', 'Data chiusura', 'Operatore', 'Note'));
            $row = 1;
            $column = 0;
            foreach ($headers as $h) :
                $sheet->setCellValueByColumnAndRow($column++, $row, $h);
            endforeach;
            $row = 2;
            foreach ($campaign->CampaignCompanies as $company) :
                $activities = $company->getAllActivities($campaign->CampaignID);
                if (count($activities) > 0) :
                    $activities = $activities[$campaign->CampaignID]['activities'];
                endif;
                if ($startdate || $enddate) : # filtro per data
                    if (count($activities) > 0) :
                        $date = strtotime(date('Y-m-d', strtotime($activities[0]->Created)));
                        if ($startdate && strtotime($startdate) > $date)
                            continue;
                        if ($enddate && strtotime($enddate) < $date)
                            continue;
                    endif;
                endif;
                # info
                $column = 0;
                foreach ($company->getFieldsValuesForXlsx() as $value) :
                    $sheet->setCellValueByColumnAndRow($column++, $row, $value);
                endforeach;
                # telefoni
                $phones = array();
                foreach ($company->Phones as $phone) :
                    $phones[] = "$phone->PhoneNumber ($phone->PhoneType)";
                endforeach;
                $sheet->setCellValueByColumnAndRow($column++, $row, join(', ', $phones));
                # emails
                $emails = array();
                foreach ($company->Emails as $email) :
                    $emails[] = $email->Address;
                endforeach;
                $sheet->setCellValueByColumnAndRow($column++, $row, join(', ', $emails));
                # contatti
                for ($i = 0; $i < $maxContacts; $i++) :
                    if (($i + 1) <= count($company->Contacts)) :
                        $contact = $company->Contacts[$i];
                        $sheet->setCellValueByColumnAndRow($column++, $row, $contact->FirstName);
                        $sheet->setCellValueByColumnAndRow($column++, $row, $contact->LastName);
                        $sheet->setCellValueByColumnAndRow($column++, $row, $contact->Role);
                        $sheet->setCellValueByColumnAndRow($column++, $row, $contact->Phone);
                        $sheet->setCellValueByColumnAndRow($column++, $row, $contact->Email);
                        $sheet->setCellValueByColumnAndRow($column++, $row, $contact->Notes);
                    else :
                        $column+=6;
                    endif;
                endfor;
                #indirizzi
                for ($i = 0; $i < $maxAddresses; $i++) :
                    if (($i + 1) <= count($company->Addresses)) :
                        $address = $company->Addresses[$i];
                        $sheet->setCellValueByColumnAndRow($column++, $row, $address->AddressType);
                        $sheet->setCellValueByColumnAndRow($column++, $row, $address->Address);
                        $sheet->setCellValueByColumnAndRow($column++, $row, $address->City);
                        $sheet->setCellValueByColumnAndRow($column++, $row, $address->ZipCode);
                        $sheet->setCellValueByColumnAndRow($column++, $row, $address->ProvinciaID ? $address->Provincia->Sigla : null);
                        if ($address->RegioneID) :
                            $sheet->setCellValueByColumnAndRow($column++, $row, $address->Regione->Regione);
                        else :
                            $sheet->setCellValueByColumnAndRow($column++, $row, $address->ProvinciaID ? $address->Provincia->Regione->Regione : null);
                        endif;
                        $sheet->setCellValueByColumnAndRow($column++, $row, $address->Nazione->NazioneIt);
                    else :
                        $column+=7;
                    endif;
                endfor;
                # profilazione
                $modelName = $campaign->profileModel;
                $profModel = $modelName::FindUnique($modelName::model(), $campaign->CampaignID, $company->CompanyID);
                if ($profModel) :
                    foreach ($profModel->getFieldValues() as $value) :
                        $sheet->setCellValueByColumnAndRow($column++, $row, $value);
                    endforeach;
                else :
                    foreach ($modelName::getDummyFieldValues() as $value) :
                        $sheet->setCellValueByColumnAndRow($column++, $row, $value);
                    endforeach;
                endif;
                #attività
                if (count($activities) > 0) :
                    for ($i = 0, $n = count($activities); $i < $n; $i++) :
                        $activity = $activities[$i];
                        if ($i == 0) :
                            $sheet->setCellValueByColumnAndRow($column++, $row, $activity->ActivityType->Description);
                            $sheet->setCellValueByColumnAndRow($column++, $row, date('d/m/Y', strtotime($activity->Created)));
                            $sheet->setCellValueByColumnAndRow($column++, $row, $activity->Creator->UserName);
                            $sheet->setCellValueByColumnAndRow($column++, $row, $activity->Notes);
                        else :
                            $sheet->setCellValueByColumnAndRow($column++, $row, $activity->Notes);
                        endif;
                    endfor;
                endif;
                $row++;
            endforeach;
            // Generazione xlsx
            $objWriter = new PHPExcel_Writer_Excel2007($objPHPExcel);
            $objWriter->save(Yii::app()->basePath . "/../files/reports/report_campagna.xlsx");
            return true;
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

}
