<?php

class Peminjaman{

	private $conn;
	private $table ='daftar_peminjaman';


	public $id;
	public $nama_buku;
	public $nama_peminjam;
	public $tanggal_pinjam;
	public $tanggal_kembali;



	public function __construct($db){
		$this->conn =$db;
	}

	public function read(){
		 $query = 'SELECT * FROM '. $this->table .''; 	
		

 	$stmt = $this->conn->prepare($query);
	
 	$stmt->execute();

 	return $stmt;
	}

	public function read_single(){
		$query = 'SELECT * 
	FROM '. $this->table .' 
	WHERE id=? 	
	LIMIT 0,1';

 	$stmt = $this->conn->prepare($query);
	
 	$stmt->bindParam(1, $this->id);
 	$stmt->execute();

 	$row = $stmt->fetch(PDO::FETCH_ASSOC);

 		$this->nama_buku 		 = $row['nama_buku'];
		$this->nama_peminjam	 = $row['nama_peminjam'];
		$this->tanggal_pinjam	 = $row['tanggal_pinjam'];
		$this->tanggal_kembali	 = $row['tanggal_kembali']; 		
	}

	public function create(){
		$query = 'INSERT INTO ' . $this->table . ' 
		  SET 
		  	nama_buku = :nama_buku,
		  	nama_peminjam = :nama_peminjam,
		  	tanggal_pinjam = :tanggal_pinjam,
		  	tanggal_kembali = :tanggal_kembali';
		
		$stmt = $this->conn->prepare($query);

		//clean data
		$this->nama_buku 	   = htmlspecialchars(strip_tags($this->nama_buku));
		$this->nama_peminjam   = htmlspecialchars(strip_tags($this->nama_peminjam));
		$this->tanggal_pinjam  = htmlspecialchars(strip_tags($this->tanggal_pinjam));
		$this->tanggal_kembali = htmlspecialchars(strip_tags($this->tanggal_kembali));
	
		$stmt->bindParam(':nama_buku',$this->nama_buku);
		$stmt->bindParam(':nama_peminjam',$this->nama_peminjam);
		$stmt->bindParam(':tanggal_pinjam',$this->tanggal_pinjam);
		$stmt->bindParam(':tanggal_kembali',$this->tanggal_kembali);

		if($stmt->execute()){
			return true;
		} 
			printf("GAGAL = %s.\n",$stmt->error);
			return false;
	}

	public function update(){
		$query = 'UPDATE ' . $this->table . ' 
		  SET 
		  	nama_buku = :nama_buku,
		  	nama_peminjam = :nama_peminjam,
		  	tanggal_pinjam = :tanggal_pinjam,
		  	tanggal_kembali = :tanggal_kembali
		  WHERE
		  	id = :id';
		
		$stmt = $this->conn->prepare($query);

		//clean data
		$this->nama_buku 	   = htmlspecialchars(strip_tags($this->nama_buku));
		$this->nama_peminjam   = htmlspecialchars(strip_tags($this->nama_peminjam));
		$this->tanggal_pinjam  = htmlspecialchars(strip_tags($this->tanggal_pinjam));
		$this->tanggal_kembali = htmlspecialchars(strip_tags($this->tanggal_kembali));
		$this->id 			   = htmlspecialchars(strip_tags($this->id));
	
		$stmt->bindParam(':nama_buku',$this->nama_buku);
		$stmt->bindParam(':nama_peminjam',$this->nama_peminjam);
		$stmt->bindParam(':tanggal_pinjam',$this->tanggal_pinjam);
		$stmt->bindParam(':tanggal_kembali',$this->tanggal_kembali);
		$stmt->bindParam(':id',$this->id);

		if($stmt->execute()){
			return true;
		} 
			printf("GAGAL = %s.\n",$stmt->error);
			return false;
	}

	public function delete(){
		$query = 'DELETE FROM ' . $this->table . ' WHERE id = :id';

		$stmt = $this->conn->prepare($query);

		$this->id 			   = htmlspecialchars(strip_tags($this->id));
	
		$stmt->bindParam(':id',$this->id);

		if($stmt->execute()){
			return true;
		} 
			printf("GAGAL = %s.\n",$stmt->error);
			return false;

	}
} 
?>