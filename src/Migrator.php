<?php

namespace BNjunge\Cloud\Linode;

class Migrator
{

    /**
     * Set Table Name
     *
     * @param String $string col-name
     * @return this
     */
    public function __construct($string)
    {
        $this->table = $string;
        return $this;
    }

    /**
     * Create Boolean Column
     *
     * @param string $string - Column Name
     * @return this
     */
    public function boolean($string)
    {
        $this->collector[] = ", {$string} boolean";
        return $this;
    }

    /**
     * Create varchar Column
     *
     * @param string $string - Column Name
     * @return $this
     */
    public function string($string, $length = 10)
    {
        $this->collector[] = ", {$string} varchar({$length})";
        return $this;
    }

    /**
     * Create int(11) Column
     *
     * @param string $string - Column Name
     * @return $this
     */
    public function int($string)
    {
        $this->collector[] = ", {$string} int ";
        return $this;
    }

    /**
     * Create tinyint Column
     *
     * @param string $string - Column Name
     * @return $this
     */
    public function tinyInt($string)
    {
        $this->collector[] = ", {$string} tinyint";
        return $this;
    }

    /**
     * Create double Column
     *
     * @param string $string - Column Name
     * @return this
     */
    public function double($string)
    {
        $this->collector[] = ", {$string} double";
        return $this;
    }


    /**
     * Create decimal(20, 6) Column
     *
     * @param string $string - Column Name
     * @param integer $whole
     * @param integer $precision
     * @return this
     */
    public function decimal($string, $whole = 20, $precision = 6)
    {
        $this->collector[] = ", {$string} decimal({$whole}, {$precision})";
        return $this;
    }

    /**
     * Add NOT NULL in column
     *
     * @return $this
     */
    public function notNull()
    {
        $this->collector[] = 'NOT NULL ';
        return $this;
    }

    /**
     * Add DEFAULT NULL in column
     *
     * @return this
     */
    public function allowNull()
    {
        $this->collector[] = 'DEFAULT NULL';
        return $this;
    }

    /**
     * Timestamp Columns
     *
     * @param string $string - column name
     * @param boolean $prop - allow default current timestamp
     * @param boolean $null - allow null
     * @return this
     */
    public function timestamp($string, $prop = false, $null = false)
    {
        $pro = $prop == true ? 'DEFAULT CURRENT_TIMESTAMP' : '';
        $is_null = $null == true ? 'DEFAULT "0000-00-00 00:00"' : "NOT NULL {$pro}";
        $this->collector[] = ", {$string} TIMESTAMP {$is_null}";
        return $this;
    }

    /**
     * Increment columns
     *
     * @return this
     */
    public function increment()
    {
        $this->collector[] = 'AUTO_INCREMENT';
        return $this;
    }

    /**
     * Add Primary Key on column
     *
     * @param string $string - column name
     * @return boolean
     */
    public function isPrimary($string)
    {
        $this->collector[] = ", PRIMARY KEY({$string})";
        return $this;
    }

    public function isUnique($string)
    {
        $this->collector[] = ", UNIQUE({$string})";
        return $this;
    }

    public function default($string){
        $this->collector[] = " DEFAULT '{$string}'";
        return $this;
    }

    /**
     * Add Foreign Key column
     *
     * @param string $string - column name
     * @return boolean
     */
    public function isForeign($string)
    {
        $this->collector[] = ", FOREIGN KEY({$string})";
        return $this;
    }

    /**
     * Add json data type columns
     *
     * @param string $string
     * @return this
     */
    public function json($string)
    {
        $this->collector[] = ", {$string} JSON";
        return $this;
    }

    /**
     * Create Column
     *
     * @return this
     */
    public function create()
    {
        $this->timestamp('date_created', true);
        $this->timestamp('date_updated', true);
        $this->prop = true;

        $tblCols = substr(implode(" ", $this->collector), 1);
        $this->sqlLang = "CREATE TABLE IF NOT EXISTS {$this->table}({$tblCols})";
        return $this;
    }
}