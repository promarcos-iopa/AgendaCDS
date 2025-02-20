<?php
$paciente=$this->paciente;
$fecha_atencion=$this->fecha_atencion;
?>
<div class="modal" id="cargar" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" aria-hidden="true">
  <div class="modal-dialog modal-lg">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Cargar archivo GES</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
      <input type="hidden" class="form-control" id="fecha" value="<?php echo $fecha_atencion; ?>">
      <input type="hidden" class="form-control " id="id_rut" value="<?php echo $paciente; ?>">
        <p id ="id_paciente">Paciente: <b><?php echo $paciente; ?></b></p>
        <p>Fecha de atencion: <b><?php echo $fecha_atencion; ?></b>
        <div class="input-group mb-3">
            <input type="file" class="form-control" id="archivo_ges">
            <label class="input-group-text" for="archivo_ges">Cargar</label>
        </div>
        <button type="button" class="btn btn-primary" id="uploadButton">Subir Archivo</button>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerra</button>
      </div>
    </div>
  </div>
</div>
<script>
    $(document).ready(function()
    {
        $("#uploadButton").on("click", function()
        {
            var formData = new FormData();
            var file = $("#archivo_ges")[0].files[0];
            var fecha=$("#fecha").val();
            var id_rut=$("#id_rut").val();
            // var id_paciente=$("#id_paciente").text();

            // console.log(id_paciente);
            // console.log(rut);
            
            if(file)
            {
              Swal.fire({
                title: '¿Está seguro de guardar el archivo?',
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Aceptar',
                cancelButtonText: 'Cancelar'
              }).then((result) => {
                if (result.isConfirmed)
                {
                  Swal.fire({
                    title: 'Cargando...',
                    allowOutsideClick: false,
                    allowEscapeKey: false,
                    allowEnterKey: false,
                    showConfirmButton: false,
                    willOpen: () => {
                        Swal.showLoading();
                    }
                  });
                  formData.append("archivo_ges", file);
                  formData.append("fecha", fecha);  
                  formData.append("id_rut", id_rut);  
                  $.ajax({
                      url: "<?php echo constant('URL'); ?>ges/CargarArchivoGES",
                      type: "POST",
                      data: formData,
                      contentType: false, // No definir contentType para evitar conflictos con FormData
                      processData: false, // No procesar los datos para evitar conflictos con FormData
                      dataType: 'json',
                      success: function(response)
                      {
                        // const response = JSON.parse(response);
                          console.log("Archivo subido exitosamente:", response);
                          if(response.success === true)
                          {
                              Swal.fire({
                              title: 'Archivo Cargado!',
                              icon: 'success',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'OK'
                            }).then((result) => {
                              $('#cargar').modal('hide');
                            });
                          }
                          else
                          {
                            Swal.fire({
                              title: response.message+ "asdasasd",
                              icon: 'error',
                              showCancelButton: false,
                              confirmButtonColor: '#3085d6',
                              cancelButtonColor: '#d33',
                              confirmButtonText: 'OK'
                            });
                          }
                          // Aquí puedes agregar lógica adicional después de la subida exitosa
                      },
                      error: function(xhr, status, error)
                      {
                          console.error("Error al subir el archivo:", status, error);
                          Swal.fire({
                            title: 'Error al subir el archivo.!',
                            icon: 'error',
                            showCancelButton: false,
                            confirmButtonColor: '#3085d6',
                            cancelButtonColor: '#d33',
                            confirmButtonText: 'OK'
                          });
                      }
                  });
                }
              });
            }
            else
            {
                console.log("Por favor, seleccione un archivo antes de intentar subirlo.");
                // error
                Swal.fire({
                  title: 'Por favor, seleccione un archivo antes de intentar subirlo.!',
                  icon: 'error',
                  showCancelButton: false,
                  confirmButtonColor: '#3085d6',
                  cancelButtonColor: '#d33',
                  confirmButtonText: 'OK'
                });
            }
        });
    });
</script>