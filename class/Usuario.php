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
    }

    //Busca um usuário pelo ID
    public function loadById($id){
    	$sql = new Sql();
    	$results = $sql->select("SELECT * FROM tb_usuarios WHERE idusuario= :ID", array(
    		":ID"=>$id));
    	if (count($results) > 0) {
    		$this->setData($results[0]);
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
    		$this->setData($results[0]);    		
    	}else{
    		throw new Exception("Usuário e/ou Senha inválidos");    		
    	}
    }

    public function setData($data){
    	//Alimentando a classe
		$this->setIdusuario($data['idusuario']);
		$this->setDeslogin($data['deslogin']);
		$this->setDessenha($data['dessenha']);
		$this->setDtcadastro(new DateTime($data['dtcadastro']));
    }

    public function insert(){

    	$sql = new Sql();

    	//Executando uma store procedure
    	$results = $sql->select("CALL sp_usuarios_insert(:LOGIN, :PASSWORD)", array(
    		":LOGIN"=>$this->getDeslogin(),
    		":PASSWORD"=>$this->getDessenha()
    	));

    	if (count($results) > 0) {
    		$this->setData($results[0]);    		
    	}
    }

    //método construtor para passar parâmetros e não chamar os sets
    public function __construct($login = "", $password = ""){
    	$this->setDeslogin($login);
    	$this->setDessenha($password);
    }

    public function update($login, $password){
    	$this->setDeslogin($login);
    	$this->setDessenha($password);
    	$sql = new Sql();

    	$sql->query("UPDATE tb_usuarios SET deslogin = :LOGIN, dessenha = :PASSWORD WHERE idusuario = :ID", array(
    		"LOGIN" =>$this->getDeslogin(),
    		"PASSWORD" =>$this->getDessenha(),
    		"ID" => $this->getIdusuario()
    	));
    }

    //Traz os dados formatados de apenas um usuário
    public function __toString(){
    	return json_encode(array(
    		"idusuario"=>$this->getIdusuario(),
    		"deslogin"=>$this->getDeslogin(),
    		"dessenha"=>$this->getDessenha(),
    		"dtcadastro"=>$this->getDtcadastro()
    	));
    }
}
 ?>
