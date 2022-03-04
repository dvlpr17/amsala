<?php 


session_start();

if(!isset($_SESSION['am11012022'])){header("Location: ../index.php");}

# CLASE COLECCIONES
require_once '../clases/colecciones.php';

# OBTIENE LAS COLECCIONES
$colecciones = Colecciones::singleton_Colecciones();
$lasColecciones = $colecciones->get_colecciones();


?>


<!DOCTYPE html>
<html>
<head>

	<meta charset="utf-8">
	<title>AMSALA</title>

	
	<!-- CSS only -->
	<!-- CSS only -->
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<link href="https://cdn.datatables.net/1.10.25/css/dataTables.bootstrap5.min.css" rel="stylesheet">
	<!-- <link href="//cdn.datatables.net/1.10.25/css/jquery.dataTables.min.css" rel="stylesheet"> -->
	<link rel="stylesheet" type="text/css" href="../../css/style.css">

	<style type="text/css">
		td.details-control {
		    background: url('details_open.png') no-repeat center center;
		    cursor: pointer;
		}
		tr.details td.details-control {
		    background: url('details_close.png') no-repeat center center;
		}
		.error { color: red !important; }
		.detalleFotos,.cajaColores{
			padding: 0.25rem; background-color: #fff; border: 1px solid #dee2e6; border-radius: 0.25rem;
    		max-width: 100%; height: auto;			
		}
	</style>

</head>
<body>


<header class="p-3 bg-dark text-white">
    <div class="container">
      <div class="d-flex flex-wrap align-items-center justify-content-center justify-content-lg-start">
        <a href="/" class="d-flex align-items-center mb-2 mb-lg-0 text-white text-decoration-none">
          <svg class="bi me-2" width="40" height="32" role="img" aria-label="Bootstrap"><use xlink:href="#bootstrap"></use></svg>
        </a>

        <ul class="nav col-12 col-lg-auto me-lg-auto mb-2 justify-content-center mb-md-0">
          <li><a href="#" class="nav-link px-2 text-white" data-bs-toggle="modal" data-bs-target="#modal" >Agregar producto</a></li>
          <li><a href="#" class="nav-link px-2 text-white" data-bs-toggle="modal" data-bs-target="#AgregarColeccion">Admin colecciones</a></li>
        </ul>


        <div class="text-end">
          <a href="cerrar.php" class="btn btn-warning">Cerrar Sesión</a>
        </div>
      </div>
    </div>
  </header>






	<section class="container mt-5">
		<div class="row">
			<div class="col-md-12 text-center">
                <table id="productos" class="table" style="width:100%">
                    <thead>
                        <tr>
                            <th>Número de Registro</th>
                            <th>Nombre</th>
                            <th>Composición</th>
                            <th>Colores</th>
                            <th>Medidas</th>
                            <th>Descripción</th>
                            <th>Fotos</th>
                            <th>Colección</th>
                        </tr>
                    </thead>
				</table>
			</div>
		</div>
	</section>



	<!-- MODALS -->

	<div class="modal fade" id="modal" tabindex="-1" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog ">
			<div class="modal-content">
				<div class="modal-header">
					<h2 class="modal-title" id="modalTitle"><strong>AGREGAR PRODUCTO</strong></h2>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<!-- <form id="form" action="setProd.php" method="post" enctype="multipart/form-data"> -->
				<form id="form" action="setProd.php" method="post" enctype="multipart/form-data">
				<div class="modal-body bg-light py-5">
					<div class="container">
						<div class="row justify-content-center">
							<div class="col-md-10 mb-3">
								<label for="nombre" class="form-label"><strong>Nombre</strong></label>
								<input type="text" class="form-control" id="nombre" name="nombre" onBlur="comprobarProducto()" required>
								<span class="estadoUsuario"></span>
							</div>
							<div class="col-md-10 mb-3">
								<label for="formFile" class="form-label"><strong>Fotos del Producto</strong></label>
								<input class="form-control" type="file" id="formFile[]" name="formFile[]" multiple="">
							</div>
							<div class="col-md-10 mb-3">
								<label class="form-label"><strong>Medidas</strong></label>
							</div>
							<div class="col-md-4 mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="45 x 45 cm" name="medida[]">
									<label class="form-check-label"> 45 x 45 cm </label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="55 x 35 cm" name="medida[]">
									<label class="form-check-label"> 55 x 35 cm </label>
								</div>
							</div>
							<div class="col-md-4 mb-3">
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="50 x 50 cm" name="medida[]">
									<label class="form-check-label"> 50 x 50 cm </label>
								</div>
								<div class="form-check">
									<input class="form-check-input" type="checkbox" value="60 x 60 cm" name="medida[]">
									<label class="form-check-label"> 60 x 60 cm </label>
								</div>									
							</div>
							<div class="col-md-10 mb-3">
								<label class="form-label" for="color"><strong>Colores</strong></label>
								<input class="form-control selectColor mb-3" type="color" id="color">
								<input class="form-control losColores" type="hidden" id="losColores" name="losColores">
								<div class="w-100 mb-3 cajaColores"><p class="form-text">Click en el cuadro de color para remover</p></div>
							</div>
							<div class="col-md-10 mb-3">
								<label for="lasColecciones" class="form-label"><strong>Selecciona la Colección</strong></label>
								<select class="form-select" aria-label="Default select" name="lasColecciones" id="lasColecciones">
								<?php 
									if(count($lasColecciones)>0){
										echo count($lasColecciones);
										foreach($lasColecciones as $k){
											echo '<option value="'.$k["id"].','.$k["carpeta"].'">'.$k["nombrecole"].'</option>';
										}
									}
								?>
								</select>
								<span class="estadoActualizar"></span>
							</div>										
							<div class="col-md-10">
								<label class="form-label"><strong>Composición</strong></label>
								<textarea class="form-control" id="composicion" name="composicion" rows="3">Sublimado / 100% Poliéster</textarea>
							</div>
							<div class="col-md-10">
								<label class="form-label"><strong>Descripción</strong></label>
								<textarea class="form-control" id="descripcion" name="descripcion" rows="3">Funda de cojín confeccionada en lino lavado de color liso decorado</textarea>
							</div>

						</div>
					</div>
				</div>
				<div class="modal-footer bg-white">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<button class="btn btn-primary">Guardar</button>
				</div>
	            </form>
			</div>
		</div>
	</div>

        
	<!-- Modal3 -->
	<div class="modal fade" tabindex="2" id="EliminarRegistro" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><strong>CONFIRMA</strong></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<p>Vas a eliminar ... estas seguro de hacerlo?</p>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<button id="confirmado" type="button" class="btn btn-primary">Eliminar</button>
				</div>
			</div>
		</div>
	</div>

	<!-- Modal4 -->
	<div class="modal fade" tabindex="3" id="AgregarColeccion" aria-labelledby="modalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><strong>COLECCIONES</strong></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>
				<div class="modal-body">
					<div class="row">
						<div class="col-md-12">
							<p class="text-muted"> Elige agregar, modificar o eliminar una colección </p>								
						</div>
						<div class="col-md-6 mb-3">
							<label for="nombreColeccion" class="form-label"><strong>Agregar Colección</strong></label>
							<input type="text" class="form-control" id="nombreColeccion" name="nombreColeccion" required>
							<span class="estadoColeccion"></span>
						</div>
						<div class="col-md-12"><hr></div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="LaColeccionAnterior" class="form-label"><strong>Actualizar</strong></label>
							<select class="form-select" aria-label="Default select" name="LaColeccionAnterior" id="LaColeccionAnterior">
							<?php 
								if(count($lasColecciones)>0){
									echo count($lasColecciones);
									foreach($lasColecciones as $k){
										echo '<option value="'.$k["id"].'">'.$k["nombrecole"].'</option>';
									}
								}
							?>
							</select>
							<span class="estadoActualizar"></span>
						</div>
						<div class="col-md-6 mb-3">
							<label for="remplazar" class="form-label"><strong>Remplazar</strong></label>
							<input type="text" class="form-control" id="remplazar" name="remplazar" onBlur="comprobarColeccion()">
							<span class="estadoRemplazo"></span>
						</div>
						<div class="col-md-12"><hr></div>
					</div>
					<div class="row">
						<div class="col-md-6 mb-3">
							<label for="eliminaCole" class="form-label"><strong>Eliminar</strong></label>
							<select class="form-select" aria-label="Default select" name="eliminaCole" id="eliminaCole">
							<?php 
								if(count($lasColecciones)>0){
									echo count($lasColecciones);
									foreach($lasColecciones as $k){
										echo '<option value="'.$k["id"].'">'.$k["nombrecole"].'</option>';
									}
								}
							?>
							</select>
							<span class="estadoEliminar"></span>
						</div>
						<div class="col-md-6 mb-3">
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button id="coleAgr" type="button" class="btn btn-success">Agregar</button>
					<button id="coleAct" type="button" class="btn btn-primary">Actualizar</button>
					<button id="colElim" type="button" class="btn btn-danger">Eliminar</button>
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
				</div>
			</div>
		</div>
	</div>



	<!-- MODAL MODIFICAR -->
	<div class="modal fade" tabindex="4" id="modProd" aria-labelledby="modalLabel" aria-hidden="true">
		<form id="formMod" action="updateProd.php" method="post" enctype="multipart/form-data">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title"><strong>Modificar Producto</strong></h5>
					<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
				</div>

				<div class="modal-body">
					<div class="row justify-content-md-center">
						<div class="col-md-10 mb-3">
							<label for="nombre" class="form-label"><strong>Cambiar el Nombre</strong></label>
							<input type="text" class="form-control" id="n" name="n" onBlur="compruebaProd(n)" required>
							<input type="hidden" id="respaldoNombre" name="respaldoNombre">
							<span class="estadoProd"></span>
						</div>
						<div class="col-md-10 mb-3">
							<label class="form-label"><strong>Cambiar Composición</strong></label>
							<textarea class="form-control" id="compo" name="compo" rows="3"></textarea>
						</div>
						<div class="col-md-10 mb-3">
							<label class="form-label" for="color"><strong>Cambiar los Colores</strong></label>
							<input class="form-control selectColor" type="color" id="colo">
							<input class="form-control respaldoColores" type="hidden" id="respaldoColores" name="respaldoColores">
							<div class="w-100 my-3 boxColor bg-light"> </div>
						</div>
						<div class="col-md-10">
							<label class="form-label"><strong>Cambiar las Medidas</strong></label>
						</div>
						<div class="col-md-4 mb-3 check1">
							<div class="form-check modChecks">
								<input class="form-check-input" type="checkbox" value="45 x 45 cm" name="respaldoMed[]">
								<label class="form-check-label" for="flexCheckDefault"> 45 x 45 cm </label>
							</div>
							<div class="form-check modChecks">
								<input class="form-check-input" type="checkbox" value="55 x 35 cm" name="respaldoMed[]">
								<label class="form-check-label" for="flexCheckChecked"> 55 x 35 cm </label>
							</div>									
						</div>
						<div class="col-md-4 mb-3 check2">
							<div class="form-check modChecks">
								<input class="form-check-input" type="checkbox" value="50 x 50 cm" name="respaldoMed[]">
								<label class="form-check-label" for="flexCheckDefault"> 50 x 50 cm </label>
							</div>
							<div class="form-check modChecks">
								<input class="form-check-input" type="checkbox" value="60 x 60 cm" name="respaldoMed[]">
								<label class="form-check-label" for="flexCheckChecked"> 60 x 60 cm </label>
							</div>									
						</div>
						<div class="col-md-10 mb-3">
							<label class="form-label"><strong>Descripción</strong></label>
							<textarea class="form-control" id="des" name="des" rows="3"></textarea>
						</div>
						<div class="col-md-10 mb-3">
							<label for="respaldoImagenes" class="form-label"><strong>Fotos del Producto</strong></label>
							<input class="form-control" type="file" id="respaldoImagenes" name="respaldoImagenes[]" multiple="" accept="image/*" onchange="previewFiles()" multiple>
							<!-- <input class="form-control" type="file" id="respaldoImagenes[]" name="respaldoImagenes[]" multiple=""> -->
							<input type="hidden" id="imgsEliminadas" name="imgsEliminadas">
							<input type="hidden" id="imgsAComparar" name="imgsAComparar">
						</div>
						<div class="col-md-10 mb-3 detalleFotos bg-light"> </div>
						<div class="piboteImagenes"></div>

						<div class="col-md-10 mb-3">
							<label for="lasColecciones" class="form-label"><strong>Cambiar de Colección</strong></label>
							<select class="form-select" aria-label="Default select" name="respaldoCole" id="respaldoCole">
							<?php 
								if(count($lasColecciones)>0){
									echo count($lasColecciones);
									foreach($lasColecciones as $k){
										echo '<option value="'.$k["id"].','.strtolower($k["carpeta"]).'">'.$k["nombrecole"].'</option>';
									}
								}
							?>
							</select>
							<input type="hidden" id="respCole" name="respCole">
						</div>
						<div class="col-md-10 mb-3 text-center">
							<hr>
							<p class="form-text">Eliminar esté producto</p>
							<button id="EliminarProducto" type="button" class="btn btn-danger">Eliminar</button>
						</div>
					</div>
				</div>
				<div class="modal-footer">
					<button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancelar</button>
					<button type="submit" class="btn btn-primary">Guardar cambios</button>
					<input type="hidden" id="ElId" name="ElId">
				</div>
			</div>
		</div>
		</form>
	</div>

	


	<footer class="container">
		<div class="row">
			<div class="col-md-12"><hr>
				<p class="text-center"><?php echo date("Y");?> AMSALA</p>
			</div>
		</div>
	</footer>


	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
	<!-- JavaScript Bundle with Popper -->
	<!-- JavaScript Bundle with Popper -->
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
	<script src="//cdn.jsdelivr.net/npm/jquery-validation@1.19.3/dist/jquery.validate.js"></script>

    <script src="https://cdn.datatables.net/1.10.25/js/jquery.dataTables.min.js"></script>
    <script src="https://cdn.datatables.net/1.10.25/js/dataTables.bootstrap5.min.js"></script>
	<script type="text/javascript" src="../js/configDataTables.js"></script>
	<script type="text/javascript" src="../js/productos.js"></script>

</body>
</html>

