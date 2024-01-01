<?php 
namespace App\Models;
use CodeIgniter\Model;

class StateModel extends Model{
    protected $DBGroup = 'default';
    protected $table = 'tbl_states';
    protected $primaryKey = 'state_id';
    protected $returnType = 'array';
    protected $allowedFields = array('state_id','state_name','country_id');
}

?>