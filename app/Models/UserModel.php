<?php 
namespace App\Models;
use CodeIgniter\Model;

class UserModel extends Model{
    protected $DBGroup = 'default';
    protected $table = 'tbl_users';
    protected $primaryKey = 'user_id';
    protected $returnType = 'array';
    protected $allowedFields = array('first_name','last_name','state_id','city_id','username','password','status');
}

?>