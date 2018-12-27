<?php 
class Usuario{
	private $idusuario;
	private $deslogin;
	private $dessenha;
	private $dtcadastro;

    /**
     * @return mixed
     */
    public function getIdusuario()
    {
        return $this->idusuario;
    }

    /**
     * @param mixed $idusuario
     *
     * @return self
     */
    public function setIdusuario($idusuario)
    {
        $this->idusuario = $idusuario;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDeslogin()
    {
        return $this->deslogin;
    }

    /**
     * @param mixed $deslogin
     *
     * @return self
     */
    public function setDeslogin($deslogin)
    {
        $this->deslogin = $deslogin;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDessenha()
    {
        return $this->dessenha;
    }

    /**
     * @param mixed $dessenha
     *
     * @return self
     */
    public function setDessenha($dessenha)
    {
        $this->dessenha = $dessenha;

        return $this;
    }

    /**
     * @return mixed
     */
    public function getDtcadastro()
    {
        return $this->dtcadastro;
    }

    /**
     * @param mixed $dtcadastro
     *
     * @return self
     */
    public function setDtcadastro($dtcadastro)
    {
        $this->dtcadastro = $dtcadastro;

        return $this;
    }

    //Busca um usuário pelo ID
    public function loadById($id){
    	$sql = new Sql();
    	$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario= :ID", array(
    		":ID"=>$id));
    	if (count($results) > 0) {
    		$row = $results[0];
    		//Alimentando a classe
    		$this->setIdusuario($row['idusuario']);
    		$this->setDeslogin($row['deslogin']);
    		$this->setDessenha($row['dessenha']);
    		$this->setDtcadastro(new DateTime($row['dtucadastro']));
    	}
    }

    //Traz todos os usuários do banco
    public static function getList(){
    	$sql = new Sql();

    	return $sql->select("SELECT * FROM tb_usuarios ORDER BY deslogin");
    }

    //traz os usuarios baseados em uma pesquisa
    public static function search($login){
    	$sql = new Sql();

    	return $sql->select("SELECT * FROM tb_usuarios where deslogin like :SEARCH ORDER BY deslogin", array(
    		":SEARCH"=> "%" . $login . "%"
    	));

    }

    //Verifica se o usuario existe no bando de dados
    public function login($login, $password){
    	$sql = new Sql();
    	$results = $sql->select("SELECT * FROM tb_usuarios WHERE deslogin= :LOGIN AND dessenha= :PASSWORD", array(
    		":LOGIN"=>$login,
    		"PASSWORD"=>$password
    	));

    	if (count($results) > 0) {
    		$row = $results[0];
    		//Alimentando a classe
    		$this->setIdusuario($row['idusuario']);
    		$this->setDeslogin($row['deslogin']);
    		$this->setDessenha($row['dessenha']);
    		$this->setDtcadastro(new DateTime($row['dtucadastro']));
    	}else{
    		throw new Exception("Usuário e/ou Senha inválidos");    		
    	}
    }

    //Traz os dados formatados de apenas um usuário
    public function __toString(){
    	return json_encode(array(
    		"idusuario"=>$this->getIdusuario(),
    		"deslogin"=>$this->getDeslogin(),
    		"dessenha"=>$this->getDessenha(),
    		"dtcadastro"=>$this->getDtcadastro()->format("d/m/Y H:i:s")
    	));
    }
}
 ?>
