 <?php class Connect
 {
     private $con;

     function connect()
     {
         include_once dirname(__FILE__) . '/Constants.php';

         $this->con = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME);

         if ($this->con == null) {
             echo 'Failed to connect ' . mysqli_connect_error();
             return null;
         } else {
             return $this->con;
         }
     }
 }
