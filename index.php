<?php
    session_start();
    require_once 'classes/classes.php';
    require_once 'controllers/view.php';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CRUD APP - Back End Web Development</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="styles/style.css">
</head>
<body>
    <div class="text-center mt-4">
        <a href="admin/dashboard.php" class="btn btn-primary">Admin Dashboard</a>
        <a href="auth/logout.php" class="btn btn-danger">Logout</a>
    </div>
    <div class="container my-4">
        <h1 class="text-center">CRUD APP</h1>
        <ul class="nav nav-tabs my-3" id="crudTabs">
            <li class="nav-item">
                <a class="nav-link active" data-bs-toggle="tab" href="#mahasiswa-section">Mahasiswa</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#dosen-section">Dosen</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#jurusan-section">Jurusan</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#mk-section">Mata Kuliah</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" data-bs-toggle="tab" href="#krs-section">KRS</a>
            </li>
        </ul>
        <div class="tab-content">
            <div class="tab-pane fade show active" id="mahasiswa-section">
                <h2>Form Mahasiswa</h2>
                <form id="form-mahasiswa" method="POST" action="" enctype="multipart/form-data">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="entity" value="mahasiswa">
                    <input type="hidden" name="existing_profile" value="">
                    <div class="mb-3">
                        <label for="nim" class="form-label">NIM</label>
                        <input type="text" name="nim" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama" class="form-label">Nama Mahasiswa</label>
                        <input type="text" name="nama" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="id_jurusan" class="form-label">Jurusan</label>
                        <select id="id_jurusan" name="id_jurusan" class="form-control" required>
                            <?php foreach ($jurusanList as $jurusan): ?>
                                <option value="<?= $jurusan['id_jurusan'] ?>"><?= $jurusan['nama_jurusan'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">Gender</label><br>
                        <input type="radio" name="gender" value="1" required> Laki-laki
                        <input type="radio" name="gender" value="0"> Perempuan
                    </div>
                    <div class="mb-3">
                        <label for="alamat" class="form-label">Alamat</label>
                        <input type="text" name="alamat" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="profile" class="form-label">Foto Profil</label>
                        <input type="file" name="profile" class="form-control">
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <h2 class="mt-4">Data Mahasiswa</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>NIM</th>
                            <th>Nama</th>
                            <th>Jurusan</th>
                            <th>Gender</th>
                            <th>Alamat</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Foto Profil</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mahasiswaList as $mahasiswa): ?>
                            <tr>
                                <td><?= htmlspecialchars($mahasiswa['nim']) ?></td>
                                <td><?= htmlspecialchars($mahasiswa['nama']) ?></td>
                                <td><?= htmlspecialchars($mahasiswa['id_jurusan']) ?></td>
                                <td>
                                    <?= $mahasiswa['gender'] == 1 ? 'Laki-laki' : 'Perempuan' ?>
                                </td>
                                <td><?= htmlspecialchars($mahasiswa['alamat']) ?></td>
                                <td><?= htmlspecialchars($mahasiswa['email']) ?></td>
                                <td><?= htmlspecialchars($mahasiswa['no_hp']) ?></td>
                                <td>
                                    <?php if (!empty($mahasiswa['profile'])): ?>
                                        <img src="uploads/<?= htmlspecialchars($mahasiswa['profile']) ?>" alt="Profile Image" width="100">
                                    <?php else: ?>
                                        No Image
                                    <?php endif; ?>
                                </td>
                                <td>
                                    <form action="" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="nim" value="<?= htmlspecialchars($mahasiswa['nim']) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="entity" value="mahasiswa">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" onclick="editMahasiswa('<?= htmlspecialchars($mahasiswa['nim']) ?>', '<?= htmlspecialchars($mahasiswa['nama']) ?>', '<?= htmlspecialchars($mahasiswa['id_jurusan']) ?>', '<?= htmlspecialchars($mahasiswa['gender']) ?>', '<?= htmlspecialchars($mahasiswa['alamat']) ?>', '<?= htmlspecialchars($mahasiswa['email']) ?>', '<?= htmlspecialchars($mahasiswa['no_hp']) ?>', '<?= htmlspecialchars($mahasiswa['profile']) ?>')">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="dosen-section">
                <h2>Form Dosen</h2>
                <form id="form-dosen" method="POST" action="">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="entity" value="dosen">
                    <input type="hidden" name="id_dosen" value="">
                    <div class="mb-3">
                        <label for="nama_dosen" class="form-label">Nama Dosen</label>
                        <input type="text" name="nama_dosen" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="email" class="form-label">Email</label>
                        <input type="email" name="email" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="no_hp" class="form-label">No HP</label>
                        <input type="text" name="no_hp" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <h2 class="mt-4">Data Dosen</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Dosen</th>
                            <th>Nama</th>
                            <th>Email</th>
                            <th>No HP</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($dosenList as $dosen): ?>
                            <tr>
                                <td><?= htmlspecialchars($dosen['id_dosen']) ?></td>
                                <td><?= htmlspecialchars($dosen['nama_dosen']) ?></td>
                                <td><?= htmlspecialchars($dosen['email']) ?></td>
                                <td><?= htmlspecialchars($dosen['no_hp']) ?></td>
                                <td>
                                    <form action="" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="id_dosen" value="<?= htmlspecialchars($dosen['id_dosen']) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="entity" value="dosen">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" onclick="editDosen('<?= htmlspecialchars($dosen['id_dosen']) ?>', '<?= htmlspecialchars($dosen['nama_dosen']) ?>', '<?= htmlspecialchars($dosen['email']) ?>', '<?= htmlspecialchars($dosen['no_hp']) ?>')">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="jurusan-section">
                <h2>Form Jurusan</h2>
                <form id="form-jurusan" method="POST" action="">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="entity" value="jurusan">
                    <input type="hidden" name="id_jurusan" value="">
                    <div class="mb-3">
                        <label for="nama_jurusan" class="form-label">Nama Jurusan</label>
                        <input type="text" name="nama_jurusan" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <h2 class="mt-4">Data Jurusan</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID Jurusan</th>
                            <th>Nama Jurusan</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($jurusanList as $jurusan): ?>
                            <tr>
                                <td><?= htmlspecialchars($jurusan['id_jurusan']) ?></td>
                                <td><?= htmlspecialchars($jurusan['nama_jurusan']) ?></td>
                                <td>
                                    <form action="" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="id_jurusan" value="<?= htmlspecialchars($jurusan['id_jurusan']) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="entity" value="jurusan">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" onclick="editJurusan('<?= htmlspecialchars($jurusan['id_jurusan']) ?>', '<?= htmlspecialchars($jurusan['nama_jurusan']) ?>')">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="mk-section">
                <h2>Form Mata Kuliah</h2>
                <form id="form-mk" method="POST" action="">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="entity" value="mataKuliah">
                    <input type="hidden" name="id_mk" value="">
                    <div class="mb-3">
                        <label for="kode_mk" class="form-label">Kode MK</label>
                        <input type="text" name="kode_mk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="nama_mk" class="form-label">Nama MK</label>
                        <input type="text" name="nama_mk" class="form-control" required>
                    </div>
                    <div class="mb-3">
                        <label for="sks" class="form-label">SKS</label>
                        <input type="number" name="sks" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <h2 class="mt-4">Data Mata Kuliah</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID MK</th>
                            <th>Kode MK</th>
                            <th>Nama MK</th>
                            <th>SKS</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($mataKuliahList as $mataKuliah): ?>
                            <tr>
                                <td><?= htmlspecialchars($mataKuliah['id_mk']) ?></td>
                                <td><?= htmlspecialchars($mataKuliah['kode_mk']) ?></td>
                                <td><?= htmlspecialchars($mataKuliah['nama_mk']) ?></td>
                                <td><?= htmlspecialchars($mataKuliah['sks']) ?></td>
                                <td>
                                    <form action="" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="id_mk" value="<?= htmlspecialchars($mataKuliah['id_mk']) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="entity" value="mataKuliah">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                    <button class="btn btn-warning btn-sm" onclick="editMataKuliah('<?= htmlspecialchars($mataKuliah['id_mk']) ?>', '<?= htmlspecialchars($mataKuliah['kode_mk']) ?>', '<?= htmlspecialchars($mataKuliah['nama_mk']) ?>', '<?= htmlspecialchars($mataKuliah['sks']) ?>')">Edit</button>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>

            <div class="tab-pane fade" id="krs-section">
                <h2>Form KRS</h2>
                <form id="form-krs" method="POST" action="">
                    <input type="hidden" name="action" value="create">
                    <input type="hidden" name="entity" value="krs">
                    <input type="hidden" name="id_krs" value="">
                    <div class="mb-3">
                        <label for="nim" class="form-label">Mahasiswa</label>
                        <select id="nim" name="nim" class="form-control" required>
                            <?php foreach ($mahasiswaList as $mahasiswa): ?>
                                <option value="<?= $mahasiswa['nim'] ?>"><?= $mahasiswa['nama'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="id_mk" class="form-label">Mata Kuliah</label>
                        <select id="id_mk" name="id_mk" class="form-control" required>
                            <?php foreach ($mataKuliahList as $mataKuliah): ?>
                                <option value="<?= $mataKuliah['id_mk'] ?>"><?= $mataKuliah['nama_mk'] ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label for="semester" class="form-label">Semester</label>
                        <input type="number" name="semester" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Submit</button>
                </form>
                <h2 class="mt-4">Data KRS</h2>
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>ID KRS</th>
                            <th>Mahasiswa</th>
                            <th>Mata Kuliah</th>
                            <th>Semester</th>
                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach ($krsList as $krs): ?>
                            <tr>
                                <td><?= htmlspecialchars($krs['id_krs']) ?></td>
                                <td><?= htmlspecialchars($krs['mahasiswa_nama']) ?></td>
                                <td><?= htmlspecialchars($krs['mata_kuliah_nama']) ?></td>
                                <td><?= htmlspecialchars($krs['semester']) ?></td>
                                <td>
                                    <form action="" method="POST" style="display:inline-block;">
                                        <input type="hidden" name="id_krs" value="<?= htmlspecialchars($krs['id_krs']) ?>">
                                        <input type="hidden" name="action" value="delete">
                                        <input type="hidden" name="entity" value="krs">
                                        <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
    <footer class="text-center py-3 mt-4 bg-light">
        <p>CRUD Application - College Project by Alit-Putra (230010008)</p>
    </footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script src="scripts/script.js"></script>
</body>
</html>
