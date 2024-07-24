<?php 
namespace App\Controllers;

use App\Models\CityModel;
use App\Models\UserModel;

class User extends BaseController{
    public function list(){
        $model_user = new UserModel;

        $user_data = $model_user->where('status = "1" ')->orderBy('user_id','DESC')->findAll();
        return view('user/list',array('user_data'=>$user_data));
    }

    public function add(){
        $model_city = new CityModel;
        $data['state_data'] = $this->getStateData();
        $data['city_data'] = $model_city->findAll();
        // echo "<pre>";
        // print_r($data);
        // exit;
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $model_user = new UserModel;
        $data['user_data'] = $model_user->where('user_id = "'.$id.'" ')->first();
        return view('user/add', $data);
    }

    public function manageData(){
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $first_name = !empty($_REQUEST['first_name']) ? $_REQUEST['first_name'] : '';
        $state =!empty($_REQUEST['state_name']) ? $_REQUEST['state_name'] : '';
        $city=!empty($_REQUEST['city_name']) ? $_REQUEST['city_name'] : '';
        $last_name = !empty($_REQUEST['last_name']) ? $_REQUEST['last_name'] : '';
        $username = !empty($_REQUEST['username']) ? $_REQUEST['username'] : '';
        $password = !empty($_REQUEST['password']) ? $_REQUEST['password'] : '';
        $model_user = new UserModel;
        $data = array();

        if(!empty($id)){
            $user_data = $model_user->where('user_id = "'.$id.'" ')->first();
            if(!empty($user_data)){
                if(!empty($first_name) && !empty($last_name) && !empty($username)){
                    $data['first_name'] = $first_name;
                    $data['last_name'] = $last_name;
                    $data['state_id'] = $state;
                    $data['city_id'] = $city;
                    $data['username'] = $username;
                    $model_user->update($user_data['user_id'],$data);
                    echo "200::Data Updated Successfully!";
                }
                else{
                    echo"400::Input fields cannot be empty!";
                }
            }
            else{
                echo"404::User Data not Found";
            }
            
        }
        else{
            if(!empty($first_name) && !empty($last_name) && !empty($username) && !empty($password)){
                $data['first_name'] = $first_name;
                $data['last_name'] = $last_name;
                $data['state_id'] = $state;
                $data['city_id'] = $city;
                $data['username'] = $username;
                $data['password'] = md5($username."|".$password);
                $model_user->save($data);
                echo "200::Data Saved Successfully!";
            }
            else{
                echo"400::Input fields cannot be empty!";
            }
            
        }        

    }

    public function getCityData(){
        $model_city = new CityModel;
        $user_city_id = !empty($_REQUEST['user_city_id']) ? $_REQUEST['user_city_id'] : '';
        $html ='<option value="">Select City</option>';
        $state_id = !empty($_REQUEST['state_id']) ? $_REQUEST['state_id'] : '';
        $city_data = $model_city->where('state_id="'.$state_id.'" ')->findAll();
        if(!empty($city_data)){
            foreach($city_data as $city){                
                $selected= $user_city_id==$city['city_id'] ? 'selected' : '';
                $html .='<option '.$selected.'  value="'.$city['city_id'].'"  >'.$city['city_name'].'</option>';
            }
            echo "200::".$html;
            exit;
        }
    }

    public function delete(){
        $model_user = new UserModel;
        $id = !empty($_REQUEST['id']) ? $_REQUEST['id'] : '';
        $user_data = $model_user->where('user_id="'.$id.'" AND status="1" ')->first();
        $data=array();
        if(!empty($user_data)){
            $data['status']="0";
            $model_user->update($user_data['user_id'],$data);
            echo "200::User Deleted Successfully!";
        }
        else{
            echo "404::User Data Not Found!";
        }
    }

    public function readExcel(){
        $model = new ExcelRecord;
        $data = array();

        $csvFile = (!empty($_FILES['excel_file']) ? $_FILES['excel_file']['tmp_name'] : '');
        $csvData = array();
        
        //vertical table
        // if (($handle = fopen($csvFile, "r")) !== FALSE) {
        //     $header = fgetcsv($handle, 1000, ",");
        //     print_r($header);
        //     $i=0;
        //     while (($excel_data = fgetcsv($handle, 1000, ",")) !== FALSE) {                
        //         $data['name'] = (!empty($excel_data[1]) ? $excel_data[1] : '');
        //         $data['email_id'] = (!empty($excel_data[2]) ? $excel_data[2] : '');
        //         $model->save($data);                
        //         $i++;
        //     }
            
        //     fclose($handle);
        // } else {
        //     echo "Error: Could not open the file.";
        // }

        //horizontal table
        if (($handle = fopen($csvFile, "r")) !== FALSE) {
            
            while(($row = fgetcsv($handle, 1000, ',')) !== FALSE){
                $csvData[] = $row;
                
            }
            fclose($handle);
            $columns = count($csvData[0]);

            for($i=1; $i< $columns; $i++){
                // $data['id'] = $csvData[0][$i];
                $data['name'] = $csvData[1][$i];
                $data['email_id'] = $csvData[2][$i];
                $check = $model->where('id="'.$csvData[0][$i].'" ')->first();
                if(!empty($check)){
                    // echo"Not Empty \n";
                    $check['name'] = $csvData[1][$i];
                    $check['email_id'] = $csvData[2][$i];
                    $model->update($check['id'],$check);
                }
                else{
                    // echo "Empty \n";
                    // print_r($data);
                    $model->save($data);
                }
            }
        }
    }

    public function writeExcel(){
        $model = new ExcelRecord;
        $user_data = $model->where('status="1"')->findAll();

        if(!empty($user_data)){
            $path = FCPATH.'/upload/excel_users/';

            if(!is_dir($path)){
                mkdir($path,0777,true);
            }

            $filePath = $path.'users.csv';
            
            if (($handle = fopen($filePath, 'w')) !== FALSE) {
                $header = ['ID', 'Name', 'Email'];
                fputcsv($handle, $header);

                foreach($user_data as $val){
                    $row = [$val['id'],$val['name'],$val['email_id']];
                    fputcsv($handle,$row);
                }
                fclose($handle);

            }

            
            header('Content-Description: File Transfer');
            header('Content-Type: application/octet-stream');
            header('Content-Disposition: attachment; filename="' . basename($filePath) . '"');
            header('Expires: 0');
            header('Cache-Control: must-revalidate');
            header('Pragma: public');
            header('Content-Length: ' . filesize($filePath));

            // Clear output buffer
            flush();

            // Read the file and output its contents
            readfile($filePath);

        }
    }
}

?>
