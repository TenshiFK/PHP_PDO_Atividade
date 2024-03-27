<?php


//CRUD
class TarefaService {

	private $conexao;
	private $tarefa;

	public function __construct(Conexao $conexao, Tarefa $tarefa) {
		$this->conexao = $conexao->conectar();
		$this->tarefa = $tarefa;
	}

	public function inserir() { //create
		$query = 'insert into tb_tarefas(tarefa, dataLimite, prioridadeTarefa, categoriaTarefa) values(:tarefa, :dataLimite, :prioridadeTarefa, :categoriaTarefa)';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->bindValue(':dataLimite', $this->tarefa->__get('dataLimite'));
		$stmt->bindValue(':prioridadeTarefa', $this->tarefa->__get('prioridadeTarefa'));
		$stmt->bindValue(':categoriaTarefa', $this->tarefa->__get('categoriaTarefa'));
		$stmt->execute();
	}

	public function recuperar() { //read
		$query = '
			select 
				t.id, s.status, t.tarefa, t.data_cadastrado, t.dataLimite, t.prioridadeTarefa, t.categoriaTarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}

	public function atualizar() { //update

		$query = "update tb_tarefas set tarefa = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('tarefa'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function remover() { //delete

		$query = 'delete from tb_tarefas where id = :id';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id', $this->tarefa->__get('id'));
		$stmt->execute();
	}

	public function marcarRealizada() { //update

		$query = "update tb_tarefas set id_status = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id_status'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function recuperarTarefasPendentes() {
		$query = '
			select 
				t.id, s.status, t.tarefa, t.data_cadastrado, t.dataLimite, t.prioridadeTarefa, t.categoriaTarefa
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where
				t.id_status = :id_status
				t.tarefa = :tarefa
				t.dataLimite = :dataLimite
				t.prioridadeTarefa = :prioridadeTarefa
				t.categoriaTarefa = :categoriaTarefa
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
		$stmt->bindValue(':tarefa', $this->tarefa->__get('tarefa'));
		$stmt->bindValue(':dataLimite', $this->tarefa->__get('dataLimite'));
		$stmt->bindValue(':prioridadeTarefa', $this->tarefa->__get('prioridadeTarefa'));
		$stmt->bindValue(':categoriaTarefa', $this->tarefa->__get('categoriaTarefa'));
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}


	//NOVO CODIGO
	//Função arquivar, arquiva APENAS tarefas concluidas.
	public function arquivar(){
		$query = "update tb_tarefas set id_status = ? where id = ?";
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(1, $this->tarefa->__get('id_status'));
		$stmt->bindValue(2, $this->tarefa->__get('id'));
		return $stmt->execute(); 
	}

	public function recuperarTarefasArquivadas() {
		$query = '
			select 
				t.id, s.status, t.tarefa 
			from 
				tb_tarefas as t
				left join tb_status as s on (t.id_status = s.id)
			where
				t.id_status = :id_status
		';
		$stmt = $this->conexao->prepare($query);
		$stmt->bindValue(':id_status', $this->tarefa->__get('id_status'));
		$stmt->execute();
		return $stmt->fetchAll(PDO::FETCH_OBJ);
	}
}

?>