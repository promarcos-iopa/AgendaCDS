<?php
class LoginModel extends Model
{
	  public function __construct(){
        parent::__construct();
    }
    
    
    public function verificar($us, $pa) {
      $query = $this->db->connect()->prepare('SELECT * FROM usuarios WHERE email = :us AND pass = :pa');
      
      try {
          $query->execute(['us' => $us, 'pa' => $pa]);
  
          // Verificar si hay resultados
          if ($row = $query->fetch(PDO::FETCH_ASSOC)) {
              // Retornar los datos del usuario como un arreglo
              return $row;
          } else {
              // Si no hay resultados, retornar false
              return false;
          }
      } catch (PDOException $e) {
          // Manejar el error y retornar false
          return false;
      }
    }


    public function insertLogUsuariosCds($email, $ip_usuario) {
        try {
            // Preparar la sentencia SQL con placeholders
            $sql = "INSERT INTO log_usuarios_cds (usuario, ip_usuario, fecha) 
                    VALUES (:usuario, :ip_usuario, NOW())";
    

            $query = $this->db->connect()->prepare($sql);
            // Asignar los valores correctos a los placeholders
            $query->bindParam(':usuario', $email); 
            $query->bindParam(':ip_usuario', $ip_usuario); 
        
          
            if ($query->execute()) {
                return true; 
            } else {
                return false; 
            }
    
        } catch (PDOException $e) {
            // Manejar el error de la excepción
            error_log("Error en la inserción: " . $e->getMessage());
            return false;
        }
    }

    public function getmenu($idu){
        $items = [];
        include_once 'models/usuariosperfil.php';
        try{
            $query=$this->db->connect()->query("SELECT * FROM usuariosperfil WHERE idusuario='".$idu."' AND  habilitado='S'");
            while($row=$query->fetch()){
                 $item = new Usuariosperfil();
                 $item->id            = $row['id'];
                $item->idusuario     = $row['idusuario'];
                 $item->menu          = $row['menu'];
                 $item->habilitado    = $row['habilitado'];
                 $item->principal    = $row['principal'];
                 array_push($items,$item);
                 }
          return $items;
      }catch(PDOException $e){
          return [];
      }
    } 
}
?>
