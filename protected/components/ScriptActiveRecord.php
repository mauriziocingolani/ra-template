<?php

abstract class ScriptActiveRecord extends AbstractDatabaseObject {

    public $ScriptID;
    public $Created;
    public $CreatedBy;
    public $CampaignID;
    public $CompanyID;

    public function relations() {
        return array(
            'Creator' => array(self::BELONGS_TO, 'User', 'CreatedBy'),
        );
    }

    /** Deve restituire un array con i valori dei campi definiti per lo script. */
    abstract public function getFieldValues();

    /**
     * Deve restituire un array con coppie 'etichetta' => 'valore'  da mostrare nel
     * riassuntivo di profilazione. Normalmente l'etichetta è la label del campo in 
     * questione, mentre il valore è una composizione del valore del campo e degli
     * eventuali valori accessori (es. Testo "Altro..." associato a una scelta multipla che
     * prevede il valore "Altro").
     */
    abstract public function getAnswers();

    /** Deve restituire un array con i nomi dei campi da utilizzare nelle colonne del file xlsx di export. */
    abstract public static function GetFieldNames();

    /**
     * Deve restituire un array con tante stringhe vuote quanti sono gli elementi dell'array
     * restituito dal metodo {@link ScriptActiveRecord::GetFieldNames()}. L'array viene utilizzato
     * come placeholder durante l'export per le aziende che non sono state profilate.
     */
    abstract public static function GetDummyFieldValues();

    public static function FindUnique(ScriptActiveRecord $model, $campaignid, $companyid) {
        return $model->with('Creator')->find(array(
                    'condition' => 'CampaignID=:campaignid AND CompanyID=:companyid',
                    'params' => array(':campaignid' => $campaignid, ':companyid' => $companyid),
        ));
    }

}
