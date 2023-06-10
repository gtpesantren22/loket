<!-- <div class="row">
	<div class="col-md-3"></div>
	<div class="col-md-6">
		<div class="box">
			<div class="loket">
				Nomer Antrian Anda
			</div>
			<div class="agenda">
				<h1 id="nomer"><?php echo $antrian->row('no_antrian');
								if ($antrian->row('no_antrian') < 1) {
									$antri = 1;
								} else {
									$antri = $antrian->row('no_antrian') + 1;
								}
								?>
				</h1>
				<br>
			</div>
		</div>
	</div>
</div>
<script type="text/javascript">
	print();
	// location = "<?php echo base_url('welcome/antrian/'); ?>"
</script> -->


<script type="text/javascript">
	window.print();
</script>
<!-- <link href="<?php echo base_url('assets/user') ?>/vendor/fontawesome-free/css/all.min.css" rel="stylesheet" type="text/css"> -->
<link href="https://fonts.googleapis.com/css?family=Montserrat:400,700" rel="stylesheet" type="text/css">
<link href="https://fonts.googleapis.com/css?family=Lato:400,700,400italic,700italic" rel="stylesheet" type="text/css">

<!-- Theme CSS -->
<link href="<?php echo base_url('assets/print') ?>/css/freelancer.min.css" rel="stylesheet">
<link href="<?php echo base_url('assets/print') ?>/lib/noty.css" rel="stylesheet">
<link href="<?php echo base_url('assets/print') ?>/lib/themes/metroui.css" rel="stylesheet">

<div class="card" style="width: 17rem;">
	<ul class="list-group list-group-flush">
		<li class="list-group-item text-center">
			<h5>PSB 2023</h5>
			<h8>Panitia Penerimaan Santri Baru</h8>
			<small>PonPes Darul Lughah Wal Karomah</small>
		</li>
		<li class="list-group-item text-center">
			<h5>NO. ANTRIAN</h5>
			<h1 style="font-size: 90px;"><?php echo $antrian->row('no_antrian');
											if ($antrian->row('no_antrian') < 1) {
												$antri = 1;
											} else {
												$antri = $antrian->row('no_antrian') + 1;
											}
											?></h1>
			<h6><?= date('d M Y') . ' ' . date('H:i') ?></h6>
		</li>
		<li class="list-group-item text-center">
			<h5>TERIMAKASIH</h5>
			<small>Semoga Barokah. Aminn</small>
		</li>
	</ul>
</div>
<?php

?>