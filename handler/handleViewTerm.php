<?php
function getDLFound($id){
	$get = connectDB_DLFound()->find(array('_id' => new MongoId($id)));
	foreach ($get as $doc) {
//		if($doc['_id'] == $id){
			return $doc;
//		}
	}
}



function setFalsePositivYes($id){
	$coll = connectDB_DLFound();
	$cursor = $coll->findOne(array('_id' => new MongoId($id)));
	if ($cursor == true){
		$coll->update(array('_id'=>new MongoId($id)),array('$set'=>array('falsePositiv'=>1)));
	}
}

function setFalsePositivNo($id){
	$coll = connectDB_DLFound();
	$cursor = $coll->findOne(array('_id' => new MongoId($id)));
	if ($cursor == true){
		$coll->update(array('_id'=>new MongoId($id)),array('$set'=>array('falsePositiv'=>0)));
	}
}

function viewTerm($id){
	$e = connectDB_DLFound()->update(array('_id'=> new MongoId($id)),array('$set'=>array('viewed'=>1)));
}

?>