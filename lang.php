<?php
require_once 'config.php';

if (isset($_GET['lang'])) {
    $_SESSION['lang'] = ($_GET['lang'] === 'en') ? 'en' : 'id';
}

$current_lang = $_SESSION['lang'] ?? 'id';

$translations = [
    'id' => [
        'title' => 'Sistem Informasi Data Mahasiswa',
        'login' => 'Login',
        'logout' => 'Keluar',
        'username' => 'Nama Pengguna',
        'password' => 'Kata Sandi',
        'add_data' => 'Tambah Data',
        'nim' => 'NIM',
        'name' => 'Nama Mahasiswa',
        'major' => 'Jurusan',
        'email' => 'Email',
        'action' => 'Aksi',
        'edit' => 'Ubah',
        'delete' => 'Hapus',
        'save' => 'Simpan',
        'cancel' => 'Batal',
        'delete_confirm' => 'Apakah Anda yakin ingin menghapus data ini?',
        'empty_field' => 'Semua kolom wajib diisi!',
        'invalid_email' => 'Format email tidak valid!'
    ],
    'en' => [
        'title' => 'Student Data Information System',
        'login' => 'Login',
        'logout' => 'Logout',
        'username' => 'Username',
        'password' => 'Password',
        'add_data' => 'Add New Student',
        'nim' => 'Student ID',
        'name' => 'Full Name',
        'major' => 'Major',
        'email' => 'Email',
        'action' => 'Action',
        'edit' => 'Edit',
        'delete' => 'Delete',
        'save' => 'Save',
        'cancel' => 'Cancel',
        'delete_confirm' => 'Are you sure you want to delete this record?',
        'empty_field' => 'All fields are required!',
        'invalid_email' => 'Invalid email format!'
    ]
];

$lang = $translations[$current_lang];
?>