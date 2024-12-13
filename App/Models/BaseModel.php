<?php
namespace App\Models;

use PDO;

class BaseModel
{
    protected $db;
    public function __construct(PDO $db)
    {
        $this->db = $db;
    }
}