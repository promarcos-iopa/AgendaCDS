<?php
include_once 'models/medicos.php';
class MedicosModel extends Model
{
	  public function __construct(){
        parent::__construct();
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
    public function get(){
        $items = [];
        try{
            $query=$this->db->connect()->query("SELECT * FROM medicos");
            while($row=$query->fetch()){
                 $item = new Medicos();
                 $item->id     = $row['id'];
                 $item->medico     = $row['medico'];
                 $item->foto     = $row['foto'];
                 array_push($items,$item);
                  }
           return $items;
        }catch(PDOException $e){
            return [];
        }
    }


    public function getregistros($s){
       
         try{
            if ($s==null){ 
                $query=$this->db->connect()->query("SELECT count(*) as son FROM medicos");
            }else{
                $query=$this->db->connect()->query("SELECT count(*) as son FROM medicos WHERE rut='$s'");                               
            }

             while($row=$query->fetch()){
                  $cuantos    = $row['son'];
                   }
            return $cuantos;
         }catch(PDOException $e){
             return [];
         }
     }


    public function getpag($iniciar,$autoporpag,$s){
        $items = [];
        try{
            if ($s==null){
                $query=$this->db->connect()->query("SELECT * FROM medicos order by nombre ASC   LIMIT $iniciar,$autoporpag");
            }else{
                $query=$this->db->connect()->query("SELECT * FROM medicos WHERE rut='$s' order by nombre ASC   LIMIT $iniciar,$autoporpag");
            }
            while($row=$query->fetch()){
                $item = new Medicos();
                $item->id   =$row['id'];
                $item->rut  =$row['rut'];
                $item->nombre =$row['nombre'];
                $item->apellido1 =$row['apellido1'];
                $item->apellido2 =$row['apellido2'];
                $item->fecha_nacimiento =$row['fecha_nacimiento'];
                $item->direccion =$row['direccion'];
                $item->especialidad =$row['especialidad'];
                $item->email =$row['email'];
                $item->telefono =$row['telefono'];
                $item->estado =$row['estado'];

                array_push($items,$item);
            }
            return $items;
        }catch(PDOException $e){
            return [];
        }
    }

    public function getById($id){
        $item=new Medicos();
        $query=$this->db->connect()->prepare("SELECT * FROM medicos WHERE id=:id");
        try{
           $query->execute(['id'=>$id]);
            while($row=$query->fetch()){
                $item->id   =$row['id'];
                $item->rut  =$row['rut'];
                $item->nombre =$row['nombre'];
                $item->apellido1 =$row['apellido1'];
                $item->apellido2 =$row['apellido2'];
                $item->fecha_nacimiento =$row['fecha_nacimiento'];
                $item->direccion =$row['direccion'];
                $item->especialidad =$row['especialidad'];
                $item->email =$row['email'];
                $item->telefono =$row['telefono'];
                $item->estado =$row['estado'];
                  }
           return $item;
        }catch(PDOException $e){
           return null;
        }
    }
    public function update($item){
$query=$this->db->connect()->prepare("UPDATE medicos SET medico=:medico,foto=:foto WHERE id=:id");
    try{
       $query->execute(['id'=>$item['id'],'medico'=>$item['medico'],'foto'=>$item['foto']]);
       return true;
    }catch(PDOException $e){
       return false;
    }
    }

// public function insert($datos){
//        try{
//          $query=$this->db->connect()->prepare('INSERT INTO medicos(id,medico,foto) VALUES  (:id,:medico,:foto)');
//           $query->execute(['id'=>$datos['id'],'medico'=>$datos['medico'],'foto'=>$datos['foto']]);
//            return true;
//        }catch(PDOException $e){
//           return false;
//       }
//     } 


public function insert($rut, $nombre, $apellido1, $apellido2, $fecha_nacimiento, $direccion, $especialidad, $email, $telefono, $estado) {
    try {
        // Preparar la sentencia SQL con placeholders
        $sql = "INSERT INTO medicos (rut, nombre, apellido1, apellido2, fecha_nacimiento, direccion, especialidad, email, telefono, estado) 
                VALUES (:rut, :nombre, :apellido1, :apellido2, :fecha_nacimiento, :direccion, :especialidad, :email, :telefono, :estado)";

        // Preparar la consulta
        $query = $this->db->connect()->prepare($sql);

        // Asignar los valores a los placeholders
        $query->bindParam(':rut', $rut);
        $query->bindParam(':nombre', $nombre);
        $query->bindParam(':apellido1', $apellido1);
        $query->bindParam(':apellido2', $apellido2);
        $query->bindParam(':fecha_nacimiento', $fecha_nacimiento);
        $query->bindParam(':direccion', $direccion);
        $query->bindParam(':especialidad', $especialidad);
        $query->bindParam(':email', $email);
        $query->bindParam(':telefono', $telefono);
        $query->bindParam(':estado', $estado);

        // Ejecutar la consulta
        if ($query->execute()) {
            return true; // Éxito al insertar
        } else {
            return false; // Fallo al insertar
        }

    } catch (PDOException $e) {
        // Manejar el error de la excepción
        error_log("Error en la inserción: " . $e->getMessage());
        return false;
    }
}


//AGREGAR MEDICOS MASIVAMENTE
// public function insert($data) {
//     try {
//         // Preparar la sentencia SQL con placeholders
//         $sql = "INSERT INTO medicos (rut, nombre, apellido1, apellido2, fecha_nacimiento, direccion, especialidad, email, telefono, estado) 
//                 VALUES (:rut, :nombre, :apellido1, :apellido2, :fecha_nacimiento, :direccion, :especialidad, :email, :telefono, :estado)";

//         // Preparar la consulta
//         $query = $this->db->connect()->prepare($sql);
//         $estado = 'activo'; 
//         $especialidad = 'Oftalmologia'; 
//         // Verificar si 'response' está en $data y es un array
//         if (isset($data['response']) && is_array($data['response'])) {
//             // Recorrer el arreglo de médicos en 'response'
//             foreach ($data['response'] as $medico) {
//                 // Asignar los valores del médico actual a las variables
//                 $rut = $medico['rut_pnatural'];
//                 $rut = $this->calcularRutFormateado($rut);
//                 $nombre = $medico['nombre_pnatural'];
//                 $apellido1 = $medico['apellido_paterno'];
//                 $apellido2 = $medico['apellido_materno'];
//                 $especialidad =  $especialidad;
//                 $estado = $estado;

//                 // echo"<pre>";
//                 // var_dump($rut);
//                 // var_dump($nombre);
//                 // var_dump($apellido1);
//                 // var_dump($apellido2);
//                 // var_dump($especialidad);
//                 // var_dump($estado);
//                 // echo"</pre>";
//                 // exit();
                
//                 // Valores adicionales que debes asignar o manejar
//                 $fecha_nacimiento = null;  // Asigna el valor real si está disponible
//                 $direccion = null;  // Asigna el valor real si está disponible
//                 $email = null;  // Asigna el valor real si está disponible
//                 $telefono = null;  // Asigna el valor real si está disponible

//                 // Asignar los valores a los placeholders
//                 $query->bindParam(':rut', $rut);
//                 $query->bindParam(':nombre', $nombre);
//                 $query->bindParam(':apellido1', $apellido1);
//                 $query->bindParam(':apellido2', $apellido2);
//                 $query->bindParam(':fecha_nacimiento', $fecha_nacimiento);
//                 $query->bindParam(':direccion', $direccion);
//                 $query->bindParam(':especialidad', $especialidad);
//                 $query->bindParam(':email', $email);
//                 $query->bindParam(':telefono', $telefono);
//                 $query->bindParam(':estado', $estado);

//                 // Ejecutar la consulta
//                 if (!$query->execute()) {
//                     return false; // Fallo en la inserción de algún registro
//                 }
//             }

//             return true; // Éxito al insertar todos los médicos
//         } else {
//             return false; // El formato de los datos no es correcto
//         }

//     } catch (PDOException $e) {
//         // Manejar el error de la excepción
//         error_log("Error en la inserción: " . $e->getMessage());
//         return false;
//     }
// }




public function insertcsv($datos){
       try{
         $query=$this->db->connect()->prepare('INSERT INTO medicos(id,medico,foto) VALUES  (:id,:medico,:foto)');
          $query->execute(['id'=>$datos['id'],'medico'=>$datos['medico'],'foto'=>$datos['foto']]);
           return true;
       }catch(PDOException $e){
          return false;
      }
    } 
    public function delete($id){
$query=$this->db->connect()->prepare("DELETE FROM medicos WHERE id=:id");
    try{
       $query->execute([
         'id'=>$id,
       ]);
       return true;
    }catch(PDOException $e){
       return false;
    }
    }



    function calcularRutFormateado($rut) {
        // Eliminar espacios y guiones
        $rut = preg_replace('/[^\d]/', '', $rut);
    
        // Validar que el RUT tenga al menos 7 dígitos
        if (strlen($rut) < 7) {
            return null; // RUT inválido
        }
    
        $suma = 0;
        $multiplicador = 2;
    
        // Calcular la suma para el dígito verificador
        for ($i = strlen($rut) - 1; $i >= 0; $i--) {
            $suma += $rut[$i] * $multiplicador;
            $multiplicador++;
            if ($multiplicador > 7) {
                $multiplicador = 2; // Reiniciar el multiplicador
            }
        }
    
        $resto = $suma % 11;
        $digitoVerificador = 11 - $resto;
    
        // Asignar el dígito verificador correspondiente
        if ($digitoVerificador == 11) {
            $digitoVerificador = '0';
        } elseif ($digitoVerificador == 10) {
            $digitoVerificador = 'K';
        }
    
        // Retornar el RUT formateado sin puntos
        return $rut.'-'.$digitoVerificador;
    }

}
?>
