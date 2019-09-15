<?php
namespace SurvTech\Bnjunge\Mariot;

class Insert extends Config {
    public function __construct(){
        parent::__construct();
    }

    /**
     * This method inserts data to database
     * 
     * @param $schema: string - Table to insert
     * @param $payload: Array - An associative array of schema composed of $key => $value
     * 
     * @access public
     * @return array: insert success or fail with description and error code
     * 
     * @author Ben Njunge
     * 
     * @since 1.0.0 
     */

    public function insert_db($schema, $payload){
        // check integrity, array only
        if(is_array($payload)){
            // split payload
            $assocKeys = array();
            $schemaValues = array();
            $bindParams = array();

            foreach($payload as $key => $value){
                $assocKeys[] = $key;
                $bindParams[] = ':'.$key;
                $schemaValues[':'.$key] = $value;
            }

            // form it
            $schemaKeys = implode(',', $assocKeys);
            $bindParams = implode(',', $bindParams);
            $formerStatement = "INSERT INTO {$schema}({$schemaKeys}) VALUES({$bindParams})";

            try{
                $insertQuery = $this->con->prepare($formerStatement);
                $insertQuery->execute((array)$schemaValues);
                $insertedRows = $insertQuery->rowCount();
                return ['Code'=> 1, 'MsgClass' => 'success', 'Rows' => $insertedRows, 'Message' => $insertedRows.' Row(s) inserted Successfully.', 'InsertID' => $this->con->lastInsertId(), 'Data' => $payload ];
            }
            catch(\PDOException $e){
                return ['Code'=> $e->getCode(),  'MsgClass' => 'dbError', 'Message' => $e->getMessage()];
            }
        }
        else{
            // error, payload must be array
            return ['Code'=> 0,  'MsgClass' => 'Error','Message' => 'Payload Must be an array'];
        }
    }
}