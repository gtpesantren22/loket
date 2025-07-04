<?php
function convNol($angka)
{
    $hasil = str_pad($angka, 3, '0', STR_PAD_LEFT);
    return $hasil; // Output: 001
}
