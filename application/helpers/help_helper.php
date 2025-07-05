<?php
function convNol($angka)
{
    $hasil = str_pad($angka, 3, '0', STR_PAD_LEFT);
    return $hasil; // Output: 001
}
function tanggalIndo($tanggal)
{
    $a = explode('-', $tanggal);
    $tanggal = $a['2'] . " " . bulan($a['1']) . " " . $a['0'];
    return $tanggal;
}
function tanggalIndo2($tanggal)
{
    $a = explode('-', $tanggal);
    $tanggal = $a['0'] . " " . bulan($a['1']) . " " . $a['2'];
    return $tanggal;
}
function bulan($bulan)
{
    switch ($bulan) {
        case 0:
            $bulan = "";
            break;
        case 1:
            $bulan = "Januari";
            break;
        case 2:
            $bulan = "Februari";
            break;
        case 3:
            $bulan = "Maret";
            break;
        case 4:
            $bulan = "April";
            break;
        case 5:
            $bulan = "Mei";
            break;
        case 6:
            $bulan = "Juni";
            break;
        case 7:
            $bulan = "Juli";
            break;
        case 8:
            $bulan = "Agustus";
            break;
        case 9:
            $bulan = "September";
            break;
        case 10:
            $bulan = "Oktober";
            break;
        case 11:
            $bulan = "November";
            break;
        case 12:
            $bulan = "Desember";
            break;
        default:
            $bulan = Date('F');
            break;
    }
    return $bulan;
}
