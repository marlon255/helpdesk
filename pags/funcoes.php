<?php
	//Procurando o usuario logado pelo Login
	$sql_selecionar_usuario = "SELECT * FROM `users` WHERE `login` = '".$_SESSION['login']."'";
	$exibir_usuario = $PDO->prepare($sql_selecionar_usuario);
	$exibir_usuario->execute();
	$fetch_usuario = $exibir_usuario->fetch(PDO::FETCH_ASSOC);


	//Procurando todos os Clientes cadastrados.
	$sql_selecionar_cliente = "SELECT * FROM `users` WHERE `nivel` = '3' ORDER BY `situacao` ASC, `id` ASC";
	$exibir_cliente = $PDO->prepare($sql_selecionar_cliente);
	$exibir_cliente->execute();
	$fetch_cliente = $exibir_cliente->fetch(PDO::FETCH_ASSOC);

	//Procurando todos os Clientes cadastrados.
	$sql_selecionar_user = "SELECT * FROM `users` WHERE `nivel` = '2' OR `nivel` = '1' ORDER BY `situacao` ASC, `id` ASC";
	$exibir_user = $PDO->prepare($sql_selecionar_user);
	$exibir_user->execute();
	$fetch_user = $exibir_user->fetch(PDO::FETCH_ASSOC);

	//Procurando todos as Categorias.
	$sql_selecionar_cat = "SELECT * FROM `categorias` ORDER BY `status` ASC, `id` ASC";
	$exibir_cat = $PDO->prepare($sql_selecionar_cat);
	$exibir_cat->execute();
	$fetch_cat = $exibir_cat->fetch(PDO::FETCH_ASSOC);



	//Função para Cadastrar novo Cliente
	if(isset($_POST['cad_cliente_button'])){
		$login = $_POST['cad_cliente_login'];
		$senha = $_POST['cad_cliente_senha'];
		$name = $_POST['cad_cliente_name'];
		$telefone = $_POST['cad_cliente_tel'];
		$nivel = "3";
		$data_criacao = date('Y-m-d');
		$usuario_online = $_SESSION['login'];
		$situacao = $_POST['cad_cliente_act'];

		if(empty($login) || empty($senha) || empty($name) || empty($telefone)){
			echo "<script>alert('Faltou digitar um campo!')</script>";
		}else{
			$sql_cadastro = "INSERT INTO `users`(`login`, `password`, `name`, `telefone`, `nivel`, `date_created`, `user_created`, `situacao`) VALUES (:login, :senha, :nome, :telefone, :nivel, :data, :usuario_creador, :situacao)";
			$cadastro = $PDO->prepare($sql_cadastro);
			$cadastro->bindValue(":login", $login);
			$cadastro->bindValue(":senha", $senha);
			$cadastro->bindValue(":nome", $name);
			$cadastro->bindValue(":telefone", $telefone);
			$cadastro->bindValue(":nivel", $nivel);
			$cadastro->bindValue(":data", $data_criacao);
			$cadastro->bindValue(":usuario_creador", $usuario_online);
			$cadastro->bindValue(":situacao", $situacao);

			//Validando se há usuário repetido
			$validar = $PDO->prepare("SELECT * FROM users WHERE login = ?");
			$validar->execute(array($login));
			if($validar->rowCount() == 0){
				$cadastro->execute();
				echo "<script>alert('Cadastro realizado com sucesso!');</script>";
				echo "<script>location.href='cliente.php';</script>";
			}else{
				echo "<script>alert('Cadastro duplicado, tente novamente com outro usuário.');</script>";
			};
		};
	};

	//Função para Cadastrar Usuário sendo ele Administrador ou Atendente
	if(isset($_POST['cad_user_button'])){
		$login = $_POST['cad_user_login'];
		$senha = $_POST['cad_user_senha'];
		$name = $_POST['cad_user_name'];
		$telefone = $_POST['cad_user_tel'];
		$nivel = $_POST['cad_user_nivel'];
		$data_criacao = date('Y-m-d');
		$usuario_online = $_SESSION['login'];
		$situacao = $_POST['cad_user_act'];

		if(empty($login) || empty($senha) || empty($name) || empty($telefone)){
			echo "<script>alert('Faltou digitar um campo!')</script>";
		}else{
			$sql_cadastro = "INSERT INTO `users`(`login`, `password`, `name`, `telefone`, `nivel`, `date_created`, `user_created`, `situacao`) VALUES (:login, :senha, :nome, :telefone, :nivel, :data, :usuario_creador, :situacao)";
			$cadastro = $PDO->prepare($sql_cadastro);
			$cadastro->bindValue(":login", $login);
			$cadastro->bindValue(":senha", $senha);
			$cadastro->bindValue(":nome", $name);
			$cadastro->bindValue(":telefone", $telefone);
			$cadastro->bindValue(":nivel", $nivel);
			$cadastro->bindValue(":data", $data_criacao);
			$cadastro->bindValue(":usuario_creador", $usuario_online);
			$cadastro->bindValue(":situacao", $situacao);

			//Validando se há usuário repetido
			$validar = $PDO->prepare("SELECT * FROM users WHERE login = ?");
			$validar->execute(array($login));
			if($validar->rowCount() == 0){
				$cadastro->execute();
				echo "<script>alert('Cadastro realizado com sucesso!');</script>";
				echo "<script>location.href='user_privi.php';</script>";
			}else{
				echo "<script>alert('Cadastro duplicado, tente novamente com outro usuário.');</script>";
			};
		};
	};

	//Função para cadastrar categorias
	if(isset($_POST['cad_categoria'])){
	$categoria = $_POST['categoria_dados'];
	$status = $_POST['situacao_dados'];
	$data_criacao = date('Y-m-d');
	$usuario_online = $_SESSION['login'];

	if(empty($categoria)){
		echo "<script>alert('Campo vazio!')</script>";
	}else{
		$sql_cadastro = "INSERT INTO `categorias`(`categorias`, `status`, `data_criacao`, `user_criacao`) VALUES (:categoria, :situacao, :data, :user)";
		$cadastro = $PDO->prepare($sql_cadastro);
		$cadastro->bindValue(":categoria", $categoria);
		$cadastro->bindValue(":situacao", $status);
		$cadastro->bindValue(":data", $data_criacao);
		$cadastro->bindValue(":user", $usuario_online);

		//Validando categorias
		$validar = $PDO->prepare("SELECT * FROM `categorias` WHERE `categorias` = ?");
		$validar->execute(array($categoria));
		if($validar->rowCount() == 0){
			$cadastro->execute();
			echo "<script>alert('Cadastro realizado com sucesso!');</script>";
			echo "<script>location.href='categoria.php';</script>";
		}else{
			echo "<script>alert('Cadastro duplicado, tente novamente com outro usuário.');</script>";
		};
	}
};
?>