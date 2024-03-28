<?php

	$acao = 'recuperar';
	require 'tarefa_controller.php';

	/*
	echo '<pre>';
	print_r($tarefas);
	echo '</pre>';
	*/

?>

<html>
	<head>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>App Lista Tarefas</title>

		<link rel="stylesheet" href="css/estilo.css">
		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
		
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
		

		<script>

			function editar(id, txt_tarefa) {

				//criar um form de edição
				let form = document.createElement('form')
				form.action = 'tarefa_controller.php?acao=atualizar'
				form.method = 'post'
				form.className = 'row'

				//criar um input para entrada do texto
				let inputTarefa = document.createElement('input')
				inputTarefa.type = 'text'
				inputTarefa.name = 'tarefa'
				inputTarefa.className = 'col-9 form-control'
				inputTarefa.value = txt_tarefa

				//criar um input hidden para guardar o id da tarefa
				let inputId = document.createElement('input')
				inputId.type = 'hidden'
				inputId.name = 'id'
				inputId.value = id

				//criar um button para envio do form
				let button = document.createElement('button')
				button.type = 'submit'
				button.className = 'col-3 btn btn-info'
				button.innerHTML = 'Atualizar'

				//incluir inputTarefa no form
				form.appendChild(inputTarefa)

				//incluir inputId no form
				form.appendChild(inputId)

				//incluir button no form
				form.appendChild(button)

				//teste
				//console.log(form)

				//selecionar a div tarefa
				let tarefa = document.getElementById('tarefa_'+id)

				//limpar o texto da tarefa para inclusão do form
				tarefa.innerHTML = ''

				//incluir form na página
				tarefa.insertBefore(form, tarefa[0])

			}

			function remover(id) {
				location.href = 'todas_tarefas.php?acao=remover&id='+id;
			}

			function marcarRealizada(id) {
				location.href = 'todas_tarefas.php?acao=marcarRealizada&id='+id;
			}

			//NOVO CODIGO

			function arquivar(id) {
				location.href = 'todas_tarefas.php?acao=arquivar&id='+id;
			}

			//Função que pega o id da tarefa para marcá-la como atrasada
			function atrasada(id){ 
				location.href = 'todas_tarefas.php?acao=atrasada&id='+id;
			}
		</script>

		<!--AJAX-->
		<!-- Tenta puxar os dados do forms, utilizando o status pesquisado -->
		<script language="javascript" type="text/javascript">
			function GetRequestAjax(funcao){
					/**Tenta criar um request**/
					let request = new XMLHttpRequest();
					/**procurar tentar chamar a funcao forms para o URL**/
					var url="todas_tarefas.php?acao=";
					/**Adiciona o request com o status */
					request.open("GET",url+funcao, true);
					request.onreadystatechange = () => {
						if(request.readyState == 4 && request.status == 200){
							//**let dadosJSONText = request.responseText;
							/**let dados = JSON.parse(response);**/
							/**Muda a URL para a função.**/
							history.pushState({},"",url+funcao);
							window.location.reload()
						}
					}
					request.send();
				}
		</script>
	</head>

	<body>
		<nav class="navbar navbar-light bg-light">
			<div class="container">
				<a class="navbar-brand" href="#">
					<img src="img/logo.png" width="30" height="30" class="d-inline-block align-top" alt="">
					App Lista Tarefas
				</a>
			</div>
		</nav>

		<div class="container app">
			<div class="row">
				<div class="col-sm-3 menu">
					<ul class="list-group">
						<li class="list-group-item"><a href="index.php">Tarefas pendentes</a></li>
						<li class="list-group-item"><a href="arquivadas.php">Tarefas arquivadas</a></li>
						<li class="list-group-item"><a href="nova_tarefa.php">Nova tarefa</a></li>
						<li class="list-group-item active"><a href="#">Todas tarefas</a></li>
						
					</ul>
				</div>

				<div class="col-sm-9">
					<div class="container pagina">
						<div class="row">
							<div class="col">
								<h4>Todas tarefas</h4>
								<hr />
									<!--CODIGO NOVO-->
									<!-------------------->
									<div class="d-flex justify-content-between align-items-center">
										<div class="form-group">
											<form>
												<label>Filtro de Status</label>
												<select name="status" onchange="GetRequestAjax(this.value)">
													<option value="recuperar">Todas Tarefas</option>
													<option value="recuperarTarefasPendentes">Tarefas Pendentes</option>
													<option value="recuperarTarefasConcluidas">Tarefas Concluidas</option>
												</select>
											</form>
										</div>

										<div class="form-group">
											<form>
												<label>Filtro de Categoria</label>
												<select name="categoria">
													<option>Todas Tarefas</option>
													<!--For para pegar as opções baseadas no que foi digitado pelo usuário-->
													<?php foreach($tarefas as $indice => $tarefa) { ?>
														<option value="<?=$tarefa->categoriaTarefa?>"><?=$tarefa->categoriaTarefa?></option>
													<?php } ?>
												</select>
											</form>
										</div>
									</div>

									<div class="d-flex justify-content-between align-items-center">
										<div class="form-group">
											<form>
												<label>Filtro de Data</label>
												<select name="data">
													<option>Todas Tarefas</option>
													<!--For para pegar as opções baseadas no que foi digitado pelo usuário-->
													<?php foreach($tarefas as $indice => $tarefa) { ?>
														<option value="<?=$tarefa->data_cadastrado?>"><?=$tarefa->data_cadastrado?></option>
													<?php } ?>	
												</select>
											</form>
										</div>

										<div class="form-group">
											<form>
												<label>Filtro de Prioridade</label>
												<select name="prioridade">
													<option>Todas Tarefas</option>
													<!--For para pegar as opções baseadas no que foi digitado pelo usuário-->
													<?php foreach($tarefas as $indice => $tarefa) { ?>
														<option value="<?=$tarefa->prioridadeTarefa?>"><?=$tarefa->prioridadeTarefa?></option>
													<?php } ?>
												</select>
											</form>
										</div>
									</div>

								<!-------------------->
								<?php foreach($tarefas as $indice => $tarefa) { ?>
									<div class="row m-1 d-flex align-items-center tarefa">
										<div class="col-10 w-100" id="tarefa_<?= $tarefa->id ?>">
										<?php 
												$dataAtual = new DateTime(); //Pega a data atual para comparação

												$dataLimite = new DateTime($tarefa->dataLimite); //Pega a data estipulada pelo usuário
											?>
												<!--If que ve se a data atual é maior que a limite e avisa que a tarefa está atrasada
												Quando o usuário clica OK, muda o status dela para atrasada-->
											<?php if(($dataAtual->format('Y-m-d') > $dataLimite->format('Y-m-d')) && ($tarefa->status == 'pendente')) { ?>
												<div class="alert alert-danger alert-dismissible fade show" role="alert">
													<p class="alert-heading">Você possui tarefas atrasadas!</p>
													<hr>
													<button type="button" class="btn btn-danger btn-sm" data-bs-dismiss="alert" aria-label="Close" onclick="atrasada(<?= $tarefa->id ?>)">OK</button>
												</div>
											<?php } ?>

											<dl>
												<dt><?= $tarefa->tarefa ?>(<?= $tarefa->status ?>)</dt>
													<dd>Data de criação: <?= $tarefa->data_cadastrado ?></dd>
													<dd>Data Limite: <?= $tarefa->dataLimite ?></dd>
													<dd>Prioridade: <?= $tarefa->prioridadeTarefa ?></dd>
													<dd>Categoria: <?= $tarefa->categoriaTarefa ?></dd>
											</dl>
										      

										</div>
										<div class="col-2 mt-2 d-flex justify-content-between">
											<i class="fas fa-trash-alt fa-lg text-danger" onclick="remover(<?= $tarefa->id ?>)"></i>
											
											<?php if($tarefa->status == 'pendente' || $tarefa->status == 'Em atraso') { ?>
												<i class="fas fa-edit fa-lg text-info" onclick="editar(<?= $tarefa->id ?>, '<?= $tarefa->tarefa ?>')"></i>
												<i class="fas fa-check-square fa-lg text-success" onclick="marcarRealizada(<?= $tarefa->id ?>)"></i>
											<?php } ?>
											<!---CODIGO NOVO --->
											<!-- adiciona o botão para arquivar as tarefas, quando ela estiver concluida-->
											<?php if($tarefa->status == 'realizado') { ?>
												<i class="fas fa-folder fa-lg text-warning" onclick="arquivar(<?= $tarefa->id ?>)"></i>
											<?php } ?>
									</div>

								<?php } ?>
								
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>
