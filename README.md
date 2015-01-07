# Yii1 Oracle NextVal AutoIncrement Behavior
As you know folks, oracle sucks with php and yii in particular.
@See one of the headache.
http://www.yiiframework.com/forum/index.php/topic/6657-sequencename-and-oracle/
http://stackoverflow.com/questions/9328980/why-doesnt-pdos-oracle-driver-implement-lastinsertid

Usage
--------------------------
```php
public function behaviors() {
  return [
    'OracleNextValBehavior' => [
      'class' => 'application.components.OracleNextValBehavior',
      'sequence' => GedHelper::getFullTableName('SEQ_GED_USER')
    ]
];
}
```
