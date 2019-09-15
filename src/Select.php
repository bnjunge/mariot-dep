<?php

namespace SurvTech\Bnjunge\Mariot;

class Select extends Config{

    public function __construct(){
        parent::__construct();
    }

    /**
     * Methods Selects All records in a given schema
     * 
     * @param $schema: String - Schema Name
     * 
     * @access public
     * 
     * @return $results; Array - Fetched results
     * @return null no record was found
     * @return $err String - Error Message during Fetch
     * 
     * @since v1.0.0
     * 
     * @author Benson Njunge <survtechke@gmail.com>
     */
    public function select_all($schema){
        try{
            $selectAllQuery = $this->con->prepare("SELECT * FROM {$schema}");
            $selectAllQuery->execute();
            $results = $selectAllQuery->fetchAll(\PDO::FETCH_ASSOC);

            if($results){
                return ['Code'=> 1, 'MsgClass' => 'success', 'Message' => $results];
            }
            else{
                return ['Code'=> 0, 'MsgClass' => 'success', 'Message' => 'Nothing Found'];
            }
        }catch(\PDOException $e){
            return ['Code'=> $e->getCode(), 'MsgClass' => 'dbError', 'Message' => $e->getMessage()];
        }
    }


    /**
     * Method selects data with Conditon
     * 
     * @param String: $schema
     * @param array: $payload
     * @param string: $query
     * 
     * @access public
     * 
     * @return array: Results of a fetch
     * @return null: no data was found
     * @return string: error string
     * 
     * @author Benson Njunge <survtechke@gmail.com>
     * 
     * @since v1.0.0
     * 
     */

     public function select_all_but($schema, $payload, $query){
        // validate schema
        if(!empty($schema) AND is_string($schema)){
            // validate payload
            if(is_array($payload)){
                if(!empty($query) AND is_string($query)){

                    try{
                        $selectAllButQuery = $this->con->prepare("SELECT * FROM {$schema} {$query}");
                        $selectAllButQuery->execute((array)$payload);
                        $results = $selectAllButQuery->fetchAll(\PDO::FETCH_ASSOC);
                        if($results){
                            return ['Code' => 1, 'MsgClass' => 'success', 'Message' => $results];
                        }
                        else{
                            return ['Code' => 0, 'MsgClass' => 'success', 'Message' => 'Nothing Found'];
                        }
                    }catch(\PDOException $e){
                        return ['Code' => $e->getCode(), 'MsgClass' => 'dbError', 'Message' => $e->getMessage()];
                    }
                }
                else{
                    // query error
                    return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Query String must be provided as a string and passed as the third parameter in the function call.'];
                }
            }
            else{
                // payload error
                return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Payload must be an array and provided as the second parameter in the function call.'];
            }
        }
        else{
            // schema empty
            return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Table name must be provided and passed as the first parameter in the function call.'];
        }
     }


     /**
      * Method to return sum of all records in a given table
      * 
      * @param string: Schema - Table name
      * @param string: Column - Colum to find sum of
      * @param array: (optional) payload - key value pairs for fetching using conditions
      * @param string: (optional) condition mysql conditions
      *
      * @access public
      * 
      * @return array: success message
      * @return array: error message(if any)

      * @author Benson Njunge <survtechke@gmail.com>
      * 
      * @since v1.0.0
      */
     public function select_sum($schema, $column, $payload = [], $condition = ''){
        if(!empty($schema) AND is_string($schema)){
            if(!empty($column) AND is_string($column)){
                try{
                    $sumQuery = "SELECT SUM({$column}) as {$column} FROM {$schema}{$condition}";
                    $getSum = $this->con->prepare($sumQuery);
                    $getSum->execute($payload);

                    $sumResult = $getSum->fetchAll(\PDO::FETCH_ASSOC);

                    if($sumResult){
                        return ['Code' => 1, 'MsgClass' => 'success', 'Message' => $sumResult];
                    }
                    else{
                        return ['Code' => 0, 'MsgClass' => 'success', 'Message' => 0];
                    }
                }
                catch(\PDOException $e){
                    return ['Code' => $e->getCode(), 'MsgClass' => 'dbError', 'Message' => $e->getMessage()];
                }
            }
            else{
                return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Column name must be provided and passed as the Second parameter in the function call.'];
            }
        }
        else{
            return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Table name must be provided and passed as the first parameter in the function call.'];
        }
     }

      /**
      * Method to return sum of all records in a given table
      * 
      * @param $schema string: Schema - Table name
      * @param string: Column - Column to find sum of
      * @param $column2 String - Name of the conditional column
      * @param array: (optional) payload - key value pairs for fetching using conditions
      * @param string: (optional) condition mysql conditions
      *
      * @access public
      * 
      * @return array: success message
      * @return array: error message(if any)

      * @author Benson Njunge <survtechke@gmail.com>
      * 
      * @since v1.0.0
      */
      public function select_conditional_columns($schema, $column1, $column2, $equality, $payload = [], $condition = '', $limiter = ''){
        if(!empty($schema) AND is_string($schema)){
            if(!empty($column1) AND is_string($column1)){
                try{
                    // select * from x where y < w and id = t
                    $sumQuery = "SELECT * FROM {$schema} {$condition} {$column1} {$equality} {$column2} {$limiter}";
                    $getSum = $this->con->prepare($sumQuery);
                    $getSum->execute($payload);

                    $sumResult = $getSum->fetchAll(\PDO::FETCH_ASSOC);

                    if($sumResult){
                        return ['Code' => 1, 'MsgClass' => 'success', 'Message' => $sumResult];
                    }
                    else{
                        return ['Code' => 0, 'MsgClass' => 'success', 'Message' => 0];
                    }
                }
                catch(\PDOException $e){
                    return ['Code' => $e->getCode(), 'MsgClass' => 'dbError', 'Message' => $e->getMessage()];
                }
            }
            else{
                return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Column name must be provided and passed as the Second parameter in the function call.'];
            }
        }
        else{
            return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Table name must be provided and passed as the first parameter in the function call.'];
        }
     }


     /**
      * Method that counts all records in a given table
      * 
      * @param String: schema - Table name
      * @param Array: payload - Key value pairs of an sql condition
      * @param String: condition - sql condition
      *
      * @access public
      * 
      * @return Array: Success Counts and Message
      * @return Array: Error Message if any
      * 
      * @author Benson Njunge <survtechke@gmail.com>
      * @since v1.0.0
      *
      */
      public function select_count($schema, $payload = [], $condition = ''){
        if(!empty($schema) AND is_string($schema)){
                try{
                    $sumQuery = "SELECT count(*) as sum FROM {$schema}{$condition}";
                    $getSum = $this->con->prepare($sumQuery);
                    $getSum->execute($payload);

                    $sumResult = $getSum->fetchAll(\PDO::FETCH_ASSOC);

                    if($sumResult){
                        return ['Code' => 1, 'MsgClass' => 'success', 'Message' => $sumResult];
                    }
                    else{
                        return ['Code' => 0, 'MsgClass' => 'success', 'Message' => 0];
                    }
                }
                catch(\PDOException $e){
                    return ['Code' => $e->getCode(), 'MsgClass' => 'dbError', 'Message' => $e->getMessage()];
                }
        }
        else{
            return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Table name must be provided and passed as the first parameter in the function call.'];
        }
      }
}