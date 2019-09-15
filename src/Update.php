<?php
namespace SurvTech\Bnjunge\Mariot;

class Update extends Config{
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * 
     * Method Updates values in a given Schema
     * 
     * @param string: Schema
     * @param array: update value key pairs
     * @param string: condition for update
     * 
     * @access public
     * 
     * @return array: update success
     * @return array: update error
     * 
     * @author Benson Njunge <survtechke@gmail.com>
     * 
     * @since v1.0.0
     * 
     */
    public function update($schema, $payload, $condition = ''){
        // check integrity
        if(!empty($schema) AND is_string($schema)) {
            if(!empty($payload) AND is_array($payload)){
                
                $provide = array();
                $keySets = array();
                foreach($payload as $key => $value){
                    $keySets[] = $key . ' = :' . $key;
                    $provide[ ':'.$key ] = $value;
                }
                $keys = implode(',', $keySets);

                try{
                    $updateQuery = $this->con->prepare("UPDATE {$schema} SET {$keys} {$condition}");
                    $updateQuery->execute((array)$provide);
                    return ['Code' => 1, 'MsgClass' => 'success', 'Message' => $updateQuery->rowCount() . ' Rows updated.', 'Data' => $payload];
                }catch(\PDOException $e){
                    return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => $e->getMessage()];
                }
            }
            else{
                // payload error
                return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Payload must be an array and provided as the second parameter in the function call.'];
            }
        }
        else{
            // schema error
            return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Table name must be provided and passed as the first parameter in the function call.'];
        }
    }

      /**
     * 
     * Method Updates Counter value in a given Schema
     * 
     * @param string: Schema
     * @param array: payload  of where condition key value pairs
     * @param string: condition for update
     * 
     * @access public
     * 
     * @return array: update success
     * @return array: update error
     * 
     * @author Benson Njunge <survtechke@gmail.com>
     * 
     * @since v1.0.1a
     * 
     */

    public function update_counter($schema, $payload, $item, $increment, $condition){
             // check integrity
        if(!empty($schema) AND is_string($schema)) {
            if(!empty($payload) AND !empty($item) AND !empty($increment)){                
                try{
                    $updateQuery = $this->con->prepare("UPDATE {$schema} SET {$item} = {$item} + $increment {$condition}");
                    $updateQuery->execute((array)$payload);
                    return ['Code' => 1, 'MsgClass' => 'success', 'Message' => $updateQuery->rowCount() . ' Rows updated.', 'Data' => $payload];
                }catch(\PDOException $e){
                    return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => $e->getMessage()];
                }
            }
            else{
                // payload error
                return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Payload must be an array and provided as the second parameter in the function call.'];
            }
        }
        else{
            // schema error
            return ['Code' => 0, 'MsgClass' => 'Error', 'Message' => 'Table name must be provided and passed as the first parameter in the function call.'];
        }
    }
}