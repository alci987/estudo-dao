<?php 

require_once "config.php";

$sql = new Sql();
$usuarios = $sql->select("select * from tb_usuarios");
echo json_encode($usuarios);
echo "<hr>";

$root = new Usuario();
$root->loadById(29);
echo $root->getDtcadastro()->format("d/m/Y H:i:s");
echo $root;

echo "<hr>";

$lista = Usuario::getList();//Esse é um método estático
echo json_encode($lista);

echo "<hr>";

$search = Usuario::search("m");
echo json_encode($search);

echo "<hr>";

$root->login("Ana Mirian","1234");
echo $root;

echo "<hr>";

//$aluno = new Usuario("relógio", "picaxu");


//$aluno->insert();

//echo $aluno;
//

$root->loadById(30);
$root->update("mexi", "mexerica");

 ?>