-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: localhost:3306
-- Waktu pembuatan: 06 Jun 2023 pada 12.49
-- Versi server: 8.0.30
-- Versi PHP: 8.1.10

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `my-backend`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `failed_jobs`
--

CREATE TABLE `failed_jobs` (
  `id` bigint UNSIGNED NOT NULL,
  `uuid` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `connection` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `queue` text COLLATE utf8mb4_unicode_ci NOT NULL,
  `payload` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `exception` longtext COLLATE utf8mb4_unicode_ci NOT NULL,
  `failed_at` timestamp NOT NULL DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `migrations`
--

CREATE TABLE `migrations` (
  `id` int UNSIGNED NOT NULL,
  `migration` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `migrations`
--

INSERT INTO `migrations` (`id`, `migration`, `batch`) VALUES
(15, '2014_10_12_100000_create_password_resets_table', 1),
(16, '2019_08_19_000000_create_failed_jobs_table', 1),
(17, '2019_12_14_000001_create_personal_access_tokens_table', 1),
(18, '2023_05_01_083159_create_karyawans_table', 1),
(19, '2023_05_01_083338_rename_karyawans_column', 1),
(20, '2023_05_01_083339_create_users_table', 1),
(21, '2023_05_01_083340_rename_users_column', 1),
(24, '2023_06_05_055942_create_jenis_approvals_table', 2),
(25, '2023_06_05_055943_rename_jenis_approval_column_column', 2),
(26, '2023_06_05_123328_create_jenis_transaksis_table', 3),
(27, '2023_06_05_123329_rename_jenis_transaksi_column', 3),
(28, '2023_06_05_133038_create_pejabat_approval_table', 4),
(29, '2023_06_05_133039_rename_pejabat_approval_column', 4),
(30, '2023_06_05_211233_create_pengajuans_table', 5),
(31, '2023_06_05_211234_rename_pengajuan_column', 5),
(32, '2023_06_06_001054_create_penerimaan_langsungs_table', 6),
(33, '2023_06_06_001055_rename_penerimaan_langsung_column', 6);

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_jenis_approval`
--

CREATE TABLE `m_jenis_approval` (
  `app_id` bigint UNSIGNED NOT NULL,
  `app_jenis` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_min_nom` int NOT NULL,
  `app_max_nom` int NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_jenis_approval`
--

INSERT INTO `m_jenis_approval` (`app_id`, `app_jenis`, `app_nama`, `app_min_nom`, `app_max_nom`, `created_at`, `updated_at`) VALUES
(1, 'app_verifikasi', 'Verifikasi', 0, 500000, '2023-06-05 05:27:21', '2023-06-05 05:27:21'),
(2, 'app_keuangan', 'Keuangan', 500001, 2000000, '2023-06-05 05:27:36', '2023-06-05 05:27:36'),
(3, 'app_direksi', 'Direksi', 2000001, 999999999, '2023-06-05 05:27:59', '2023-06-05 05:27:59');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_jenis_transaksi`
--

CREATE TABLE `m_jenis_transaksi` (
  `trx_id` bigint UNSIGNED NOT NULL,
  `trx_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `trx_kategori` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_jenis_transaksi`
--

INSERT INTO `m_jenis_transaksi` (`trx_id`, `trx_nama`, `trx_kategori`, `created_at`, `updated_at`) VALUES
(1, 'Biaya BRT', 'pengeluaran', '2023-06-05 05:41:07', '2023-06-05 05:41:07'),
(2, 'Penambahan Lisensi', 'penerimaan', '2023-06-05 05:41:22', '2023-06-05 05:41:22'),
(3, 'Biaya Pelatihan', 'pengeluaran', '2023-06-05 05:41:29', '2023-06-05 05:41:29'),
(4, 'Biaya Implementasi', 'pengeluaran', '2023-06-05 05:41:22', '2023-06-05 05:41:22'),
(5, 'Biaya Maintenance', 'penerimaan', '2023-06-05 05:41:29', '2023-06-05 05:41:29');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_karyawan`
--

CREATE TABLE `m_karyawan` (
  `kry_id` bigint UNSIGNED NOT NULL,
  `kry_nik` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kry_nama` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kry_bagian` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `kry_jabatan` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_karyawan`
--

INSERT INTO `m_karyawan` (`kry_id`, `kry_nik`, `kry_nama`, `kry_bagian`, `kry_jabatan`, `created_at`, `updated_at`) VALUES
(1, '0001', 'My Administrator', 'admin', 'admin', '2023-06-04 17:26:50', '2023-06-04 17:26:50'),
(2, '0002', 'Yan Yan', 'programmer', 'karyawan', '2023-06-04 19:13:38', '2023-06-04 19:13:38'),
(3, '0003', 'Henda', 'cs', 'karyawan', '2023-06-04 19:13:56', '2023-06-04 19:13:56'),
(4, '0004', 'Asep', 'programmer', 'karyawan', '2023-06-04 19:14:50', '2023-06-04 19:14:50'),
(5, '0005', 'Haris Efendi', 'keuangan', 'karyawan', '2023-06-04 19:16:01', '2023-06-04 19:16:01'),
(6, '0006', 'Heny Ernawati', 'keuangan', 'admin keuangan', '2023-06-04 19:16:29', '2023-06-04 19:16:29'),
(7, '0007', 'Edy', 'direktur', 'direksi', '2023-06-04 19:16:48', '2023-06-04 19:16:48');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_pejabat_approval`
--

CREATE TABLE `m_pejabat_approval` (
  `pjbt_id` bigint UNSIGNED NOT NULL,
  `app_id` bigint UNSIGNED NOT NULL,
  `usr_id` bigint UNSIGNED NOT NULL,
  `app_auth_user` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `app_auth_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `pjbt_status` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_pejabat_approval`
--

INSERT INTO `m_pejabat_approval` (`pjbt_id`, `app_id`, `usr_id`, `app_auth_user`, `app_auth_password`, `pjbt_status`, `created_at`, `updated_at`) VALUES
(1, 1, 7, 'user', 'password', '1', '2023-06-05 14:05:28', '2023-06-05 14:05:28'),
(2, 2, 8, 'user', 'password', '1', '2023-06-05 14:05:40', '2023-06-05 14:05:40'),
(3, 3, 9, 'user', 'password', '0', '2023-06-05 14:05:52', '2023-06-05 14:08:15');

-- --------------------------------------------------------

--
-- Struktur dari tabel `m_user`
--

CREATE TABLE `m_user` (
  `usr_id` bigint UNSIGNED NOT NULL,
  `kry_id` bigint UNSIGNED NOT NULL,
  `usr_login` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `usr_password` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `remember_token` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `m_user`
--

INSERT INTO `m_user` (`usr_id`, `kry_id`, `usr_login`, `usr_password`, `remember_token`, `created_at`, `updated_at`) VALUES
(1, 1, 'admin', '$2y$10$/DTVjU0L9SpKC6I4ecX3puaFtU3LNQoeYWKq/drwyP.5YaMsfejv2', NULL, '2023-06-04 17:26:50', '2023-06-04 17:26:50'),
(2, 2, 'yanyan', '$2y$10$NxwTkyxAojze8BAb5aGbSOk9fMJnUvFEzosJDnQqxynySTSl53VFu', NULL, '2023-06-04 22:47:33', '2023-06-04 22:47:33'),
(3, 3, 'henda', '$2y$10$vSw6v5JCOrKM7XszZjqzruHXAcXpP7LozXKRKwE1yFF8d2OPmAq2u', NULL, '2023-06-04 22:51:11', '2023-06-04 22:51:11'),
(6, 4, 'asep12', '$2y$10$Zu151p8kbUv6K3sYTc/nze75C1440o6Wa2/OF/2VEbKTaXXGV4aKq', NULL, '2023-06-04 22:53:05', '2023-06-04 22:54:42'),
(7, 5, 'haris123', '$2y$10$1Ot0MuAyaiK1V.nZ1pmL3.i0QPOfj.TOcFiXPgXykFqCjIfODHUIK', NULL, '2023-06-05 14:02:37', '2023-06-05 14:02:37'),
(8, 6, 'heny123', '$2y$10$NqPqWV08Cm28TuLUzN2eyuzH.igkdf9czeZBoyPXHdACBhw2M5YI2', NULL, '2023-06-05 14:03:23', '2023-06-05 14:03:23'),
(9, 7, 'edy123', '$2y$10$HJKSFSoWEOWkJ/6lAcw1gemG8iLseergOw/D5JwpsUrvUCskzLUf.', NULL, '2023-06-05 14:03:38', '2023-06-05 14:03:38');

-- --------------------------------------------------------

--
-- Struktur dari tabel `password_resets`
--

CREATE TABLE `password_resets` (
  `email` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `personal_access_tokens`
--

CREATE TABLE `personal_access_tokens` (
  `id` bigint UNSIGNED NOT NULL,
  `tokenable_type` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tokenable_id` bigint UNSIGNED NOT NULL,
  `name` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `token` varchar(64) COLLATE utf8mb4_unicode_ci NOT NULL,
  `abilities` text COLLATE utf8mb4_unicode_ci,
  `last_used_at` timestamp NULL DEFAULT NULL,
  `expires_at` timestamp NULL DEFAULT NULL,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_penerimaan_langsung`
--

CREATE TABLE `t_penerimaan_langsung` (
  `tpl_id` bigint UNSIGNED NOT NULL,
  `usr_id` bigint UNSIGNED NOT NULL,
  `trans_jns` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpl_nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpl_tanggal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `tpl_nominal` int NOT NULL,
  `tpl_keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `t_penerimaan_langsung`
--

INSERT INTO `t_penerimaan_langsung` (`tpl_id`, `usr_id`, `trans_jns`, `tpl_nomor`, `tpl_tanggal`, `tpl_nominal`, `tpl_keterangan`, `created_at`, `updated_at`) VALUES
(1, 7, '5', 'TPL0001', '2023-06-05', 1500000, '-', '2023-06-05 22:50:16', '2023-06-05 22:50:16'),
(3, 7, '2', 'TPL0002', '2023-06-04', 15000002, '-', '2023-06-05 22:50:46', '2023-06-06 05:46:28');

-- --------------------------------------------------------

--
-- Struktur dari tabel `t_pengajuan`
--

CREATE TABLE `t_pengajuan` (
  `aju_id` bigint UNSIGNED NOT NULL,
  `kry_id` bigint UNSIGNED NOT NULL,
  `trx_id` bigint UNSIGNED NOT NULL,
  `aju_nomor` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aju_tanggal` varchar(255) COLLATE utf8mb4_unicode_ci NOT NULL,
  `aju_nominal` int NOT NULL,
  `aju_keterangan` text COLLATE utf8mb4_unicode_ci,
  `created_at` timestamp NULL DEFAULT NULL,
  `updated_at` timestamp NULL DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci;

--
-- Dumping data untuk tabel `t_pengajuan`
--

INSERT INTO `t_pengajuan` (`aju_id`, `kry_id`, `trx_id`, `aju_nomor`, `aju_tanggal`, `aju_nominal`, `aju_keterangan`, `created_at`, `updated_at`) VALUES
(1, 2, 1, '0001', '2023-06-05', 1000000, 'BRT Bulan Juni 2023', '2023-06-05 16:18:03', '2023-06-05 16:18:03');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `failed_jobs_uuid_unique` (`uuid`);

--
-- Indeks untuk tabel `migrations`
--
ALTER TABLE `migrations`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `m_jenis_approval`
--
ALTER TABLE `m_jenis_approval`
  ADD PRIMARY KEY (`app_id`);

--
-- Indeks untuk tabel `m_jenis_transaksi`
--
ALTER TABLE `m_jenis_transaksi`
  ADD PRIMARY KEY (`trx_id`);

--
-- Indeks untuk tabel `m_karyawan`
--
ALTER TABLE `m_karyawan`
  ADD PRIMARY KEY (`kry_id`),
  ADD UNIQUE KEY `m_karyawan_kry_nik_unique` (`kry_nik`);

--
-- Indeks untuk tabel `m_pejabat_approval`
--
ALTER TABLE `m_pejabat_approval`
  ADD PRIMARY KEY (`pjbt_id`),
  ADD KEY `m_pejabat_approval_app_id_foreign` (`app_id`),
  ADD KEY `m_pejabat_approval_usr_id_foreign` (`usr_id`);

--
-- Indeks untuk tabel `m_user`
--
ALTER TABLE `m_user`
  ADD PRIMARY KEY (`usr_id`),
  ADD KEY `m_user_kry_id_foreign` (`kry_id`);

--
-- Indeks untuk tabel `password_resets`
--
ALTER TABLE `password_resets`
  ADD PRIMARY KEY (`email`);

--
-- Indeks untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `personal_access_tokens_token_unique` (`token`),
  ADD KEY `personal_access_tokens_tokenable_type_tokenable_id_index` (`tokenable_type`,`tokenable_id`);

--
-- Indeks untuk tabel `t_penerimaan_langsung`
--
ALTER TABLE `t_penerimaan_langsung`
  ADD PRIMARY KEY (`tpl_id`),
  ADD KEY `t_penerimaan_langsung_usr_id_foreign` (`usr_id`);

--
-- Indeks untuk tabel `t_pengajuan`
--
ALTER TABLE `t_pengajuan`
  ADD PRIMARY KEY (`aju_id`),
  ADD KEY `t_pengajuan_kry_id_foreign` (`kry_id`),
  ADD KEY `t_pengajuan_trx_id_foreign` (`trx_id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `failed_jobs`
--
ALTER TABLE `failed_jobs`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `migrations`
--
ALTER TABLE `migrations`
  MODIFY `id` int UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=34;

--
-- AUTO_INCREMENT untuk tabel `m_jenis_approval`
--
ALTER TABLE `m_jenis_approval`
  MODIFY `app_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `m_jenis_transaksi`
--
ALTER TABLE `m_jenis_transaksi`
  MODIFY `trx_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `m_karyawan`
--
ALTER TABLE `m_karyawan`
  MODIFY `kry_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=8;

--
-- AUTO_INCREMENT untuk tabel `m_pejabat_approval`
--
ALTER TABLE `m_pejabat_approval`
  MODIFY `pjbt_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=5;

--
-- AUTO_INCREMENT untuk tabel `m_user`
--
ALTER TABLE `m_user`
  MODIFY `usr_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=10;

--
-- AUTO_INCREMENT untuk tabel `personal_access_tokens`
--
ALTER TABLE `personal_access_tokens`
  MODIFY `id` bigint UNSIGNED NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `t_penerimaan_langsung`
--
ALTER TABLE `t_penerimaan_langsung`
  MODIFY `tpl_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

--
-- AUTO_INCREMENT untuk tabel `t_pengajuan`
--
ALTER TABLE `t_pengajuan`
  MODIFY `aju_id` bigint UNSIGNED NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=3;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `m_pejabat_approval`
--
ALTER TABLE `m_pejabat_approval`
  ADD CONSTRAINT `m_pejabat_approval_app_id_foreign` FOREIGN KEY (`app_id`) REFERENCES `m_jenis_approval` (`app_id`),
  ADD CONSTRAINT `m_pejabat_approval_usr_id_foreign` FOREIGN KEY (`usr_id`) REFERENCES `m_user` (`usr_id`);

--
-- Ketidakleluasaan untuk tabel `m_user`
--
ALTER TABLE `m_user`
  ADD CONSTRAINT `m_user_kry_id_foreign` FOREIGN KEY (`kry_id`) REFERENCES `m_karyawan` (`kry_id`);

--
-- Ketidakleluasaan untuk tabel `t_penerimaan_langsung`
--
ALTER TABLE `t_penerimaan_langsung`
  ADD CONSTRAINT `t_penerimaan_langsung_usr_id_foreign` FOREIGN KEY (`usr_id`) REFERENCES `m_user` (`usr_id`);

--
-- Ketidakleluasaan untuk tabel `t_pengajuan`
--
ALTER TABLE `t_pengajuan`
  ADD CONSTRAINT `t_pengajuan_kry_id_foreign` FOREIGN KEY (`kry_id`) REFERENCES `m_karyawan` (`kry_id`),
  ADD CONSTRAINT `t_pengajuan_trx_id_foreign` FOREIGN KEY (`trx_id`) REFERENCES `m_jenis_transaksi` (`trx_id`);
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
