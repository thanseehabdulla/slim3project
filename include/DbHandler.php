<?php

/**
 * Class to handle all db operations
 * This class will have CRUD methods for database tables
 *
 * @author Ravi Tamada
 * @link URL Tutorial link
 */
class DbHandler {

    private $conn;

    function __construct() {
        require_once dirname(__FILE__) . '/DbConnect.php';
        // opening db connection
        $db = new DbConnect();
        $this->conn = $db->connect();
    }

    /* ------------- `users` table method ------------------ */

    /**
     * Creating new user
     * @param String $name User full name
     * @param String $email User login email id
     * @param String $password User login password
     */
    public function createUser($name, $email, $password,$mobile,$address, $typeid, $isactive, $created,$updated) {
        $response = array();

        // First check if user already existed in db
        if (!$this->isUserExists($email)) {
 
            $stmt = $this->conn->prepare("INSERT INTO user(user_name, user_email, user_pass, user_mobile,user_address, type_id,isactive,created,updated) values(?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("sssssssss", $name, $email, $password, $mobile, $address,$typeid,$isactive, $created,$updated);

            $result = $stmt->execute();

            $stmt->close();

            // Check for successful insertion
            if ($result) {
                // User successfully inserted
                return USER_CREATED_SUCCESSFULLY;
            } else {
                // Failed to create user
                return USER_CREATE_FAILED;
            }
        } else {
            // User with same email already existed in the db
            return USER_ALREADY_EXISTED;
        }

        return $response;
    }

   
    private function isUserExists($email) {
        $stmt = $this->conn->prepare("SELECT id from user WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->store_result();
        $num_rows = $stmt->num_rows;
        $stmt->close();
        return $num_rows > 0;
    }
 public function getUserByEmail($email) {
        $stmt = $this->conn->prepare("SELECT user_name, user_email, user_pass,user_mobile,type_id,id,isactive,created,updated FROM user WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        if ($stmt->execute()) {
            $stmt->bind_result($name, $email, $user_pass,$mobiles,$type_id,$id,$isactive,$created,$updated);
            $stmt->fetch();
            $user = array();
            $user["name"] = $name;
            $user["email"] = $email;
            $user["passwords"] = $user_pass;
            $user["mob"] = $mobiles;
            $user["type"] = $type_id;
            $user["id"] = $id;
            $user["isactive"] = $isactive;
            $user["created"] = $created;
             $user["updated"] = $updated;
            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }
 public function insertData($order_number, $order_desc, $order_qty,$order_amount, $order_date, $product_id,$dealer_id, $agent_id, $client_id, $isactive, $created,$updated) {
        $response = array();
       
            $stmt = $this->conn->prepare("INSERT INTO item_order(order_number, order_desc, order_qty,order_amount,order_date, product_id,dealer_id,agent_id,client_id, isactive, created,updated) values(?,?,?,?,?,?,?,?,?,?,?,?)");
            $stmt->bind_param("ssssssssssss", $order_number, $order_desc, $order_qty,$order_amount, $order_date, $product_id,$dealer_id, $agent_id, $client_id, $isactive, $created,$updated);

            $result = $stmt->execute();
 
            $stmt->close();
             if ($result) {
              //   echo "New record createdccqqc ";
       
                return USER_CREATED_SUCCESSFULLY;
            } else {
                 echo "New record createdcdddcc ";
       
                return USER_CREATE_FAILED;
            }
        

        return $response;
        
}

public function getAllDataByID($id) {
      $stmt = $this->conn->prepare("SELECT id,order_number,order_qty ,order_desc,order_amount,order_date,product_id,dealer_id,agent_id,client_id,isactive,created,updated FROM item_order WHERE id = ?");
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            $stmt->bind_result($id,$order_qty, $order_desc,$order_number,$order_amount,$order_date,$product_id,$dealer_id,$agent_id,$client_id,$isactive,$created,$updated);
            $stmt->fetch();
            $user = array();
            // $user["id"] = $id;
            // $user["order_qty"] = $order_qty;
            // $user["order_desc"] = $order_desc;   
            $user["order_number"] = $order_number;
            // $user["order_amount"] = $order_amount;
            // $user["order_date"] = $order_date;   
            // $user["product_id"] = $product_id;
            // $user["dealer_id"] = $dealer_id;
            // $user["agent_id"] = $agent_id;   
            // $user["client_id"] = $client_id;
            // $user["isactive"] = $isactive;
            // $user["created"] = $created;    
            // $user["updated"] = $updated;
            // $response=$user;
            // echo json_encode($response);      

            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }


public function getSpinnerData($id) {
      $stmt = $this->conn->prepare("SELECT  type_name FROM payment_type");
        $stmt->bind_param("s", $id);
        if ($stmt->execute()) {
            $stmt->bind_result($type_name);
            $stmt->fetch();
            $user = array();
            // $user["id"] = $id;
            // $user["order_qty"] = $order_qty;
            // $user["order_desc"] = $order_desc;   
            $user[" type_name"] = $type_name;
            // $user["order_amount"] = $order_amount;
            // $user["order_date"] = $order_date;   
            // $user["product_id"] = $product_id;
            // $user["dealer_id"] = $dealer_id;
            // $user["agent_id"] = $agent_id;   
            // $user["client_id"] = $client_id;
            // $user["isactive"] = $isactive;
            // $user["created"] = $created;    
            // $user["updated"] = $updated;
            // $response=$user;
            // echo json_encode($response);      

            $stmt->close();
            return $user;
        } else {
            return NULL;
        }
    }





    /*public function getAllDataBydealer_id($dealer_id) {
     // echo json_encode($dealer_id);
//echo $dealer_id;
$db=new PDO('mysql:dbname=rice_dealer;host=localhost;','root','');  
$row=$db->prepare("select * from item_order where dealer_id = $dealer_id"); 

  
$row->execute(); 
$json_data=array();
        foreach($row as $rec)
        {  
              $json_array['id']=$rec['id'];  
              $json_array['order_number']=$rec['order_number'];  
              $json_array['order_desc']=$rec['order_desc'];  
              $json_array['order_qty']=$rec['order_qty'];  
              $json_array['order_amount']=$rec['order_amount'];  
               $json_array['dealer_id']=$rec['dealer_id'];  
              $json_array['order_date']=$rec['order_date'];  
              $json_array['product_id']=$rec['product_id'];  
              $json_array['agent_id']=$rec['agent_id'];  
               $json_array['client_id']=$rec['client_id'];  
              $json_array['isactive']=$rec['isactive'];  
              $json_array['created']=$rec['created'];  
              $json_array['updated']=$rec['updated'];  
              array_push($json_data,$json_array);  
          }  
       return $json_data;
      
    }*/


 public function checkLogin($email, $password) {
        $stmt = $this->conn->prepare("SELECT user_pass FROM user WHERE user_email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $stmt->bind_result($password_hash);
        $stmt->store_result();
        if ($stmt->num_rows > 0) {
            $stmt->fetch();
            $stmt->close();   
                 if ($password_hash==$password) {
                    return TRUE;
                      }
                 else{
                    return FALSE;
                      }              
        } else {
            $stmt->close();
            return FALSE;
        }
    }


}

?>
