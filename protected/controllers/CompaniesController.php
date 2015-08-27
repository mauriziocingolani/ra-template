<?php

class CompaniesController extends TemplateController {

    public function accessRules() {
        return array(
            array('allow',
                'users' => array('@')),
            array('deny'),
        );
    }

    public function actionIndex() {
        $model = new Company('search');
        $city = new CompanyAddress('search');
        $phone = new CompanyPhone('search');
        $email = new CompanyEmail('search');
        $model->unsetAttributes();
        $city->unsetAttributes();
        $phone->unsetAttributes();
        $email->unsetAttributes();
        if (isset($_GET['Company']))
            $model->attributes = $_GET['Company'];
        if (isset($_GET['CompanyAddress']))
            $city->attributes = $_GET['CompanyAddress'];
        if (isset($_GET['CompanyPhone']))
            $phone->attributes = $_GET['CompanyPhone'];
        if (isset($_GET['CompanyEmail']))
            $email->attributes = $_GET['CompanyEmail'];
        $model->searchCity = $city;
        $model->searchPhone = $phone;
        $model->searchEmail = $email;
        $this->render('index', array(
            'model' => $model,
        ));
    }

    public function actionCompany($companyid = null) {
        $model = (int) $companyid > 0 ? $this->_readCompany($companyid) : new Company;
        if (Yii::app()->request->isPostRequest) :
            if (isset($_POST['Company'])) :
                $model->setAttributes($_POST['Company']);
                try {
                    if ($model->save()) :
                        Yii::app()->user->setFlash('success', 'Azienda ' . ($companyid ? 'modificata' : 'creata') . '!');
                        if ($companyid) :
                            $this->refresh();
                        else :
                            $this->redirect('/azienda/' . Yii::app()->db->lastInsertID);
                        endif;
                    endif;
                } catch (CDbException $e) {
                    Yii::app()->user->setFlash('error'
                            , $e->errorInfo[1] == 1062 ? 'Violazione vincolo di unicità: una ditta con questa ragione sociale esiste già.' : $e->getMessage());
                }
            # eliminazione indirizzo
            elseif (isset($_POST['CompanyAddress'])) :
                try {
                    CompanyAddress::model()->deleteByPk($_POST['CompanyAddress']['Delete']);
                    $model = Company::model()->with('Creator', 'Updater', 'Emails')->findByPk($companyid); # ricarico il modello
                    Yii::app()->user->setFlash('success', 'Indirizzo eliminato!');
                } catch (CDbException $e) {
                    Yii::app()->user->setFlash('error', 'Impossibile eliminare l\'indirizzo. Il server riporta:<p>' . $e->getMessage() . '</p>');
                }
            # eliminazione contatto
            elseif (isset($_POST['CompanyContact'])) :
                try {
                    CompanyContact::model()->deleteByPk($_POST['CompanyContact']['Delete']);
                    $model = Company::model()->with('Creator', 'Updater', 'Emails')->findByPk($companyid); # ricarico il modello
                    Yii::app()->user->setFlash('success', 'Contatto eliminato!');
                } catch (CDbException $e) {
                    Yii::app()->user->setFlash('error', 'Impossibile eliminare il contatto. Il server riporta:<p>' . $e->getMessage() . '</p>');
                }
            #eliminazione telefono
            elseif (isset($_POST['CompanyPhone'])) :
                try {
                    CompanyPhone::model()->deleteByPk($_POST['CompanyPhone']['Delete']);
                    $model = Company::model()->with('Creator', 'Updater', 'Emails')->findByPk($companyid); # ricarico il modello
                    Yii::app()->user->setFlash('success', 'Telefono eliminato!');
                } catch (CDbException $e) {
                    Yii::app()->user->setFlash('error', 'Impossibile eliminare il telefono. Il server riporta:<p>' . $e->getMessage() . '</p>');
                }
            # eliminazione email
            elseif (isset($_POST['CompanyEmail'])) :
                try {
                    CompanyEmail::model()->deleteByPk($_POST['CompanyEmail']['Delete']);
                    $model = Company::model()->with('Creator', 'Updater', 'Emails')->findByPk($companyid); # ricarico il modello
                    Yii::app()->user->setFlash('success', 'Indirizzo email eliminato!');
                } catch (CDbException $e) {
                    Yii::app()->user->setFlash('error', 'Impossibile eliminare l\'indirizzo email. Il server riporta:<p>' . $e->getMessage() . '</p>');
                }
            endif;
        endif;
        $this->render('company', array(
            'model' => $model,
        ));
    }

    public function actionCompanyAddress($companyid, $addressid = null) {
        $company = $this->_readCompany($companyid);
        if ((int) $addressid > 0) :
            $model = CompanyAddress::model()->findByPk($addressid);
            if ($model == null) :
                throw new InvalidDatabaseObjectException('L\'indirizzo');
            endif;
        else :
            $model = new CompanyAddress;
        endif;
        if (Yii::app()->request->isPostRequest) :
            $model->setAttributes($_POST['CompanyAddress']);
            $model->CompanyID = $company->CompanyID;
            try {
                if ($model->save()) :
                    Yii::app()->user->setFlash('success', 'Indirizzo ' . ($addressid ? 'modificato!' : 'creato!'));
                    if ($addressid) :
                        $this->refresh();
                    else :
                        $this->redirect('/azienda/' . $companyid . '/indirizzo/' . Yii::app()->db->lastInsertID);
                    endif;
                endif;
            } catch (CDbException $e) {
                Yii::app()->user->setFlash('error', $e->errorInfo[1] == 1062 ? 'Violazione vincolo di unicità: questo indirizzo esiste già per questa ditta.' : $e->getMessage());
            }
        endif;
        $this->render('address', array(
            'company' => $company,
            'model' => $model,
            'province' => Provincia::model()->findAll(array('order' => 'Provincia')),
            'regioni' => Regione::model()->findAll(array('order' => 'Regione')),
            'nazioni' => Nazione::model()->findAll(array('order' => 'NazioneIt')),
        ));
    }

    public function actionCompanyContact($companyid, $contactid = null) {
        $company = $this->_readCompany($companyid);
        if ((int) $contactid > 0) :
            $model = CompanyContact::model()->findByPk($contactid);
            if ($model == null) :
                throw new InvalidDatabaseObjectException('Il contatto');
            endif;
        else :
            $model = new CompanyContact;
        endif;
        if (Yii::app()->request->isPostRequest) :
            $model->setAttributes($_POST['CompanyContact']);
            $model->CompanyID = $company->CompanyID;
            try {
                if ($model->save()) :
                    Yii::app()->user->setFlash('success', 'Contatto ' . ($contactid ? 'modificato!' : 'creato!'));
                    if ($contactid) :
                        $this->refresh();
                    else :
                        $this->redirect('/azienda/' . $companyid . '/contatto/' . Yii::app()->db->lastInsertID);
                    endif;
                endif;
            } catch (CDbException $e) {
                Yii::app()->user->setFlash('error', $e->errorInfo[1] == 1062 ? 'Violazione vincolo di unicità: questo contatto esiste già per questa ditta.' : $e->getMessage());
            }
        endif;
        $this->render('contact', array(
            'company' => $company,
            'model' => $model,
        ));
    }

    public function actionCompanyPhone($companyid, $phoneid = null) {
        $company = $this->_readCompany($companyid);
        if ((int) $phoneid > 0) :
            $model = CompanyPhone::model()->findByPk($phoneid);
            if ($model == null) :
                throw new InvalidDatabaseObjectException('Il numero di telefono');
            endif;
        else :
            $model = new CompanyPhone;
        endif;
        if (Yii::app()->request->isPostRequest) :
            $model->setAttributes($_POST['CompanyPhone']);
            $model->CompanyID = $company->CompanyID;
            try {
                if ($model->save()) :
                    Yii::app()->user->setFlash('success', 'Telefono ' . ($phoneid ? 'modificato!' : 'creato!'));
                    if (!$phoneid) :
                        $this->refresh();
                    else :
                        $this->redirect('/azienda/' . $companyid . '/telefono/' . Yii::app()->db->lastInsertID);
                    endif;
                endif;
            } catch (CDbException $e) {
                Yii::app()->user->setFlash('error', $e->errorInfo[1] == 1062 ? 'Violazione vincolo di unicità: questo telefono esiste già per questa ditta.' : $e->getMessage());
            }
        endif;
        $this->render('phone', array(
            'company' => $company,
            'model' => $model,
        ));
    }

    public function actionCompanyEmail($companyid, $emailid = null) {
        $company = $this->_readCompany($companyid);
        if ((int) $emailid > 0) :
            $model = CompanyEmail::model()->findByPk($emailid);
            if ($model == null) :
                throw new InvalidDatabaseObjectException('L\'indirizzo email');
            endif;
        else :
            $model = new CompanyEmail;
        endif;
        if (Yii::app()->request->isPostRequest) :
            $model->setAttributes($_POST['CompanyEmail']);
            $model->CompanyID = $company->CompanyID;
            try {
                if ($model->save()) :
                    Yii::app()->user->setFlash('success', 'Indirizzo email ' . ($emailid ? 'modificato!' : 'creato!'));
                    if (!$emailid) :
                        $this->refresh();
                    else :
                        $this->redirect('/azienda/' . $companyid . '/email/' . Yii::app()->db->lastInsertID);
                    endif;
                endif;
            } catch (CDbException $e) {
                Yii::app()->user->setFlash('error', $e->errorInfo[1] == 1062 ? 'Violazione vincolo di unicità: questo indirizzo email esiste già per questa ditta.' : $e->getMessage());
            }
        endif;
        $this->render('email', array(
            'company' => $company,
            'model' => $model,
        ));
    }

    public function actionDelete($id) {
        $model = Company::model()->findByPk($id);
        try {
            $model->delete();
        } catch (CDbException $e) {
            if ($e->errorInfo[1] == 1451)
                echo "<div class='flash-error'>L'azienda <strong>" . CHtml::encode($model->CompanyName) .
                "</strong> &egrave; gi&agrave; stata lavorata e non pu&ograve; essere eliminata.</div>";
        }
        if (!isset($_GET['ajax']))
            $this->redirect(isset($_POST['returnUrl']) ? $_POST['returnUrl'] : array('admin'));
    }

    public function actionProfile($companyid, $campaignid = null) {
        $model = Company::model()->with('Activities', 'Campaigns', 'Contacts')->findByPk($companyid);
        if ($model == null) :
            throw new InvalidDatabaseObjectException('L\'azienda', true);
        endif;
        # gestione campagna
        $campaigns = $model->ActiveCampaigns; # tutte le campagne ATTIVE alla quale è associata l'azienda
        if (count($campaigns) > 0) :
            if (!$campaignid) : # nessuna campagna impostata
                if (isset(Yii::app()->session['lastCampaign'][$companyid])) : # campaignid in memoria
                    return $this->redirect("/azienda/$companyid/profilazione/" . Yii::app()->session['lastCampaign'][$companyid]);
                else :
                    Yii::app()->session['lastCampaign'] = array($companyid => $campaigns[0]->CampaignID);
                    return $this->redirect("/azienda/$companyid/profilazione/{$campaigns[0]->CampaignID}");
                endif;
            else : # campagna impostata
                Yii::app()->session['lastCampaign'] = array($companyid => $campaignid);
            endif;
        endif;
        # parametri
        $pin = '';
        $campaign = null;
        if ($campaignid) :
            # trovo la campagna (è per forzo tra $campaigns!) e passo il nome alla view
            foreach ($campaigns as $camp) :
                if ($camp->CampaignID == $campaignid) :
                    $campaign = Campaign::model()->findByPk($campaignid)->Name;
                    break;
                endif;
            endforeach;
        endif;
        $activity = new Activity;
        # POST
        if (Yii::app()->request->isPostRequest) :
            # salvataggio attività
            if (isset($_POST['Activity'])) :
                $activity->setAttributes($_POST['Activity']);
                $activity->setAttribute('CompanyID', $model->CompanyID);
                try {
                    if ($activity->save()) :
                        $model = Company::model()->with('Activities')->findByPk($companyid); # ricarico il modello per aggiornare la lista delle attività
                        Yii::app()->user->setFlash('activity_success', 'Attività registrata!');
                    endif;
                } catch (CDbException $e) {
                    Yii::app()->user->setFlash('activity_error', $e->getMessage());
                }
            # eliminazione attività
            elseif (isset($_POST['DeleteActivity'])) :
                try {
                    Activity::model()->deleteByPk($_POST['DeleteActivity']['ActivityID']);
                    Yii::app()->user->setFlash('activity_success', 'Attivit&agrave; eliminata!');
                    $this->refresh();
                } catch (CDbException $e) {
                    Yii::app()->user->setFlash('activity_error', 'Impossibile eliminare l\'attivit&agrave;: ' . $e->getMessage());
                }
            endif;
        endif;
        #
        $this->render('profile', array(
            'model' => $model,
            'campaigns' => $campaigns,
            'campaignid' => $campaignid,
            'campaign' => $campaign,
            'pin' => $pin,
            'activity' => $activity,
        ));
    }

    private function _readCompany($companyid) {
        $company = Company::model()->findByPk($companyid);
        if ($company == null) :
            throw new InvalidDatabaseObjectException('L\'azienda', true);
        endif;
        return $company;
    }

}
