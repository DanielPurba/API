<?php

	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/Peminjaman.php';


	$database = new Database();
	$db = $database->connect();

	$peminjaman = new Peminjaman($db);

	$result = $peminjaman->read();

	$num = $result->rowCount();

	if($num > 0){

		$peminjaman_arr = array();
		$peminjaman_arr['data'] = array();

		while($row = $result->fetch(PDO::FETCH_ASSOC)){
			extract($row);

			$peminjaman_item = array(
				'id' => $id,
				'nama_buku' => $nama_buku,
				'nama_peminjam' => $nama_peminjam,
				'tanggal_pinjam' => $tanggal_pinjam,
				'tanggal_kembali' => $tanggal_kembali
			);

			array_push($peminjaman_arr['data'],$peminjaman_item);
		}

		echo json_encode($peminjaman_arr);

	} else {

		echo json_encode(
		array('message' => 'Tidak ada Peminjaman')	
		);
	}
	