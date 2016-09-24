<?php
function getDLFound(){
	$get = connectDB_DLFound()->find();
	foreach ($get as $doc) {
		if($doc['email'] == $_SESSION['email']){
			return $doc;
		}
	}
}




function setDefaultDLFound(){
	$coll = connectDB_DLFound();
	date_default_timezone_set('Europe/Lisbon');
	$coll->insert(array( 'email' => $_SESSION['email'],'DataFound'=>"2015-09-15 18:03:21", 'Plataforma'=>"Pastebin",'URL'=>'http://pastebin.com/yey','Termo'=>"yey", 'NomeRegra'=>'Teste', 'Num'=>0,'viewed'=>0));
	$coll->insert(array( 'email' => $_SESSION['email'],'DataFound'=>"2015-09-15 17:03:21", 'Plataforma'=>"Pastebin",'URL'=>'http://pastebin.com/yey','Termo'=>"ney", 'NomeRegra'=>'Teste2', 'Num'=>3,'viewed'=>0));
	$coll->insert(array( 'email' => $_SESSION['email'],'DataFound'=>date_format(new DateTime(), 'Y-m-d H:i:s'), 'Plataforma'=>"Pastebin",'URL'=>'http://pastebin.com/yey','Termo'=>"shay", 'NomeRegra'=>'Teste3', 'Num'=>4,'viewed'=>0));

}


function deleteDLFound($name){
	$coll = connectDB_DLFound();
	$coll->remove(array('NomeRegra' => $name));
	print_r($coll);
}

function viewDLFound($id){
	$coll = connectDB_DLFound();

	$cursor = $coll->findOne(array('_id' => new MongoId($id)));
	if ($cursor == true){
		$coll->update(array('_id'=> new MongoId($id)),array('$set'=>array('viewed'=>1)));

	}
}

function viewALL(){
	$get = connectDB_DLFound()->find();
	foreach ($get as $doc) {
		if($doc['email'] == $_SESSION['email']){
			$e = connectDB_DLFound()->update(array('Termo'=> $doc['Termo'], 'email'=>$doc['email'], 'URL'=>$doc['URL']),array('$set'=>array('viewed'=>1)));
		}
	}
}


?>