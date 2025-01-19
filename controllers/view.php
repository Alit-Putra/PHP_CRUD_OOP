<?php
class Controller {
    private $mahasiswa;
    private $dosen;
    private $jurusan;
    private $mataKuliah;
    private $krs;

    public function __construct($pdo) {
        $this->mahasiswa = new Mahasiswa($pdo);
        $this->dosen = new Dosen($pdo);
        $this->jurusan = new Jurusan($pdo);
        $this->mataKuliah = new MataKuliah($pdo);
        $this->krs = new KRS($pdo);
    }

    public function handleFileUpload($file, $targetDir = "uploads/") {
        if (!empty($file['name'])) {
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $fileName = uniqid() . "_" . basename($file['name']);
            $targetFilePath = $targetDir . $fileName;
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (in_array($fileType, $allowedTypes)) {
                if (!move_uploaded_file($file['tmp_name'], $targetFilePath)) {
                    throw new Exception("File upload failed.");
                }
                return $fileName;
            } else {
                throw new Exception("Hanya format JPG, JPEG, and PNG yang bisa dipakai.");
            }
        }
        return null;
    }

    public function handleFormSubmission($entity, $action, $data, $file = null) {
        switch ($entity) {
            case 'mahasiswa':
                if ($file) {
                    $data['profile'] = $this->handleFileUpload($file);
                }
                if ($action === 'create') {
                    $this->mahasiswa->create($data);
                } elseif ($action === 'update') {
                    $this->mahasiswa->update($data['nim'], $data);
                } elseif ($action === 'delete') {
                    $this->mahasiswa->delete($data['nim']);
                }
                break;

            case 'dosen':
                if ($action === 'create') {
                    $this->dosen->create($data);
                } elseif ($action === 'update') {
                    $this->dosen->update($data['id_dosen'], $data);
                } elseif ($action === 'delete') {
                    $this->dosen->delete($data['id_dosen']);
                }
                break;

            case 'jurusan':
                if ($action === 'create') {
                    $this->jurusan->create($data);
                } elseif ($action === 'update') {
                    $this->jurusan->update($data['id_jurusan'], $data);
                } elseif ($action === 'delete') {
                    $this->jurusan->delete($data['id_jurusan']);
                }
                break;

            case 'mataKuliah':
                if ($action === 'create') {
                    $this->mataKuliah->create($data);
                } elseif ($action === 'update') {
                    $this->mataKuliah->update($data['id_mk'], $data);
                } elseif ($action === 'delete') {
                    $this->mataKuliah->delete($data['id_mk']);
                }
                break;

            case 'krs':
                if ($action === 'create') {
                    $this->krs->create($data);
                } elseif ($action === 'delete') {
                    $this->krs->delete($data['id_krs']);
                }
                break;
        }
    }

    public function getAllData() {
        return [
            'mataKuliahList' => $this->mataKuliah->getAll(),
            'mahasiswaList' => $this->mahasiswa->getAll(),
            'krsList' => $this->krs->getAll(),
            'jurusanList' => $this->jurusan->getAll(),
            'dosenList' => $this->dosen->getAll()
        ];
    }
}

$db = new Database();
$pdo = $db->connect();
$controller = new Controller($pdo);

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $action = $_POST['action'];
    $entity = $_POST['entity'];
    $data = $_POST;
    $file = $_FILES['profile'] ?? null;

    $controller->handleFormSubmission($entity, $action, $data, $file);
    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}

$data = $controller->getAllData();
$mataKuliahList = $data['mataKuliahList'];
$mahasiswaList = $data['mahasiswaList'];
$krsList = $data['krsList'];
$jurusanList = $data['jurusanList'];
$dosenList = $data['dosenList'];
?>