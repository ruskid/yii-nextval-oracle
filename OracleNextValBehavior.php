<?php

/**
 * @copyright Copyright Victor Demin, 2015
 * @license https://github.com/ruskid/yii-nextval-oracle-behavior/LICENSE
 * @link https://github.com/ruskid/yii-nextval-oracle-behavior#readme
 */

/**
 * OracleNextValBehavior.
 * This behavior will autoincrement the ActiveRecord primary key before saving. (insert)
 * @author Victor Demin <demmbox@gmail.com>
 */
class OracleNextValBehavior extends CActiveRecordBehavior {

    /**
     * Database sequence name
     * @var string
     */
    public $sequence;

    /**
     * Responds to {@link CModel::onBeforeSave} event.
     * Sets the values of the creation or modified attributes as configured
     * @param CModelEvent $event event parameter
     */
    public function beforeSave($event) {
        $this->onInit();

        $AR = $this->getOwner();
        if ($AR->getIsNewRecord()) {
            $AR->{$AR->tableSchema->primaryKey} = $this->getNextVal();
        }
    }

    /**
     * Will return nextval from the table of the ActiveRecord
     * @return integer
     */
    public function getNextVal() {
        $connection = Yii::app()->db;
        $command = $connection->createCommand("SELECT $this->sequence.nextval from dual");
        return $command->queryScalar();
    }

    /**
     * Quick fix! If your active record has CLOB attribute then you will get this error.
     * "General error: 24816 OCIStmtExecute: ORA-24816: Expanded non LONG bind data supplied after actual LONG or LOB column"
     * Another oracle and pdo_oci stuff... To solve the problem you should bind your clob parameters at the end of bind list.
     * So the purpose of afterConstruct method is to set the primary key to some value (1) and rewrite it in after maintaining the bind order.
     *  
     * Responds to {@link CModel::onAfterConstruct} event.
     * Override this method and make it public if you want to handle the corresponding event
     * of the {@link CBehavior::owner owner}.
     * @param CEvent $event event parameter
     */
    public function afterConstruct($event) {
        $AR = $this->getOwner();
        if ($AR->getIsNewRecord()) {
            $AR->{$AR->tableSchema->primaryKey} = 1;
        }
    }

    /**
     * Validation, the sequence must be specified
     * @throws Exception
     */
    public function onInit() {
        if (!$this->sequence) {
            throw new Exception("Please provide the sequence name for the " . $this->getOwner()->tableName());
        }
    }

}
