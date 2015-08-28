<?php

class ReportsCampaignsForm extends CFormModel {

    public $campaignid;
    public $startdate;
    public $enddate;

    public function attributeLabels() {
        return array(
            'campaignid' => 'Campagna',
            'startdate' => 'Data di inizio',
            'enddate' => 'Data di fine',
        );
    }

    public function rules() {
        return array(
            array('campaignid, startdate', 'safe'),
            array('enddate', 'compare', 'compareAttribute' => 'startdate', 'operator' => '>', 'allowEmpty' => true, 'message' => 'La data di fine deve essere successiva a quella di inizio'),
        );
    }

}
