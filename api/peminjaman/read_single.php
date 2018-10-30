<?php

	header('Access-Control-Allow-Origin: *');
	header('Content-Type: application/json');

	include_once '../../config/Database.php';
	include_once '../../models/Peminjaman.php';


	$database = new Database();
	$db = $database->connect();

	$peminjaman = new Peminjaman($db);

	$peminjaman->id = isset($_GET['id']) ? $_GET['id'] : die();

	$peminjaman->read_single();

	$peminjaman_arr = array(
		'id'      		  => $peminjaman->id,
		'nama_buku'       => $peminjaman->nama_buku,
		'nama_peminjam'   => $peminjaman->nama_peminjam,
		'tanggal_pinjam'  => $peminjaman->tanggal_pinjam,
		'tanggal_kembali' => $peminjaman->tanggal_kembali
	);

	print_r(json_encode($peminjaman_arr));

?>