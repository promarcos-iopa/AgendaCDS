  /Conexion base de datos sistema principal.
  define('URL','URL servidor/agenda_medica_cds/');  ->URL base del sistema en el servidor local.
  define('HOST','localhost'); ->Dirección del servidor de la base de datos (por defecto, localhost).
  define('DB','Nombre DB');   ->Nombre de la base de datos utilizada por el sistema.
  define('USER','Usuario');   ->Usuario con permisos para conectarse a la base de datos.
  define('PASSWORD','');      ->Contraseña del usuario de la base de datos (vacío en desarrollo). 
  define('CHARSET','utf8mb4'); -> Conjunto de caracteres utilizado (utf8mb4 recomendado).
  
  define('TOKEN','API_TOKEN'); ->Clave utilizada para autenticar peticiones a los endpoints protegidos de la API.
  
  //Direccion de la Api ApiCitasCds (producción).
  define('ApiCitasCds','Dirección'); ->URL de la API en producción.
  //Direccion de la Api ApiCitasCds (desrrollo).
  define('ApiCitasCds_d','Dirección'); ->URL de la API en desarrollo.
  
  //Conexion base de datos otro sistema.
  define('HOST_iopaweb','URL servidor/iopanet'); ->Dirección del servidor de la base de datos externa.
  define('DB_iopaweb','Nombre DB'); ->Nombre de la base de datos utilizada en el otro sistema.   
  define('USER_iopaweb','Usuario'); 
  define('PASSWORD_iopaweb','Contraseña'); ->Contraseña de acceso a la base de datos externa.
