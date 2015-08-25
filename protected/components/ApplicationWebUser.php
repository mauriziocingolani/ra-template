<?php

class ApplicationWebUser extends CWebUser {

    public function isDeveloper() {
        return !Yii::app()->user->isGuest && Yii::app()->user->user->RoleID == Role::ROLE_DEVELOPER;
    }

    public function isSupervisor($includeDeveloper = true) {
        return !Yii::app()->user->isGuest && (Yii::app()->user->user->RoleID == Role::ROLE_SUPERVISOR ||
                ($includeDeveloper === true ? $this->isDeveloper() : false));
    }

    public function isOperatore($includeDeveloper = true) {
        return !Yii::app()->user->isGuest && (Yii::app()->user->user->RoleID == Role::ROLE_OPERATORE ||
                ($includeDeveloper === true ? $this->isDeveloper() : false));
    }

}
