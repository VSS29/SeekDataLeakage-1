<?php


function checkUniqueRuleName($RuleName){
	$collectio = connectDB_Rules();
	$cursor = $collectio->findOne(array('email' => $_SESSION["email"], 'Rule_name'=>$RuleName));
	return $cursor;
}


function isRunning($id){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['_id'] == $id)){
			if ($doc['isRunning'] == 1){
				return true;
			}
		}
	}
	return false;
}

function getIDbyRuleName($name,$email){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['Rule_name'] == $name && $doc['email'] == $email)){
			return $doc['_id'];
		}
	}
}

function getUserSpaceByID($id){
	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['_id'] == $id)){
			return $doc['email'];
		}
	}
}



function doesRuleExist($name){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['Rule_name'] == $name)){
			return true;
		}
	}
	return false;
}

function startRule($id,$email){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['email'] == $email) && $doc['_id']==$id){
			connectDB_Rules()->update(array('_id'=> new MongoId($id)),array('$set'=>array('isRunning'=>1)));		}
	}
	
	
// 	$cursor = connectDB_Rules()->findOne(array('_id' =>  new MongoId($id)));
// 	if ($cursor == true){
// 		connectDB_Rules()->update(array('_id'=> new MongoId($id)),array('$set'=>array('isRunning'=>1)));
// 	}

}

function getRelevRule($id){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['_id'] == $id)){
			return $doc['Relevo'];
		}
	}
}



function deleteRule($idd,$email){
	
	
	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['email'] == $email) && $doc['_id']==$idd){
			$res = connectDB_Rules()->remove(array('_id' => new MongoId($idd)));
				if ($res['n'] == 1){
					return true;
				}
				return false;
		}
	}
	
// 	$res = connectDB_Rules()->remove(array('_id' => new MongoId($idd)));
// 	if ($res['n'] == 1){
// 		return true;
// 	}
// 	return false;
}

function getRuleNameById($id){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['_id'] == $id)){
			return $doc['Rule_name'];
		}
	}
}




function stopRule($id,$email){
	
	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['email'] == $email) && $doc['_id']==$id){
			connectDB_Rules()->update(array('_id'=>new MongoId($id)),array('$set'=>array('isRunning'=>0, 'emailed'=>0)));
		}
	}
	
// 	$cursor = connectDB_Rules()->findOne(array('_id' =>  new MongoId($id)));
// 	if ($cursor == true){
// 		connectDB_Rules()->update(array('_id'=>new MongoId($id)),array('$set'=>array('isRunning'=>0, 'emailed'=>0)));
// 	}
}
?>