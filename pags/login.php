<?php
//VERIFICANDO SE FOI APERTADO O BOTAO DE LOGAR
if(isset($_POST['logar'])):
//BUSCA AS VARIAVEIS DIGITADAS
$login = $_POST['login'];
$senha = $_POST['senha'];
//CONSULTA NO BANCO DE DADOS PELO USUARIO E SENHA DIGITADOS
$sql = "SELECT * FROM users WHERE login = '".$login."' AND password = '". $senha . "'";
//VERIFICA SE O USUARIO EXISTE E RETORNA A QUANTIDADE
$resultado = $PDO->prepare($sql);
$resultado->execute();
//RETORNA A QUANTIDADE DE CONTAS
$contaresultado = $resultado->fetch(PDO::FETCH_ASSOC);
//VERIFICA E PEGA O USUARIO E SENHA PARA USARMOS NA PROXIMA PAGINA E PULA A PAGINA PARA O LOCAL PRINCIPAL
if ($login === $contaresultado['login'] && $senha === $contaresultado['password'] && $contaresultado['situacao'] === '1'):
	$_SESSION['login'] = $login;
	$_SESSION['senha'] = $senha;
	header('location: painel/index.php');
else:
	echo "<script>alert('Nome de usuário ou senha está incorreto ou você não tem permissões!')</script>";
endif;
endif;
?>