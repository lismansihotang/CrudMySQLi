<?php
/**
 * Contains code written by the Lisman Tua Sihotang and is strictly used within this program.
 * Any other use of this code is in violation of copy rights.
 *
 * @package   -
 * @author    Lisman Tua Sihotang <lisman.sihotang@gmail.com>
 * @copyright 2016 Invosa Systems Indonesia
 * @license   http://www.invosa.com/license No License
 * @version   GIT: $Id$
 * @link      http://www.invosa.com
 */
/**
 * @define dbHost
 */
define('dbHost', 'localhost');
/**
 * @define dbUser
 */
define('dbUser', 'root');
/**
 * @define dbPass
 */
define('dbPass', '');
/**
 * @define dbName
 */
define('dbName', 'db_code');
if (function_exists('connDb') === false) {
    /**
     * connection into database.
     *
     * @return \mysqli
     */
    function connDb()
    {
        return new mysqli(dbHost, dbUser, dbPass, dbName);
    }
}
if (function_exists('insertData') === false) {
    /**
     * Insert data into table.
     *
     * @param string $tblName
     * @param array  $data
     *
     * @return boolean
     */
    function insertData($tblName = '', array $data = [])
    {
        $field = implode(',', array_keys($data));
        $values = [];
        foreach (array_values($data) as $value) {
            $values[] = '"' . $value . '"';
        }
        $dataValues = implode(', ', $values);
        $strSQL = 'INSERT INTO ' . $tblName . '(' . $field . ') VALUES (' . $dataValues . ') ';
        $conn = connDb();
        return $conn->query($strSQL);
    }
}
if (function_exists('updateData')) {
    /**
     * update data in table.
     *
     * @param string $tblName
     * @param array  $data
     * @param array  $condition
     *
     * @return boolean
     */
    function updateData($tblName = '', array $data = [], array $condition = [])
    {
        # params for update data
        $fieldKeyData = array_keys($data);
        $arrData = [];
        for ($i = 0; $i < count($fieldKeyData); ++$i) {
            $arrData[$i] = $fieldKeyData[$i] . '="' . $data[$fieldKeyData[$i]] . '"';
        }
        $updateData = implode(', ', $arrData);
        # params for condition update data
        $fieldKeyCondition = array_keys($condition);
        $arrCondition = [];
        for ($i = 0; $i < count($fieldKeyCondition); ++$i) {
            $arrCondition[$i] = $fieldKeyCondition[$i] . '="' . $condition[$fieldKeyCondition[$i]] . '"';
        }
        $where = implode(', ', $arrCondition);
        $strSQL = 'UPDATE ' . $tblName . ' SET ' . $updateData . ' WHERE ' . $where . ' ';
        $conn = connDb();
        return $conn->query($strSQL);
    }
}
if (function_exists('deleteData') === false) {
    /**
     * delete data in table.
     *
     * @param string $tblName
     * @param array  $condition
     *
     * @return boolean
     */
    function deleteData($tblName = '', array $condition = [])
    {
        # params for condition update data
        $fieldKeyCondition = array_keys($condition);
        $arrCondition = [];
        for ($i = 0; $i < count($fieldKeyCondition); ++$i) {
            $arrCondition[$i] = $fieldKeyCondition[$i] . '="' . $condition[$fieldKeyCondition[$i]] . '"';
        }
        $where = implode(', ', $arrCondition);
        $strSQL = 'DELETE FROM ' . $tblName . ' WHERE ' . $where . ' ';
        $conn = connDb();
        return $conn->query($strSQL);
    }
}
if (function_exists('getData') === false) {
    /**
     * get data from table.
     *
     * @param string $tblName
     * @param string $field
     * @param array  $condition
     * @param string $result
     *
     * @return array
     */
    function getData($tblName = '', $field = '*', array $condition = [], $result = 'result')
    {
        $strSQL = 'SELECT ' . $field . ' FROM ' . $tblName . ' ';
        if (count($condition) > 0) {
            # params for condition select data
            $fieldKeyCondition = array_keys($condition);
            $arrCondition = [];
            for ($i = 0; $i < count($fieldKeyCondition); ++$i) {
                $arrCondition[$i] = $fieldKeyCondition[$i] . '="' . $condition[$fieldKeyCondition[$i]] . '"';
            }
            $where = implode(', ', $arrCondition);
            $strSQL .= ' WHERE ' . $where . ' ';
        }
        $conn = connDb();
        $records = $conn->query($strSQL);
        $data = [];
        if ($records->num_rows > 0) {
            switch (strtolower($result)) {
                case 'result':
                    $data = $records->fetch_all();
                    break;
                case 'row':
                    $data = $records->fetch_assoc();
                    break;
            }
        }
        return $data;
    }
}
