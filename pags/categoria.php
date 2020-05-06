<?php
	include('../insert/topo.php');
	include('../insert/menu.php');
	include('../insert/corpo.php');
?>
<div class="lista_dados">
	<div class="top_lista_dados">
		<span>Categorias</span>
		<div id="cadastro_dados">Cadastrar</div>
	</div>
	<table class="table_dados">
		<thead>
			<tr>
				<th>Categoria</th>
				<th class="dados_situacao">Situação</th>
				<th class="dados_acao">Opções</th>
			</tr>
		</thead>
		<tbody>
			<?php
		if($fetch_cat > 0){
			do{
				if(isset($_POST['inativar_'.$fetch_cat['id']])):
					if($_POST['inativar_'.$fetch_cat['id']]=="Inativar"){
						$situacao = "2";
					}else{
						$situacao = "1";
					};
				$sql_situacao = "UPDATE `categorias` SET `status`=:situacao_user WHERE id='".$fetch_cat['id']."'";
				$situacao_dados = $PDO->prepare($sql_situacao);
				$situacao_dados->bindValue(":situacao_user", $situacao);
				$situacao_dados->execute();
				echo "<script>alert('Categoria alterado com sucesso!')</script>";
				echo "<script>location.href='categoria.php';</script>";
				endif;
			?>
				<tr>
					<th><?php echo $fetch_cat['categorias'];?></th>
					<th class="dados_situacao"><?php if($fetch_cat['status']=="1"){echo "Ativo";}else{echo "Inativo";};?></th>
					<th class="dados_acao">
						<div class="action">
							<div class="menu_action_baixo"></div>
							<span>Ações</span>
						</div>
						<div class="acao_menu">
							<form method="post">
								<input type="submit" name="inativar_<?=$fetch_cat['id'];?>" value="<?php if($fetch_cat['status']=='1'){echo 'Inativar';}else{echo 'Ativar';};?>">
							</form>
						</div>
					</th>
				</tr>
			<?php
			}while($fetch_cat = $exibir_cat->fetch(PDO::FETCH_ASSOC));
		}else{
			echo "<tr><th colspan='3' style='text-align: center;'>Não há nenhum Atendente/Administrador cadastrado, cadestre o primeiro!</td></tr>";
		}
			?>
		</tbody>
	</table>
</div>
<div class="modal">
	<div class="title_modal">
		<span>Cadastro de Categoria</span>
		<div class="fechar_modal">X</div>
	</div>
	<form method="post" class="cadastro_modal">
		<input type="text" name="categoria_dados" placeholder="Categoria">
		<select name="situacao_dados">
			<option value="1">Ativo</option>
			<option value="2">Inativo</option>
		</select>
		<input class="button" type="submit" name="cad_categoria" value="Cadastrar">
	</form>
</div>
<?php
	include('../insert/rodape.php');
?>