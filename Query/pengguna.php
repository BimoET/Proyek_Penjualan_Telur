<?php
 class Pengguna{

private $con;

private $table = "t_pengguna";
public $id_Pengguna,$Nama_Pengguna,$Email_Pengguna,$NoTelp_Pengguna,$Alamat_Pengguna,$JenisKelamin,$Password;


public function __construct($db)
{
    $this->con = $db;
}

public function memasukan(){
    $query = "INSERT INTO {$this->table} (Nama_Pengguna,Email_Pengguna,NoTelp_Pengguna,Alamat_Pengguna,JenisKelamin,Password) VALUES (?,?,?,?,?,?)";
    $statememt = $this->con->prepare($query);
    return $statememt->execute([$this->Nama_Pengguna,$this->Email_Pengguna,$this->NoTelp_Pengguna,$this->Alamat_Pengguna,$this->JenisKelamin,$this->Password]);
}

public function Update(){
    $query = "UPDATE {$this->table} SET Nama_Pengguna = ?,Email_Pengguna = ? , NoTelp_Pengguna = ? ,Alamat_Pengguna =?,JenisKelamin = ? ,Password =? WHERE id_Pengguna = ?";
    $statememt = $this->con->prepare($query);
    return $statememt->execute([$this->Nama_Pengguna,$this->Email_Pengguna,$this->NoTelp_Pengguna,$this->Alamat_Pengguna,$this->JenisKelamin,$this->Password]);
}

public function Tampilkan(){
    $query = "SELECT * FROM {$this->table}";
    $statememt = $this->con->prepare($query);
    return $statememt->execute();   
}

public function hapus(){
    $query = "DELETE FROM $this->table WHERE id_Pengguna = ?";
    $statement = $this->con->prepare($query);
    return $statement->execute([$this->id_Pengguna]);

}

public function cari($Email_Pengguna)
{
 $statement = $this->con->prepare("SELECT * FROM {$this->table} WHERE Email_Pengguna =?");
    
    $statement->execute([$Email_Pengguna]);
    return $statement->fetch(PDO::FETCH_ASSOC);
}


 }


?>