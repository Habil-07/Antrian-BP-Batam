<?php

namespace Database\Seeders;

class AllServicesData
{
    public static $services = [
    [
        'service' => 'Badan Usaha Rumah Sakit',
        'subServices' => [
            'Pelayanan Gawat Darurat',
            'Pelayanan Rawat Jalan & MCU (Medical Check-Up)',
            'Pelayanan Rawat Inap',
            'Pendaftaran Pasien Baru',
        ],
    ],
    [
        'service' => 'Badan Usaha Pelabuhan',
        'subServices' => [
            'Jasa Labuh Kapal',
            'Jasa Tambat',
            'Jasa Pemanduan Kapal',
            'Jasa Penundaan Kapal',
            'Jasa Kepil',
            'Layanan Kapal Yacht',
            'Layanan Jasa Penumpukan',
            'Jasa Bongkar Muat',
            'Layanan Penumpang',
            'Sewa Alat Mekanik',
            'Layanan Penggunaan Perairan',
            'Sewa Rak dan Area Pelabuhan untuk Jalur Pipa',
            'Sewa Tempat Iklan dan Promosi',
        ],
    ],
    [
        'service' => 'Badan Usaha Fasilitas dan Lingkungan',
        'subServices' => [
            'Pengelolaan Air Limbah',
            'Kawasan Pengelolaan Limbah Industri – Bahan Beracun Berbahaya (KPLI-B3)',
            'Layanan Laboratorium Uji',
            'Sewa Kamar/Kios Rumah Susun',
            'Penggunaan/Sewa Aula dan Ruangan Pertemuan',
            'Penggunaan/Sewa Kamar dan Ruangan',
            'Penggunaan/Sewa Peralatan Pendukung',
            'Penggunaan/Sewa Gedung Sport Hall, Stadion Lapangan Bola dan Lapangan Parkir Utama Kawasan Temenggung Abdul Jamal',
            'Penggunaan/Sewa Ruang Perkantoran, Ruang Publik, Area Komersil dan Lahan',
            'Tiket Masuk Kunjungan Kawasan Wisata',
            'Wisata Agribisnis',
            'Pertanian',
            'Tanaman Hias',
            'Peternakan',
            'Perikanan',
            'Jasa Pemotongan Hewan',
        ],
    ],
    [
        'service' => 'Badan Usaha Sistem Pengelolaan Air Minum',
        'subServices' => [
            'Rekomendasi Sambung Baru Meter Pelanggan',
        ],
    ],
    [
        'service' => 'Direktorat Pelayanan Terpadu Satu Pintu',
        'subServices' => [
            'Izin Pembangunan atau Pengembangan Terminal Khusus',
            'Surat Keterangan Kerja Angkutan Barang',
            'Surat Keterangan Kerja Bongkar Muat',
            'Surat Keterangan Pemakaian Alat Angkat',
            'Rekomendasi Terminal Khusus untuk Kegiatan Bongkar Muat',
            'Izin Kerja Keruk',
            'Penutuhan Kepal (SKRAP)',
            'Jadwal/Trayek Kapal',
            'Pendaftaran Alat',
            'Pembukaan Kantor Cabang',
            'Penerbitan SKPT dan SPPT',
            'Legalisir Dokumen Pertanahan',
            'Penandatanganan Surat Perjanjian Pemanfaatan Lahan',
            'Endorse Izin Operasi',
        ],
    ],
    [
        'service' => 'Direktorat Infrastruktur dan Kawasan',
        'subServices' => [
            'Izin Pematangan Lahan',
            'Izin Pemanfaatan ROW',
            'Izin Reklame',
        ],
    ],
    [
        'service' => 'Pusat Perencanaan Program Strategis',
        'subServices' => [
            'Izin Rencana Tata Bangunan dan Lingkungan Hidup (Fatwa Planologi)',
            'Penerbitan Rekomendasi Perubahan Rencana Peruntukan Lokasi',
        ],
    ],
    [
        'service' => 'Pusat Data dan Sistem Informasi',
        'subServices' => [
            'Layanan Data Centre - Colocation Rack',
            'Layanan Data Centre - Bandwidth Internet',
            'Layanan Data Centre - VPN-IP',
            'Layanan Data Centre - VPN Metro-e',
            'Layanan Data Centre - Storage on Demand',
            'Layanan Data Centre - Virtual Private Server',
            'Layanan Data Centre - Managed Services',
            'Layanan Data Centre - Layanan Security',
            'Layanan Data Centre - IT Solution',
            'Layanan Terkait Data Centre - Ruangan',
            'Layanan Terkait Data Centre - Pelatihan Teknologi Informasi',
            'Jasa Lainnya - Penyusunan Modul',
            'Jasa Lainnya - Pengajar',
        ],
    ],
    [
        'service' => 'Direktorat Pelayanan Lalu Lintas Barang dan Penanaman Modal',
        'subServices' => [
            'Izin Kawasan LDP',
            'Izin Usaha Kawasan TLDDP',
            'Izin Usaha Kawasan Logistik (IUK Logistik)',
            'Izin Persetujuan Barang Impor, Barang Konsumsi Non Pembatasan',
            'Izin Persetujuan Impor Kendaraan Bermotor dari Luar Daerah Pabean',
            'Izin Persetujuan Impor Rekomendasi Kendaraan Bermotor Untuk Keperluan Uji Tipe',
            'Penerbitan Izin Importir Terdaftar Minuman Beralkohol',
            'Izin Eksportir Terdaftar Kopi',
            'Penerbitan Surat Keterangan Asal (SKA)',
            'Rekomendasi Izin Pemasukan dan Pengeluaran Barang Logistik',
            'Rekomendasi Pemasukan dan Pengeluaran Barang Dikecualikan',
            'Izin Persetujuan Impor Barang Konsumsi dalam Pembatasan',
            'Penerbitan Izin Persetujuan Impor Barang Kena Cukai dari LDP',
            'Pengawasan terhadap Pelaku Usaha yang Menerbitkan Surat Keterangan Asal',
            'Penerbitan Pengawasan Peredaran Barang Konsumsi di Kawasan Bebas Batam',
            'Barang yang Dikecualikan dari Perizinan (Sesuai PP 41/2021)',
        ],
    ],
];


    public static function getQueuePrefix($service)
    {
        return implode('', array_map(function($word) {
            return strtoupper(substr($word, 0, 1));
        }, explode(' ', $service)));
    }
} 