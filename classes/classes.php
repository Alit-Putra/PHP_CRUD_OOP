<?php
// Database class
class Database {
    private $host = 'localhost';
    private $db = 'backend_db';
    private $user = 'root';
    private $pass = '';
    private $charset = 'utf8mb4';
    private $pdo;

    public function connect() {
        if ($this->pdo === null) {
            $dsn = "mysql:host={$this->host};dbname={$this->db};charset={$this->charset}";
            $options = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
            ];
            $this->pdo = new PDO($dsn, $this->user, $this->pass, $options);
        }
        return $this->pdo;
    }
}

// Mahasiswa class
class Mahasiswa {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO mahasiswa (nim, nama, id_jurusan, gender, alamat, email, no_hp, profile)
            VALUES (:nim, :nama, :id_jurusan, :gender, :alamat, :email, :no_hp, :profile)
        ");
        $stmt->execute([
            'nim' => $data['nim'],
            'nama' => $data['nama'],
            'id_jurusan' => $data['id_jurusan'],
            'gender' => $data['gender'],
            'alamat' => $data['alamat'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'profile' => $data['profile'], 
        ]);
    }

    public function getAll() {
        $query = $this->db->query("SELECT * FROM mahasiswa");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM mahasiswa WHERE nim = :nim");
        $stmt->execute(['nim' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("
            UPDATE mahasiswa 
            SET nama = :nama, id_jurusan = :id_jurusan, gender = :gender, alamat = :alamat, email = :email, no_hp = :no_hp, profile = :profile
            WHERE nim = :nim
        ");
        $stmt->execute([
            'nama' => $data['nama'],
            'id_jurusan' => $data['id_jurusan'],
            'gender' => $data['gender'],
            'alamat' => $data['alamat'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'profile' => $data['profile'],
            'nim' => $id,
        ]);
    }

    // Delete a Mahasiswa record
    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM mahasiswa WHERE nim = :nim");
        $stmt->execute(['nim' => $id]);
    }
}

// Dosen class
class Dosen {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = $this->db->query("SELECT * FROM dosen");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO dosen (nama_dosen, email, no_hp) VALUES (:nama_dosen, :email, :no_hp)");
        $stmt->execute([
            'nama_dosen' => $data['nama_dosen'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE dosen SET nama_dosen = :nama_dosen, email = :email, no_hp = :no_hp WHERE id_dosen = :id_dosen");
        $stmt->execute([
            'nama_dosen' => $data['nama_dosen'],
            'email' => $data['email'],
            'no_hp' => $data['no_hp'],
            'id_dosen' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM dosen WHERE id_dosen = :id_dosen");
        $stmt->execute(['id_dosen' => $id]);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM dosen WHERE id_dosen = :id_dosen");
        $stmt->execute(['id_dosen' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Jurusan class
class Jurusan {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = $this->db->query("SELECT * FROM jurusan");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO jurusan (nama_jurusan) VALUES (:nama_jurusan)");
        $stmt->execute([
            'nama_jurusan' => $data['nama_jurusan']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE jurusan SET nama_jurusan = :nama_jurusan WHERE id_jurusan = :id_jurusan");
        $stmt->execute([
            'nama_jurusan' => $data['nama_jurusan'],
            'id_jurusan' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM jurusan WHERE id_jurusan = :id_jurusan");
        $stmt->execute(['id_jurusan' => $id]);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM jurusan WHERE id_jurusan = :id_jurusan");
        $stmt->execute(['id_jurusan' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// Matakuliah class
class MataKuliah {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = $this->db->query("SELECT * FROM mata_kuliah");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO mata_kuliah (kode_mk, nama_mk, sks) VALUES (:kode_mk, :nama_mk, :sks)");
        $stmt->execute([
            'kode_mk' => $data['kode_mk'],
            'nama_mk' => $data['nama_mk'],
            'sks' => $data['sks']
        ]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE mata_kuliah SET kode_mk = :kode_mk, nama_mk = :nama_mk, sks = :sks WHERE id_mk = :id_mk");
        $stmt->execute([
            'kode_mk' => $data['kode_mk'],
            'nama_mk' => $data['nama_mk'],
            'sks' => $data['sks'],
            'id_mk' => $id
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM mata_kuliah WHERE id_mk = :id_mk");
        $stmt->execute(['id_mk' => $id]);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM mata_kuliah WHERE id_mk = :id_mk");
        $stmt->execute(['id_mk' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}

// KRS class
class KRS {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $query = $this->db->query("
            SELECT krs.id_krs, mahasiswa.nim AS mahasiswa_nim, mahasiswa.nama AS mahasiswa_nama, mata_kuliah.id_mk AS mata_kuliah_id, mata_kuliah.nama_mk AS mata_kuliah_nama, krs.semester 
            FROM krs
            JOIN mahasiswa ON krs.nim = mahasiswa.nim
            JOIN mata_kuliah ON krs.id_mk = mata_kuliah.id_mk
        ");
        return $query->fetchAll(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("
            INSERT INTO krs (nim, id_mk, semester) 
            VALUES (:nim, :id_mk, :semester)
        ");
        $stmt->execute([
            'nim' => $data['nim'],
            'id_mk' => $data['id_mk'],
            'semester' => $data['semester']
        ]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM krs WHERE id_krs = :id_krs");
        $stmt->execute(['id_krs' => $id]);
    }
}

// Users class
class Users {
    private $db;

    public function __construct($db) {
        $this->db = $db;
    }

    public function getAll() {
        $stmt = $this->db->prepare("SELECT * FROM users");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getById($id) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE id = ?");
        $stmt->execute([$id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function create($data) {
        $stmt = $this->db->prepare("INSERT INTO users (username, password, role) VALUES (?, ?, ?)");
        $stmt->execute([$data['username'], $data['password'], $data['role']]);
    }

    public function update($id, $data) {
        $stmt = $this->db->prepare("UPDATE users SET username = ?, password = ?, role = ? WHERE id = ?");
        $stmt->execute([$data['username'], $data['password'], $data['role'], $id]);
    }

    public function delete($id) {
        $stmt = $this->db->prepare("DELETE FROM users WHERE id = ?");
        $stmt->execute([$id]);
    }

    public function getByUsername($username) {
        $stmt = $this->db->prepare("SELECT * FROM users WHERE username = ?");
        $stmt->execute([$username]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
}
?>