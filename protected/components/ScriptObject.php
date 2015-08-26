<?php

/**
 * @property string $tableName
 * @property string $objectName
 */
class ScriptObject extends CComponent {

    private $_tableName;
    private $_objectName;

    public function __construct($tableName) {
        $this->_tableName = $tableName;
        $this->_createModelName();
    }

    private function _createModelName() {
        $split = preg_split('/[_]/', $this->_tableName);
        $split[0][0] = strtoupper($split[0][0]);
        $split[2][0] = strtoupper($split[2][0]);
        $this->_objectName = join('', $split);
    }

    public function getTableName() {
        return $this->_tableName;
    }

    public function getObjectName() {
        return $this->_objectName;
    }

}
