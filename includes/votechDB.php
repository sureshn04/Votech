<?php


require_once __DIR__ .'/../vendor/autoload.php';

class votechDB {
  private $conn;
  private $error = false;
  private $logger;

  private static $votechDBObj = null;

  private function __construct()
  {
    $this->conn = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);

    if($this->conn->error){
      $this->error = true;

      $this->logger = Logger::getLogger();
      $this->logger->pushToError($this->conn->error);
      die("Database Error>.....");
    } 

  }

  public static function getConnection(){
    if(self::$votechDBObj == null){
        self::$votechDBObj = new votechDB();
    }
    return self::$votechDBObj;
  }

  public function insert($table, $values){
    $sql = "INSERT INTO $table SET ";
    $c=0;
    if(!empty($values)){
     foreach($values as $key=>$val){
         if($c==0){
             $sql .= "$key='".htmlentities($val, ENT_QUOTES)."'";
         }else{
             $sql .= ", $key='".htmlentities($val, ENT_QUOTES)."'";
         }
         $c++;
     }
    }else{
    return false;
    }
    // echo $sql;
    $this->conn->query($sql) or die('ERROR '. mysqli_error($this->conn));
    return mysqli_insert_id($this->conn);
  }

  public function update($table,$values,$condition){
        $sql="UPDATE $table SET ";
        $c=0;
        if(!empty($values)){
            foreach($values as $key=>$val){
                if($c==0){
                    $sql .= "$key='".htmlentities($val, ENT_QUOTES)."'";
                }else{
                    $sql .= ", $key='".htmlentities($val, ENT_QUOTES)."'";
                }
                $c++;
            }
        }
        $k=0;
        if(!empty($condition)){
            foreach($condition as $key=>$val){
                if($k==0){
                    $sql .= " WHERE $key='".htmlentities($val, ENT_QUOTES)."'";
                }else{
                    $sql .= " AND $key='".htmlentities($val, ENT_QUOTES)."'";
                }
                $k++;
            }
        }else{
          return false;
        }
        echo $sql;
        $result = $this->conn->query($sql) or die('ERROR'.mysqli_error($this->conn));
        return $result;
     }

    public function delete($table,$where) {
      $sql = "DELETE FROM $table ";
      $k=0;    
      if(!empty($where)){
          foreach($where as $key=>$val){
              if($k==0){
                  $sql .= " where $key='".htmlentities($val, ENT_QUOTES)."'";
              }else{
                  $sql .= " AND $key='".htmlentities($val, ENT_QUOTES)."'";
              }
              $k++;
          }
      }else{
          return false;
      }
      $del =  $this->conn->query($sql) or die('ERROR'.mysqli_error($this->conn));
      if($del){
          return true;
      }else{
          return false;
      }
    }

    public function select($table, $rows = '*', $where = null, $order = null, $limit = null)
    {
       if($rows != '*'){
         $rows = implode(",",$rows);
       }

        $sql = 'SELECT '.$rows.' FROM '.$table;
        if($where != null){
            $k=0;
            foreach($where as $key=>$val){
                if($k==0){
                    $sql .= " WHERE $key='".htmlentities($val, ENT_QUOTES)."'";
                }else{
                    $sql .= " AND $key='".htmlentities($val, ENT_QUOTES)."'";
                }
                $k++;
            }    
        }

        if($order != null){
            foreach($order as $key=>$val){
                    $sql .= " ORDER BY $key ".htmlentities($val, ENT_QUOTES)."";
            }    
        }    

      if($limit != null){
             $limit = implode(",",$limit);
             $sql .= " LIMIT $limit";

        }
        
        $result = $this->conn->query($sql);
        return $result;

    }  

    public function query($sql){
    $result = $this->conn->query($sql);
    return $result;
    }

    public function result($result){
    $row = $result->fetch_object();
    $result->close();
    return $row;
    }

    public function row($result){
    $row = $result->fetch_row();
    $result->close();
    return $row;
    }

    public function numrow($result){
    $row = $result->num_rows;
    $result->close();
    return $row;
    }
}
