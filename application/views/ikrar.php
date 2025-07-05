<?php

$bl = array("", "Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember");
$date = date('d') . "-" . date('F') . "-" . date('Y');

$nama = strlen($data->nama);
$pc = explode(' ', $data->nama);
$jml = count($pc);


if ($nama > 18) {
    if ($jml == 2) {
        $nm_ok = $pc[0] . ' ' . substr($pc[1], 0, 1) . '.';
    } elseif ($jml == 3) {
        $nm_ok = $pc[0] . ' ' . $pc[1] . ' ' . substr($pc[2], 0, 1) . '.';
    } elseif ($jml == 4) {
        $nm_ok = $pc[0] . ' ' . $pc[1] . ' ' . substr($pc[2], 0, 1) . '. ' . substr($pc[3], 0, 1) . '.';
    } elseif ($jml == 5) {
        $nm_ok = $pc[0] . ' ' . $pc[1] . ' ' . substr($pc[2], 0, 1) . '. ' . substr($pc[3], 0, 1) . '. ' . substr($pc[4], 0, 1) . '.';
    } elseif ($jml == 6) {
        $nm_ok = $pc[0] . ' ' . $pc[1] . ' ' . substr($pc[2], 0, 1) . '. ' . substr($pc[3], 0, 1) . '. ' . substr($pc[4], 0, 1) . '.' . substr($pc[5], 0, 1) . '.';
    } elseif ($jml == 7) {
        $nm_ok = $pc[0] . ' ' . $pc[1] . ' ' . substr($pc[2], 0, 1) . '. ' . substr($pc[3], 0, 1) . '. ' . substr($pc[4], 0, 1) . '.' . substr($pc[5], 0, 1) . '.' . substr($pc[6], 0, 1) . '.';
    }
} else {
    $nm_ok = $data->nama;
}

?>

<div class="wrapperku">
    <div class="row">
        <div class="col-lg-12">
            <div class="panel-body">
                <table width="100%" border="0">
                    <tr>
                        <td rowspan="3">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
                        <td rowspan="3" style="text-align: center;"><img src="<?= base_url('assets/img/logo1.png') ?>" width=" 130">
                        </td>
                        <td colspan="5" style="font-size: 25px; text-align: left;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;المعهد الإسلامى دار اللغة
                            والكرامة</td>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-size: 20px; text-align: left;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;PP DARUL LUGHAH WAL
                            KAROMAH
                        </td>
                    </tr>
                    <tr>
                        <td colspan="5" style="font-size: 18px; text-align: left;">
                            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Sidomukti Kraksaan
                            Probolinggo</td>
                    </tr>
                    <tr height="10px">
                        <td colspan="9"></td>
                    </tr>
                    <tr height="20px">
                        <td colspan="9" style="text-align: center; font-size: 10px; border: solid 1px; ">
                            <i style="text-align: center;">sekretariat : Jl. Myjend Pandjaitan No. 12 Sidomukti
                                Kraksaan Probolinggo Jawa Timur
                                No.
                                HP : 0823 3048 7887</i>
                        </td>
                    </tr>
                    <tr height="10px">
                        <td colspan="9"></td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: center; font-size: 12px; font-weight: bold;">IKRAR SANTRI
                            BARU</td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: center; font-size: 12px; font-weight: bold;">PP. DARUL
                            LUGHAH WAL KAROMAH
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: center; font-size: 12px; font-weight: bold;">TAHUN AJARAN
                            2023-2024</td>
                    </tr>
                    <tr height="10px">
                        <td colspan="9"></td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: center; font-size: 20px; font-weight: bold;">بِسْمِ اللهِ
                            الرَّحْمَنِ الرَّحِيْمِ
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: center; font-size: 20px; font-weight: bold;">أَشْهَدُ أَنْ
                            لاَ إِلَهَ إِلاَّ اللهُ وَأَشْهَدُ أَنَّ مُحَمَّدًا رَسُوْلُ اللَّهِ</td>
                    </tr>
                    <tr>
                        <td colspan="9">Yang bertanda tangan dibwah ini :</td>
                    </tr>
                    <!-- <tr>
                        <td>&nbsp;</td>
                        <td colspan="9"></td>
                    </tr> -->
                    <tr>
                        <td>&nbsp;</td>
                        <td>Nama </td>
                        <td colspan="8"> : <?= $data->nama; ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Tetala </td>
                        <td colspan="8"> : <?= $data->tempat; ?>, <?= tanggalIndo($data->tanggal); ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Alamat </td>
                        <td colspan="8"> : <?= $data->desa; ?> - <?= $data->kec; ?> -
                            <?= $data->kab; ?></td>
                    </tr>
                    <!-- <tr>
                        <td>&nbsp;</td>
                        <td colspan="9"></td>
                    </tr> -->
                    <tr>
                        <td colspan="9">Dengan ini kami berjanji, bahwa setelah kami berada di Pondok Pesantren Darul
                            Lughah Wal Karomah :</td>
                    </tr>
                    <!-- <tr height="10px">
                        <td colspan="9"></td>
                    </tr> -->
                    <tr>
                        <td colspan="9">1. Saya bersedia menetap di Pondok Pesantren Darul Lughah Wal Karomah.</td>
                    </tr>
                    <tr>
                        <td colspan="9">2. Saya bersedia untuk patuh dan taat pada Pengasuh dan Pengurus Peasantren
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9">3. Saya bersedia mematuhi dan melaksanakan semua peraturan-peraturan dan
                            ketentuan pesantren.</td>
                    </tr>
                    <tr>
                        <td colspan="9">4. Saya bersedia menyelesaikan semua permasalahan dalam pesantren dengan
                            musyawarah mufakat tanpa melibatkan pihak luar</td>
                    </tr>
                    <tr height="10px">
                        <td colspan="9"></td>
                    </tr>
                    <tr>
                        <td colspan="9">Pernytaan ikrar ini kami tanda tangani tanpa ada paksaan dari pihak manapun,
                            tapi atas dasar keikhlasan kami.</td>
                    </tr>
                    <!--<tr>-->
                    <!--    <td colspan="9">&nbsp;</td>-->
                    <!--</tr>-->
                    <tr>
                        <td colspan="9">Yang menanggung saya adalah orang tua / wali :</td>
                    </tr>
                    <!-- <tr>
                        <td>&nbsp;</td>
                        <td colspan="9"></td>
                    </tr> -->
                    <tr>
                        <td>&nbsp;</td>
                        <td>Nama</td>
                        <td colspan="8"> : <?= $data->bapak; ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Pekerjaan</td>
                        <td colspan="8"> : <?= $data->a_pkj; ?></td>
                    </tr>
                    <tr>
                        <td>&nbsp;</td>
                        <td>Alamat</td>
                        <td colspan="8"> : <?= $data->desa; ?> - <?= $data->kec; ?> -
                            <?= $data->kab; ?></td>
                    </tr>
                    <tr height="10px">
                        <td colspan="9"></td>
                    </tr>
                    <tr>
                        <td colspan="9">Pernytaan ikrar ini kami tanda tangani tanpa ada paksaan dari pihak manapu,
                            tapi atas dasar keihlasan kami.</td>
                    </tr>
                    <tr height="10px">
                        <td colspan="9"></td>
                    </tr>
                    <tr>
                        <td colspan="9">Ikrar ini saya buat dengan sebenar-benarnya serta penuh kesadaran serta siap
                            bertanggung jawab apabila terjadi pelanggaran di kemudian hari.</td>
                    </tr>
                    <tr height="10px">
                        <td colspan="9"></td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: center; font-size: 20px; font-weight: bold;">رَضِيتُ بِاللهِ
                            رَبًّا، وَبِاْلإِسْلاَمِ دِينًا، وَبِمُحَمَّدٍ نَبِيًّا
                        </td>
                    </tr>
                    <tr>
                        <td colspan="9" style="text-align: center; font-size: 20px; font-weight: bold;">لَا حَوْلَ
                            وَلَا قُوَّةَ إِلَّا بِاللهِ العَلِيِّ العَظِيْمِ</td>
                    </tr>
                    <tr height="10px">
                        <td colspan="9"></td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="4"></td>
                        <td colspan="3">Kraksaan, <?= $date; ?></td>
                    </tr>
                    <tr>
                        <td colspan="2">Wali Santri</td>
                        <td colspan="4"></td>
                        <td colspan="3">Yang Membuat Pernyataan</td>
                    </tr>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                    <!-- <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr> -->
                    <tr>
                        <td colspan="2"><b><u><?= $data->bapak ?></u></b></td>
                        <td colspan="4" style="text-align: center;">Mengetahui,</td>
                        <td colspan="3"><b><u><?= $nm_ok; ?></u></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">Saksi</td>
                        <td colspan="4"></td>
                        <td colspan="3">Pengasuh Pondok Pesantren</td>
                    </tr>
                    <tr>
                        <td colspan="2"></td>
                        <td colspan="4"></td>
                        <td colspan="3">Darul Lughah Wal Karomah</td>
                    </tr>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr>
                    <!-- <tr>
                        <td colspan="9">&nbsp;</td>
                    </tr> -->
                    <tr>
                        <td colspan="2"><b><u><?= $user; ?></u></b></td>
                        <td colspan="4"></td>
                        <td colspan="3"><b>_______________________</b></td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</div>
<?php
//footer
echo "<script>window.print()</script>";
?>
<!-- da -->