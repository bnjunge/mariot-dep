<?php

namespace SurvTech\Bnjunge\Mariot;

class Delete extends Config{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * Method deletes on condition
     * 
     * @param string: schema
     * @param array: payload
     * @param string: condition
     * 
     * @access public
     * 
     * @return array: success delete
     * @return array: error during delete
     * 
     * @author Benson Njunge <survtechke@gmail.com
     * 
     * @since v1.0.0 | @year 2019 April
     */
    public function Delete($schema, $payload, $condition){
        // check integrity
        if(!empty($schema) AND is_string($schema)){
            if(!empty($condition) AND is_string($condition)){
                if(is_array($payload) AND !empty($payload)){
                    try{
                        // DELETE * FROM schema where xn = :xn
                        $payloaded = array();
                        $removeCondition = array();

                        foreach( $payload as $key => $value ){
                            $payloaded[':'.$key] = $value;
                            $removeCondition[] = $key . ' = :' . $key;
                        }
                        
                        $more_conditions = count($payload);
                        
                        if($more_conditions > 1){
                            $removeCondition = implode( ' OR ', $removeCondition );
                        }
                        else{
                            $removeCondition = implode( ',', $removeCondition );
                        }
                        $deleteQuery = $this->con->prepare("DELETE FROM {$schema} {$condition} {$removeCondition}");
                        $deleteQuery->execute((array)$payloaded);
                        $deletedRows = $deleteQuery->rowCount();

                        return ['Code' => 1, 'MsgClass' => 'Error', 'Message' => $deletedRows . ' Rows Deleted Successfully'];
                    }catch(\PDOException $e){
                        return ['Code' => $e->getCode(), 'MsgClass' => 'dbError', 'Message' => $e->getMessage()];
                    }
                }
                else{
                    return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Payload must be an array and provided as the second parameter in the function call.'];
                }
            }
            else{
                return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Condition must be provided as a string and the third parameter in the function call.'];
            }
        }
        else{
            return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Table name must be provided and passed as the first parameter in the function call.'];
        }
    }
}