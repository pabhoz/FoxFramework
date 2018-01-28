<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Users Services</title>
	<link rel="stylesheet" href="<?php echo _WSD; ?>css/wsd.css">
</head>
<body>
	<div class="title">Users Services - <?php echo $url; ?></div>
	<div>All default services means it will invoke {requestMethod} index, so any controller must be defiend. Los servicios están configurados para trabajar por orden de parametros, lo que traduce que usted no deberá preocuparse por el nombre del parametro, en su lugar deberá preocuparse por el orden en que los envía, por ejemplo, el servicio que requiera num1 y num2 puede recibir como paramtros por método GET a=1&b=2 y éste asumirá que a es num1 y b num2</div>

	<dl>
		<dt class="title">Get</dt>
		<dd>
			<ul>
				<li>
					<div class="title">Service:</div>
					<?php echo $url; ?>?key=PROVIDED_KEY<br>
					<?php echo $url; ?>?key=PROVIDED_KEY&id=1
				</li>
				<li>
					<div class="title">Description:</div>
				 Retorna todos los usuarios si no se provee ningún id específico. Si se provee un id, se retornará el usuario solicitado.
				 </li>
				<li><div class="title">Inputs:</div> 
					<ul>
						<li>int - id</li>
					</ul>
				</li>
				<li><div class="title">Outputs:</div>
					<ul>
						<li>{ <br> [JSON - Users] <br>}</li>
					</ul>
				</li>
			</ul>
		</dd>

		<dd>
			<ul>
				<li>
					<div class="title">Service:</div>
					<?php echo $url; ?>checkUser/?key=PROVIDED_KEY&username=jdoe&password=1234
				</li>
				<li>
					<div class="title">Description:</div>
				 Retorna si el usuario existe en la base de datos y su password coincide con el que se envió.
				 </li>
				<li><div class="title">Inputs:</div> 
					<ul>
						<li>String - username</li>
						<li>String - password</li>
					</ul>
				</li>
				<li><div class="title">Outputs:</div>
					<ul>
						<li>{ <br>error: 1 si hay error 0 si no,<br>msg: mensaje del servicio,<br>status: 1 (usuario válido) / 0 (usuario invalido) <br>}</li>
					</ul>
				</li>
			</ul>
		</dd>

		<dd>
			<ul>
				<li>
					<div class="title">Service:</div>
					<?php echo $url; ?>newPassword/?key=PROVIDED_KEY&correo=jdoe@example.com
				</li>
				<li>
					<div class="title">Description:</div>
				 Envía al usuario un correo electrónico con el PIN para cambiar la contraseña.
				 </li>
				<li><div class="title">Inputs:</div> 
					<ul>
						<li>String - correo</li>
					</ul>
				</li>
				<li><div class="title">Outputs:</div>
					<ul>
						<li>{ <br>error: 1 si hay error 0 si no,<br>msg: mensaje del servicio <br>}</li>
					</ul>
				</li>
			</ul>
		</dd>

		<dd>
			<ul>
				<li>
					<div class="title">Service:</div>
					<?php echo $url; ?>validatePin/?key=PROVIDED_KEY&correo=jdoe@example.com&pin=1234
				</li>
				<li>
					<div class="title">Description:</div>
				 Verifica si el PIN es válido para ese usuario. El pin es enviado por email al usuario cuando este solicita un cambio de contraseña, con el PIN correcto el usuario podrá acceder a la edición de contraseña en el app.
				 </li>
				<li><div class="title">Inputs:</div> 
					<ul>
						<li>String - correo</li>
						<li>String - pin</li>
					</ul>
				</li>
				<li><div class="title">Outputs:</div>
					<ul>
						<li>{ <br>error: 1 si hay error 0 si no,<br>msg: mensaje del servicio,<br>status: 1 (usuario válido) / 0 (usuario invalido) <br>}</li>
					</ul>
				</li>
			</ul>
		</dd>


		<dt class="title">Post</dt>
		<dd>
			<ul>
				<li>
					<div class="title">Service:</div>
					<?php echo $url; ?>?key=PROVIDED_KEY
				</li>
				<li>
					<div class="title">Description:</div>
					Crea un nuevo usuario si la información provista es adecuada.
				 </li>
				<li><div class="title">Inputs:</div> 
					<ul>
						<li>int - id</li>
						<li>String - username</li>
						<li>String - correo</li>
						<li>String - password</li>
						<li>String - nombre</li>
						<li>int - sexo</li>
						<li>int - experiencia</li>
						<li>String - foto_perfil</li>
					</ul>
				</li>
				<li><div class="title">Outputs:</div>
					<ul>
						<li>{ <br>error: 1 si hay error 0 si no,<br>msg: mensaje del servicio,<br>user: JSON - Usuario<br>}</li>
					</ul>
				</li>
			</ul>
		</dd>

		<dt class="title">Put</dt>
		<dd>
			<ul>
				<li>
					<div class="title">Service:</div>
					<?php echo $url; ?>?key=PROVIDED_KEY
				</li>
				<li>
					<div class="title">Description:</div>
					Actualiza un usuario en base al id provisto dentro de los parametros PUT y los parametros que se quieran actualizar del mismo. (no enviar el id por URL)
				 </li>
				<li><div class="title">Inputs:</div> 
					<ul>
						<li>int - id</li>
						<li>String - username</li>
						<li>String - correo</li>
						<li>String - password</li>
						<li>String - nombre</li>
						<li>int - sexo</li>
						<li>int - experiencia</li>
						<li>String - foto_perfil</li>
					</ul>
				</li>
				<li><div class="title">Outputs:</div>
					<ul>
						<li>{ <br>error: 1 si hay error 0 si no,<br>msg: mensaje del servicio,<br>user: JSON - Usuario<br>}</li>
					</ul>
				</li>
			</ul>
		</dd>

		<dt class="title">Delete</dt>
		<dd>
			<ul>
				<li>
					<div class="title">Service:</div>
					<?php echo $url; ?>?key=PROVIDED_KEY
				</li>
				<li>
					<div class="title">Description:</div>
					Elimina un usuario en base al id provisto dentro de los parametros PUT (no enviar el id por URL)
				 </li>
				<li><div class="title">Inputs:</div> 
					<ul>
						<li>int - id</li>
					</ul>
				</li>
				<li><div class="title">Outputs:</div>
					<ul>
						<li>{ <br>error: 1 si hay error 0 si no,<br>msg: mensaje del servicio,<br>user: JSON - Usuario<br>}</li>
					</ul>
				</li>
			</ul>
		</dd>
	</dl>
</body>
</html>