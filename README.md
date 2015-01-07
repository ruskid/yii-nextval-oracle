# Yii1 Oracle AutoIncrement Behavior
As you know folks, oracle sucks with php and yii in particular.
@See one of the headache.
<p>http://www.yiiframework.com/forum/index.php/topic/6657-sequencename-and-oracle/</p>
<p>http://stackoverflow.com/questions/9328980/why-doesnt-pdos-oracle-driver-implement-lastinsertid</p>

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
