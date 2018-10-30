<?php

	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');
	header('Access-Control-Allow-Methods: PUT');
	header('Access-Control-Allow-Header: Access-Control-Allow-Header,Content-Type,Access-Control-Allow-Methods, Authorization, X-Requested-With');


	include_once '../../config/Database.php';
	include_once '../../models/Peminjaman.php';


	$database = new Database();
	$db = $database->connect();

	$peminjaman = new Peminjaman($db);

	$data = json_decode(file_get_contents("php://input"));

	$peminjaman->id              = $data->id;

	if($peminjaman->delete()){
		echo json_encode(
			array('message' => 'Log Berhasil di Hapus')
		);
	} else {
		echo json_encode(
			array('message' => 'Log Tidak Behasil di Hapus')
		);
	}

?>	