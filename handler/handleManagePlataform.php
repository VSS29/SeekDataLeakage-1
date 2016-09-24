<?php
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

function getIDbyRuleName($name){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['Rule_name'] == $name)){
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

function startRule($id){

	$cursor = connectDB_Rules()->findOne(array('_id' =>  new MongoId($id)));
	if ($cursor == true){
		connectDB_Rules()->update(array('_id'=> new MongoId($id)),array('$set'=>array('isRunning'=>1)));
	}

}


function deleteRule($idd){
	$res = connectDB_Rules()->remove(array('_id' => new MongoId($idd)));
	if ($res['n'] == 1){
		return true;
	}
	return false;
}

function getRuleNameById($id){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['_id'] == $id)){
			return $doc['Rule_name'];
		}
	}
}


function getRelevRule($id){

	$cursor = connectDB_Rules()->find();
	foreach ($cursor as $doc) {
		if(($doc['_id'] == $id)){
			return $doc['Relevo'];
		}
	}
}

function stopRule($id){
	$cursor = connectDB_Rules()->findOne(array('_id' =>  new MongoId($id)));
	if ($cursor == true){
		connectDB_Rules()->update(array('_id'=>new MongoId($id)),array('$set'=>array('isRunning'=>0)));
	}
}

?>