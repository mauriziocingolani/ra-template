<?php

class ApplicationWebUser extends CWebUser {

    const ROLE_DEVELOPER = 1;
    const ROLE_SUPERVISOR = 2;
    const ROLE_OPERATORE = 3;

    public function isDeveloper() {
        return !Yii::app()->user->isGuest && Yii::app()->user->user->RoleID == self::ROLE_DEVELOPER;
    }

    public function isSupervisor($includeDeveloper = true) {
        return !Yii::app()->user->isGuest && (Yii::app()->user->user->RoleID == self::ROLE_SUPERVISOR ||
                ($includeDeveloper === true ? $this->isDeveloper() : false));
    }

    public function isOperatore($includeDeveloper = true) {
        return !Yii::app()->user->isGuest && (Yii::app()->user->user->RoleID == self::ROLE_OPERATORE ||
                ($includeDeveloper === true ? $this->isDeveloper() : false));
    }

}
