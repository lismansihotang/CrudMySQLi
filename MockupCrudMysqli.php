<?php
include_once 'CrudMysqliHelper.php';
# Begin Insert Data. data formated into array.
# example : $data = [$field => $value];
$data = ['fieldData1' => 'valueData1', 'fieldData2' => 'valueData2'];
$where = ['fieldKey' => 'value'];
# insert data
insertData('test', $data);
# update data
updateData('test', $data, $where);
# delete data
deleteData('test', $where);
# get data from table, row for single data and result for all data
getData('test', '*', [], 'row');