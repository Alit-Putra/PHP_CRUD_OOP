function editMahasiswa(nim, nama, id_jurusan, gender, alamat, email, no_hp, profile) {
    document.querySelector('#form-mahasiswa input[name="action"]').value = 'update';
    document.querySelector('#form-mahasiswa input[name="nim"]').value = nim;
    document.querySelector('#form-mahasiswa input[name="nama"]').value = nama;
    document.querySelector('#form-mahasiswa select[name="id_jurusan"]').value = id_jurusan;
    document.querySelector('#form-mahasiswa input[name="gender"][value="' + gender + '"]').checked = true;
    document.querySelector('#form-mahasiswa input[name="alamat"]').value = alamat;
    document.querySelector('#form-mahasiswa input[name="email"]').value = email;
    document.querySelector('#form-mahasiswa input[name="no_hp"]').value = no_hp;
    document.querySelector('#form-mahasiswa input[name="existing_profile"]').value = profile;
}

function editDosen(id_dosen, nama_dosen, email, no_hp) {
    document.querySelector('#form-dosen input[name="action"]').value = 'update';
    document.querySelector('#form-dosen input[name="id_dosen"]').value = id_dosen;
    document.querySelector('#form-dosen input[name="nama_dosen"]').value = nama_dosen;
    document.querySelector('#form-dosen input[name="email"]').value = email;
    document.querySelector('#form-dosen input[name="no_hp"]').value = no_hp;
}

function editJurusan(id_jurusan, nama_jurusan) {
    document.querySelector('#form-jurusan input[name="action"]').value = 'update';
    document.querySelector('#form-jurusan input[name="id_jurusan"]').value = id_jurusan;
    document.querySelector('#form-jurusan input[name="nama_jurusan"]').value = nama_jurusan;
}

function editMataKuliah(id_mk, kode_mk, nama_mk, sks) {
    document.querySelector('#form-mk input[name="action"]').value = 'update';
    document.querySelector('#form-mk input[name="id_mk"]').value = id_mk;
    document.querySelector('#form-mk input[name="kode_mk"]').value = kode_mk;
    document.querySelector('#form-mk input[name="nama_mk"]').value = nama_mk;
    document.querySelector('#form-mk input[name="sks"]').value = sks;
}

function editKRS(id_krs, nim, id_mk, semester) {
    document.querySelector('#form-krs input[name="action"]').value = 'update';
    document.querySelector('#form-krs input[name="id_krs"]').value = id_krs;
    document.querySelector('#form-krs select[name="nim"]').value = nim;
    document.querySelector('#form-krs select[name="id_mk"]').value = id_mk;
    document.querySelector('#form-krs input[name="semester"]').value = semester;
}

function editPengguna(username, password, role) {
    document.querySelector('#form-user input[name="action"]').value = 'update';
    document.querySelector('#form-user input[name="username"]').value = username;
    document.querySelector('#form-user input[name="password"]').value = password;
    document.querySelector('#form-user select[name="role"]').value = role;
}