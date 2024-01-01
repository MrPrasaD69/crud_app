<?php 
namespace App\Models;
use CodeIgniter\Model;

class CityModel extends Model{
    protected $DBGroup = 'default';
    protected $table = 'tbl_cities';
    protected $primaryKey = 'city_id';
    protected $returnType = 'array';
    protected $allowedFields = array('city_id','city_name','state_id');
}

?>