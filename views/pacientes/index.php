<!DOCTYPE html>
<html>
<head><meta http-equiv='Content-Type' content='text/html; charset=utf-8'>
	
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Importar Pacientes</title>
	<link rel="stylesheet" href="">

	<style>
		label {
            color: #adadad !important;
            font-weight: bold !important;
        }
		
		
	</style>
</head>
<body>
	<?php require 'views/header.php'?>
<div id="content-wrapper" class="d-flex flex-column">
    <!-- Main Content -->
    <div id="content">
        <!-- Begin Page Content -->
        <div class="container" >
            <div class="row mt-3">
                <div class="col">
                    <form class="border rounded bg-light p-3">
                        <div class="position-relative mb-4">
                            <h3>
                                <div class="alert alert-primary text-center">Cargar pacientes agendados</div>
                            </h3>
                            <div id="divInfo" class="alert alert-warning alert-dismissible fade show position-absolute top-0 end-0" style="display: none;">
                                <span id="msg"></span>
                                <button type="button" id="cierre" class="btn-close" aria-label="Close"></button>
                            </div>
                        </div>

                        <div class="row g-3">
							<div class="form-group col-md-3">
								<label for="medico" class="form-label">Médicos:</label>
								<select class="form-control" id="medico" name="medico">
								</select>
							</div>
							<div class="form-group col-md-3">
								<label for="fecha_agenda" class="form-label">Fecha de agenda:</label>
								<input type="date" class="form-control form-control-sm" id="fecha_agenda" name="fecha_agenda" required>
							</div>
                            <!-- Adjuntar archivo -->
                            <div class="form-group col-md-4">
							<!-- form-control-sm tamaño input  -->
                                <label for="archivoExcel" class="form-label">Adjuntar Archivo</label>
                                <input type="file" id="archivoExcel" name="archivoExcel" class="form-control form-control-sm" accept=".xls, .xlsx">
                            </div>
                            <div class="col-md-2 d-flex align-items-end">
							<!-- btn-sm tamaño boton -->
                                <button type="button" id="importarExcel" class="btn btn-secondary  btn-sm me-3">Cargar Excel</button>
                                <button type="button" id="cargarHistorial" class="btn btn-info btn-sm text-white" hidden>Historial de Importación</button>
                            </div>
                        </div>
                        <!-- Tabla historial -->
                        <div class="mt-4">
                            <div class="card">
                                <div class="card-body">
                                    <div class="table-responsive" style="width: 1245px;height: 381px;overflow: scroll;">
                                        <table class="table table-sm" id="tblCargarImportacion">
                                            <thead class="table-light">
                                                <tr>
                                                    <!-- <th style="width:180px;">Hora</th>
                                                    <th style="width:230px;">FN</th>
                                                    <th style="width:80px;">Nombre</th>
                                                    <th style="width:120px;">Rut</th>
                                                    <th style="width:130px;">DV</th>
                                                    <th style="width:250px;">Teléfono 1</th>
                                                    <th style="width:160px;">Teléfono 2</th>
                                                    <th style="width:70px;">Centro</th>
                                                    <th style="width:70px;">Correo Electrónico</th> -->
                                                    <th >Hora</th>
                                                    <th >FN</th>
                                                    <th >Nombre</th>
                                                    <th >Rut</th>
                                                    <th >DV</th>
                                                    <th >Teléfono 1</th>
                                                    <th >Teléfono 2</th>
                                                    <th >Centro</th>
                                                    <th >Correo Electrónico</th>
                                                </tr>
                                            </thead>
                                            <tbody style="height:350px;">
                                                <!-- Contenido dinámico -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div class="mt-3">
                                <p id="cantidadImportados" class="fst-italic text-muted">Cantidad de registros cargados:</p>
                            </div>
                            <input id="fechaDesde" type="text" name="fechaDesde" hidden>
                            <input id="fechaHasta" type="text" name="fechaHasta" hidden>
                        </div>

                        <!-- Botones -->
                        <div class="row mt-4">
                            <div class="col-md-3">
                                <button type="button" id="guardarImportacion" class="btn btn-primary btn-sm w-100">Guardar</button>
                            </div>
                            <div class="col-md-6 d-flex justify-content-center">
                                <button type="button" id="exportarNoCargados" class="btn btn-warning btn-sm text-white me-3" hidden>Exportar Excel No Relacionados</button>
                                <button type="button" id="ExcelImportado" class="btn btn-success btn-sm" hidden>Exportar Excel Relación</button>
                            </div>
                            <div class="col-md-3 text-end">
                                <button type="button" id="limpiarImportacion" class="btn btn-secondary btn-sm w-100">Limpiar</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
	<?php require 'views/footer.php'?>
	<script src="<?php echo constant('URL'); ?>public/select2/js/select2.full.min.js"></script>
	<script>
		$(document).ready(function(){
			buscarMedicos();

			$('#medico').select2({
                placeholder: 'Seleccione una opción',
                allowClear: true
            });


			$('#limpiarImportacion').click(function(e){
				$('#medico').val('0').trigger('change'); //reaniciar al valor de carga del select2 medicos 
				$('#fecha_agenda').val('');
				$('#archivoExcel').val('');
				$('#importarExcel').prop("disabled", false);
				// $('.filasDatosImportacion').remove();
				$('#tblCargarImportacion tbody').empty();
				$('#cantidadImportados').text('Cantidad de registros cargados:');
               
            });



			$('#importarExcel').click(function(e){
				e.preventDefault();
				let nombre_medico = $('#medico').select2('data')[0].text;
				if(nombre_medico !="Seleccione Médico"){
					let value = $('#medico').val(); // value contiene el id_medico y el rut del medico
					// Dividir el value por el punto
					let partes = value.split('.');
					// obtener el primer caracter del value (id_medico)
					let id_medico = partes[0]; 
					// obtener elimina el primer caracter del value para obtener el rut medico
					let rut_medico =  partes[1]; 
					
				
					let fecha = $('#fecha_agenda').val();
					
					// Array para almacenar campos vacíos
					let camposVacios = [];

					// Verificar si alguno de los campos está vacío
					if (!id_medico) camposVacios.push("Médico");
					if (!fecha) camposVacios.push("Fecha Agenda");
					

					// Si hay campos vacíos, mostrar SweetAlert
					if (camposVacios.length > 0) {
						// Crear un mensaje con los campos vacíos
						let mensaje = "Los siguientes campos están vacíos:\n" + camposVacios.join(", ");
						Swal.fire({
							title: 'Campos Vacíos obligatorios',
							text: mensaje,
							icon: 'warning',
							confirmButtonText: 'Aceptar'
						});
						return false; // Detener la ejecución si hay campos vacíos
					}else{
						// validar la existencia del archivo
						if ($('#archivoExcel').get(0).files.length == 0){
							// Swal.fire({
							// 	icon: 'warning',
							// 	text: 'Debe seleccionar un archivo de Excel!',
							// 	showConfirmButton: true
							// 	//timer: 2000

							// })
							Swal.fire({
								text: "¡Debe seleccionar un archivo de Excel!",
								icon: 'warning'
							}).then((result) =>{
								return false;
							});

						}else{
							//Validar extensión de los archivos
							var arrayExtensiones =[".xls","xlsx"]
							var nombreArchivo = $('#archivoExcel').val();
							var expRegulares = new RegExp("([a-zA-z0-9\s_\\-.\:])+("+arrayExtensiones.join('|')+ ")$");
							// console.log(arrayExtensiones);
							// console.log(nombreArchivo);
							// console.log(expRegulares);

							// Validacion formato archivo
							if (!expRegulares.test(nombreArchivo.toLowerCase())){
								Swal.fire({
									title: "¡No se puede cargar este archivo!",
									text: "Debe seleccionar un archivo de Excel con extensión .xls o .xlsx",
									icon: 'warning'
								}).then((result) =>{
									return false;
								});

							}
							//alert('Archivo de Excel cumplio con las validaciones')
							var data = new FormData();
							$('#importarExcel').prop("disabled", true);
							let file = $('#archivoExcel')[0].files[0];
					
							data.append("archivos",file);
						
							Swal.fire({
								title: 'Cargando registros del Excel...',
								allowEscapeKey: false,
								allowOutsideClick: false,
								didOpen: () => {
									Swal.showLoading(); // Muestra un ícono de carga mientras se realiza una operación
								}
							});
						
							
							if(data !=""){
								$.ajax({
									type: "POST",
									url: "<?php echo constant('URL');?>pacientes/cargarExcel",
									data: data,
									contentType: false,
									processData: false,
									success: function(respuesta){
										console.log(respuesta)
										
										
										if (respuesta !=''){
											var obj = JSON.parse(respuesta);
											
											// var error = obj.arrObj[0]["mensaje"];
											var cantidadRegistros = obj.length;
											if (cantidadRegistros !=0){
												var error = obj;
												if (error !='Error 1'){//error === null
													for (let i=obj.length - 1; i >= 0; i--) { //Conteo Descendente
													// for (let i = 0; i < obj.length; i++){  //Conteo Ascendente
											
														var sHtml = '<tr class="filasDatosImportacion" data-id="0">'; 
														sHtml += '<td>' + obj[i]["Hora"] + '</td>';  
														sHtml += '<td>' + obj[i]["Fecha_nacimiento"] + '</td>';
														sHtml += '<td>' + obj[i]["Nombre"] + '</td>';        					
														sHtml += '<td>' + obj[i]["RUT"] + '</td>';  
														sHtml += '<td>' + obj[i]["DV"] + '</td>'; 
														//sHtml += '<td>' + obj[i]["Telefono1"] + '</td>'; 
														//sHtml += '<td>' + obj[i]["Telefono2"] + '</td>';
														//VALIDA QUE LOS CAMPOS NO SEAN NULL Y UNDEFINED
														sHtml += '<td>' + (obj[i]["Telefono1"] !== null && obj[i]["Telefono1"] !== undefined ? obj[i]["Telefono1"] : '') + '</td>';
														sHtml += '<td>' + (obj[i]["Telefono2"] !== null && obj[i]["Telefono2"] !== undefined ? obj[i]["Telefono2"] : '') + '</td>'; 
														sHtml += '<td>' + obj[i]["Centro"] + '</td>'; 
														// sHtml += '<td>' + obj[i]["Correo_Electronico"] + '</td>'; 
														//VALIDA QUE LOS CAMPOS NO SEAN NULL Y UNDEFINED
														sHtml += '<td>' + (obj[i]["Correo_Electronico"] !== null && obj[i]["Correo_Electronico"] !== undefined ? obj[i]["Correo_Electronico"] : '') + '</td>';
														sHtml += '</tr>';
														
														
														$('#tblCargarImportacion').prepend(sHtml);
														// $('.codigoGrupo').hide();
													}
													// $('#fechaDesde').val(obj.arrObj[0]["fechaDesde"]);
													// $('#fechaHasta').val(obj.arrObj[0]["fechaHasta"]);
													
											
													textoTotalRegistros = 'Cantidad de registros Importados: '+cantidadRegistros+'';
													$('#cantidadImportados').text(textoTotalRegistros);
													$("#exportarNoCargados").prop('disabled', false);
													$("#ExcelImportado").prop('disabled', false);
													$('#guardarImportacion').prop("disabled", false);
													// $(".loader").fadeOut();
													Swal.close();
													
												}else{
													Swal.close();
													Swal.fire({
														title: "¡El archivo no cumple con la estructura esperada!",
														text: "Revisar la estructura o cantidad de columnas del archivo",
														icon: 'warning'
													}).then((result) => {
														$('#importarExcel').prop("disabled", false);
														return false;
														
													});
													
												}

												


											}else{
												Swal.close();
												Swal.fire({
													title: "¡El archivo cargado no contiene registros!",
													text: "Por favor revise los registros del Excel con extensión .xls o .xlsx",
													icon: 'warning'
												}).then((result) => {
													$('#importarExcel').prop("disabled", false);
													return false;
													
												});
												// textoTotalRegistros = 'Cantidad de registros cargados: '+cantidadRegistros+'';
												// $('#cantidadImportados').text(textoTotalRegistros);
												// $('#importarExcel').prop("disabled", false);
												// $("#exportarNoCargados").prop('disabled', false);
												// $(".loader").fadeOut();
											
											}
											
											
										}
													
										
									}
								});
							
						
							}	

						}

					}

				}
				Swal.fire({
					title: 'Campos Vacíos obligatorios',
					text: 'Seleccione Médico',
					icon: 'warning',
					confirmButtonText: 'Aceptar'
				});
				return false; // Detener la ejecución si hay campos vacíos
				
			});



			$("#guardarImportacion").click(function(e){
				e.preventDefault();

				// Seleccionar todas las filas de tbody
				let filas = $('#tblCargarImportacion tbody tr');

				if (filas.length > 0) {
					//Funcion de llenado grilla importados relacionados
					llenadoImportacion(guardarImportacion);
				} else {
					Swal.fire({
						icon: 'warning', // Icono de advertencia
						title: 'Tabla Vacía',
						text: 'No existen registros en la tabla para guardar.',
						confirmButtonText: 'Aceptar'
					});
				}

			});




		});



		function buscarMedicos() {
		
			$.ajax({
				type: 'GET',
				url: '<?php echo constant('URL')?>bloque/obtenerMedicos',
				dataType: 'json',
				success: function(response) {
					$("#medico").empty().append('<option value="0" selected disabled>Seleccione Médico</option>');
					
					let len = response.length;
					for (let i = 0; i < len; i++) {
						let id_medico = response[i].id;
						let rut = response[i].rut;
						let nombre = response[i].nombre;
						let apellido1 = response[i].apellido1;
						let apellido2 = response[i].apellido2;
						let full_nombre = nombre + " " + apellido1 + " " + apellido2;

						// Crear un arreglo con el id_medico y el rut
						let value = id_medico+'.'+rut;
						$('#medico').append('<option value="' + value + '">' + full_nombre + '</option>');
					}
				},
				error: function(xhr, status, error) {
					console.log(error);
				}
			});
		}



		function llenadoImportacion(callback){
			$('#guardarImportacion').prop("disabled", true);
			objArrImportacion= [];	
			let nFilas = $("#tblCargarImportacion tr").length;
			let fecha_agenda = $('#fecha_agenda').val();

			let diaSemana = obtener_dia_semana(fecha_agenda); // Obtener el día de la semana según la fecha de agenda
			console.log(diaSemana);
			// exit();
			
			let arregloDias = []; // Crear el arreglo para almacenar el día
			arregloDias.push(diaSemana); // Almacenar el valor de diaSemana en el arreglo

			let value = $('#medico').val(); // value contiene el id_medico y el rut del medico
			// Dividir el value por el punto
			let partes = value.split('.');
			// obtener el primer caracter del value (id_medico)
			let id_medico = partes[0]; 
			// obtener elimina el primer caracter del value para obtener el rut medico
			let rut_medico =  partes[1]; 
			let nombre_medico = $('#medico').select2('data')[0].text;
			// debugger;
			
			if (nFilas > 1){
				let filas = $("#tblCargarImportacion").find("tr"); //devulve las filas del body de tu tabla segun el ejemplo que brindaste
				
				for(i=1; i<filas.length; i++){ //Recorre las filas 1 a 1
					let celdas = $(filas[i]).find("td"); //devolverá las celdas de una fila
			
					 // Obtiene los valores de las celdas
					let hora = $(celdas[0]).text();
					let hora_fin = hora_termino(hora)
					let fecha_nacimiento = $(celdas[1]).text();
					let nombre = $(celdas[2]).text();
					let rut = $(celdas[3]).text();
					let dv = $(celdas[4]).text();
					let telefono1 = $(celdas[5]).text();
					let telefono2 = $(celdas[6]).text();
					let centro = $(celdas[7]).text();
					let correo = $(celdas[8]).text();

					// Crea el objeto con las propiedades correctas
					let objItem = {
						hora: hora,
						fechaNacimiento: fecha_nacimiento,
						nombre: nombre,
						rut: rut,
						dv: dv,
						telefono1: telefono1,
						telefono2: telefono2,
						centro: centro,
						correo: correo
					};

					

					// Agrega el objeto al arreglo
					objArrImportacion.push(objItem);
				
				}
				let data = {id_medico: id_medico, 
					fecha_desde: fecha_agenda, 
					array_dias_select: arregloDias, 
					rut_medico: rut_medico,
					nombre_medico: nombre_medico
				};
				// callback(objArrImportacion, data);
				callback(objArrImportacion, data);
				

			}else{
				Swal.fire({
					title: "¡Error al guardar!",
					text: "No existen registros cargados",
					icon: 'warning'
				}).then((result) => {
					// $('#importarExcel').prop("disabled", false);
					return false;
					
				});
			
			}
		}


		function obtener_dia_semana(fecha){

			let dias = ["lunes", "martes", "miércoles", "jueves", "viernes", "sábado"];
			let date = new Date(fecha); // Convertir la fecha a objeto Date
			let diaSemana = dias[date.getDay()]; // Obtener el índice del día de la semana
			
			// console.log(diaSemana);
			return diaSemana;
		}


		function hora_termino(hora){
			// Convertir la hora a un objeto Date
			let partes = hora.split(":");
			let fecha = new Date();
			fecha.setHours(partes[0]);
			fecha.setMinutes(partes[1]);
			fecha.setSeconds(partes[2]);
			
			// Sumar 10 minutos
			fecha.setMinutes(fecha.getMinutes() + 10);
			
			// Obtener la nueva hora con formato HH:mm:ss
			let nuevaHora = fecha.toTimeString().split(" ")[0];

			return nuevaHora;
			
			
		}


		

function guardarImportacion(objArrImportacion, data){
   	if(objArrImportacion.length > 0){
		$.ajax({
			type: "POST",
			url: "<?php echo constant('URL');?>pacientes/agendarRegistros",
			data: JSON.stringify({
				objArrImportacion: objArrImportacion,  // Pasa el primer arreglo
				data: data                           // Pasa el segundo arreglo
			}), // Serializa ambos arreglos a JSON
			contentType: "application/json", // Especifica que el contenido es JSON
			success: function(respuesta) {
				if (respuesta != "") {
					// var mensaje = JSON.parse(respuesta);
					// debugger;
					// var mensaje = obj.arrObjImportacion[0]["mensaje"];
					
					if (respuesta == 'Reserva agendada con exito'){
						Swal.fire({
							title: "Registros cargados exitosamente ",
							// text: "No existen registros cargados",
							icon: 'success'
						}).then((result) => {
							// $('#importarExcel').prop("disabled", false);
							$('#importarExcel').prop("disabled", false);
							$("#ExcelImportado").prop('disabled', false);
							$('#guardarImportacion').prop("disabled", true);

							//$('#exportarNoCargados').prop("disabled", false);
							$('#archivoExcel').val('');
							$('.filasDatosImportacion').remove();
							$('#cantidadImportados').text('Cantidad de registros Importados: ');
							
						});
					}

				}else{
					//    alert("ERROR AL REGISTRAR EL DETALLE");
					Swal.fire({
						title: "¡Error al guardar los registros!",
						// text: "No existen registros cargados",
						icon: 'warning'
					}).then((result) => {
						// $('#importarExcel').prop("disabled", false);
						return false;
						
					});
				}
			}
		});
   	}
}




	</script>
</body>
</html>
