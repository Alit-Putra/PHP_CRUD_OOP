<?php
session_start();
require_once '../classes/classes.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

class Controller {
    private $db;
    private $pdo;
    private $users;
    private $mataKuliah;
    private $mahasiswa;
    private $krs;
    private $jurusan;
    private $dosen;

    public function __construct() {
        $this->db = new Database();
        $this->pdo = $this->db->connect();
        $this->users = new Users($this->pdo);
        $this->mataKuliah = new MataKuliah($this->pdo);
        $this->mahasiswa = new Mahasiswa($this->pdo);
        $this->krs = new KRS($this->pdo);
        $this->jurusan = new Jurusan($this->pdo);
        $this->dosen = new Dosen($this->pdo);
    }

    public function isAdmin() {
        return isset($_SESSION['role']) && $_SESSION['role'] === 'Admin';
    }

    public function handleRequest() {
        if (!isset($_SESSION['username'])) {
            header('Location: ../auth/login.php');
            exit;
        }

        if (!isset($_POST['csrf_token']) || $_POST['csrf_token'] !== $_SESSION['csrf_token']) {
            die("Invalid CSRF token.");
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $action = $_POST['action'];
            $controller = isset($_POST['controller']) ? $_POST['controller'] : null;

            try {
                error_log("Controller: $controller, Action: $action");

                switch ($controller) {
                    case 'users':
                        $this->handleUsers($action);
                        break;
                    case 'mataKuliah':
                        $this->handleMataKuliah($action);
                        break;
                    case 'mahasiswa':
                        $this->handleMahasiswa($action);
                        break;
                    case 'krs':
                        $this->handleKRS($action);
                        break;
                    case 'jurusan':
                        $this->handleJurusan($action);
                        break;
                    case 'dosen':
                        $this->handleDosen($action);
                        break;
                }
            } catch (Exception $e) {
                error_log("Error: " . $e->getMessage());
                echo "Error: " . $e->getMessage();
            }
        }
    }

    private function handleUsers($action) {
        if ($_SESSION['role'] !== 'Admin') {
            header('Location: ../auth/login.php');
            exit;
        }
        if ($action === 'create') {
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->users->create([
                'username' => $_POST['username'],
                'password' => $passwordHash,
                'role' => $_POST['role']
            ]);
            error_log("User created: " . $_POST['username']);
            header('Location: ../admin/dashboard.php');
            exit();
        } elseif ($action === 'update') {
            $passwordHash = password_hash($_POST['password'], PASSWORD_DEFAULT);
            $this->users->update($_POST['id'], [
                'username' => $_POST['username'],
                'password' => $passwordHash,
                'role' => $_POST['role']
            ]);
            error_log("User updated: " . $_POST['username']);
            header('Location: ../admin/dashboard.php');
            exit();
        } elseif ($action === 'delete') {
            $this->users->delete($_POST['id']);
            error_log("User deleted: " . $_POST['id']);
            header('Location: ../admin/dashboard.php');
            exit();
        }
    }

    private function handleMataKuliah($action) {
        if ($action === 'edit') {
            $data = $this->mataKuliah->getById($_POST['id_mk']);
            echo json_encode($data);
            exit();
        }
        if ($action === 'create') {
            $this->mataKuliah->create($_POST);
            error_log("Mata Kuliah created: " . $_POST['kode_mk']);
            header('Location: ../index.php');
            exit();
        } elseif ($action === 'update') {
            $this->mataKuliah->update($_POST['id_mk'], $_POST);
            error_log("Mata Kuliah updated: " . $_POST['id_mk']);
            header('Location: ../index.php');
            exit();
        } elseif ($action === 'delete') {
            $this->mataKuliah->delete($_POST['id_mk']);
            error_log("Mata Kuliah deleted: " . $_POST['id_mk']);
            header('Location: ../index.php');
            exit();
        }
    }

    private function handleMahasiswa($action) {
        if ($action === 'edit') {
            $data = $this->mahasiswa->getById($_POST['nim']);
            echo json_encode($data);
            exit();
        }
        if ($action === 'create') {
            $fileName = $this->uploadFile('profile');
            $this->mahasiswa->create([
                'nim' => $_POST['nim'],
                'nama' => $_POST['nama'],
                'id_jurusan' => $_POST['id_jurusan'],
                'gender' => $_POST['gender'],
                'alamat' => $_POST['alamat'],
                'email' => $_POST['email'],
                'no_hp' => $_POST['no_hp'],
                'profile' => $fileName,
            ]);
            error_log("Mahasiswa created: " . $_POST['nim']);
            header('Location: ../index.php');
            exit();
        } elseif ($action === 'update') {
            if (!$this->isAdmin()) {
                throw new Exception("Unauthorized access.");
            }
            $fileName = $_POST['existing_profile'];
            if (!empty($_FILES['profile']['name'])) {
                $fileName = $this->uploadFile('profile');
            }
            $this->mahasiswa->update($_POST['nim'], [
                'nama' => $_POST['nama'],
                'id_jurusan' => $_POST['id_jurusan'],
                'gender' => $_POST['gender'],
                'alamat' => $_POST['alamat'],
                'email' => $_POST['email'],
                'no_hp' => $_POST['no_hp'],
                'profile' => $fileName,
            ]);
            error_log("Mahasiswa updated: " . $_POST['nim']);
            header('Location: ../index.php');
            exit();
        } elseif ($action === 'delete') {
            if (!$this->isAdmin()) {
                throw new Exception("Unauthorized access.");
            }
            $this->mahasiswa->delete($_POST['nim']);
            error_log("Mahasiswa deleted: " . $_POST['nim']);
            header('Location: ../index.php');
            exit();
        }
    }

    private function handleKRS($action) {
        if ($action === 'create') {
            $this->krs->create($_POST);
            error_log("KRS created: " . $_POST['nim']);
            header('Location: ../index.php');
            exit();
        } elseif ($action === 'delete') {
            $this->krs->delete($_POST['id_krs']);
            error_log("KRS deleted: " . $_POST['id_krs']);
            header('Location: ../index.php');
            exit();
        }
    }

    private function handleJurusan($action) {
        if ($action === 'edit') {
            $data = $this->jurusan->getById($_POST['id_jurusan']);
            echo json_encode($data);
            exit();
        }
        if ($action === 'create') {
            $this->jurusan->create($_POST);
            error_log("Jurusan created: " . $_POST['nama_jurusan']);
            header('Location: ../index.php');
            exit();
        } elseif ($action === 'update') {
            $this->jurusan->update($_POST['id_jurusan'], $_POST);
            error_log("Jurusan updated: " . $_POST['id_jurusan']);
            header('Location: ../index.php');
            exit();
        } elseif ($action === 'delete') {
            $this->jurusan->delete($_POST['id_jurusan']);
            error_log("Jurusan deleted: " . $_POST['id_jurusan']);
            header('Location: ../index.php');
            exit();
        }
    }

    private function handleDosen($action) {
        if ($action === 'edit') {
            $data = $this->dosen->getById($_POST['id_dosen']);
            echo json_encode($data);
            exit();
        }
        if ($action === 'create') {
            $this->dosen->create($_POST);
            error_log("Dosen created: " . $_POST['nama_dosen']);
            header('Location: ../index.php');
            exit();
        } elseif ($action === 'update') {
            $id = $_POST['id_dosen'];
            $this->dosen->update($id, $_POST);
            error_log("Dosen updated: " . $_POST['id_dosen']);
            header('Location: ../index.php');
            exit();
        } elseif ($action === 'delete') {
            $id = $_POST['id_dosen'];
            $this->dosen->delete($id);
            error_log("Dosen deleted: " . $_POST['id_dosen']);
            header('Location: ../index.php');
            exit();
        }
    }

    private function uploadFile($inputName) {
        $fileName = null;
        if (!empty($_FILES[$inputName]['name'])) {
            $targetDir = "../uploads/";
            if (!is_dir($targetDir)) {
                mkdir($targetDir, 0755, true);
            }
            $fileName = uniqid() . "_" . basename($_FILES[$inputName]['name']);
            $targetFilePath = $targetDir . $fileName;
            $allowedTypes = ['jpg', 'jpeg', 'png'];
            $fileType = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
            if (in_array($fileType, $allowedTypes)) {
                if (!move_uploaded_file($_FILES[$inputName]['tmp_name'], $targetFilePath)) {
                    throw new Exception("File upload failed.");
                }
            } else {
                throw new Exception("Invalid file type. Only JPG, JPEG, and PNG files are allowed.");
            }
        }
        return $fileName;
    }
}

$controller = new Controller();
$controller->handleRequest();
?>
