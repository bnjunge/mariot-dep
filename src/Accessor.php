<?php
namespace SurvTech\Bnjunge\Mariot;


class Accessor{


    public $insert;
    public $update;
    public $delete;
    public $db;

    /**
     * Access all select methods of Mariot
     * @uses mariot
     */
    public $select;
    public $mpesa;

    public function __construct()
    {
        $this->db = new Config;
        $this->insert = new Insert;
        $this->update = new Update;
        $this->delete = new Delete;
        $this->select = new Select;
    }
}
