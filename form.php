<!DOCTYPE html>
<html>
<head>
	<title>FORM</title>
	<link rel="stylesheet" type="text/css" href="">
	<style type="text/css">
		
		.color1{
			color: #231F20;
		}
		.center{
			text-align: center;
		}
		.alert{
			color:red;
		}
		.card {
	    /* Add shadows to create the "card" effect */
	    	background-color: #F3DFA2;
	    	margin-left: 25%;
		    box-shadow: 0 4px 8px 0 rgba(0,0,0,0.2);
		    transition: 0.3s;
		    width: 50%;
		    border-radius: 10px;

		}

		/* On mouse-over, add a deeper shadow */
		.card:hover {
		    box-shadow: 0 12px 16px 0 rgba(0,0,0,0.2);
		}

		/* Add some padding inside the card container */
		.container {
		    padding: 2px 16px;
		}
		.btn{
			transition: all 0.5s;
		  	cursor: pointer;
			border: none;
		    color: #EFE6DD;
		    padding: 5px 9px;
		    font-size: 16px;
		    cursor: pointer;
		    margin: 10px;
		    background-color: #231F20;
		}
		.btn:hover{
			box-shadow: 0 8px 16px 0 rgba(0,0,0,0.2);
		}



		.btn span {
		  cursor: pointer;
		  display: inline-block;
		  position: relative;
		  transition: 0.5s;
		}

		.btn span:after {
		  content: '\00bb';
		  position: absolute;
		  opacity: 0;
		  top: 0;
		  right: -20px;
		  transition: 0.5s;
		}

		.btn:hover span {
		  padding-right: 25px;
		}

		.btn:hover span:after {
		  opacity: 1;
		  right: 0;
		}
		body{
			background-color: #BB4430;
		}
	</style>
</head>
<body>
<?php
  $valid=false;
  $error['namaErr'] = $error['jenisKelaminErr'] = $error['provinsiErr'] = $error['kabkotErr']=$error['ukmErr']=$error['tinggiErr']=$error['emailErr'] = " ";
  $data['nama'] = $data['jenisKelamin'] = $data['provinsi'] = $data['kabkot']=$data['tinggi']=$data['email'] = "";
  $data['ukm']=array("0"=>"Tidak memiliki UKM");
  if ($_SERVER["REQUEST_METHOD"] == "POST") {
  	$valid=true;
  	if (empty($_POST["nama"])) {
	    $error['namaErr'] = "Nama harus diisi";
	    $valid=false;
	} else {
	    	$data['nama'] = test_input($_POST["nama"]);
	}

  	if (empty($_POST["jenisKelamin"])) {
	    $error['jenisKelaminErr'] = "Jenis kelamin harus diisi";
	    $valid=false;
  	} else {
    	$data['jenisKelamin'] = test_input($_POST["jenisKelamin"]);
  	}

  	if (empty($_POST["provinsi"])) {
	    $error['provinsiErr'] = "Provinsi harus diisi";
	    $valid=false;
  	} else {
    	$data['provinsi']= test_input($_POST["provinsi"]);
  	}

  	if (empty($_POST["kabkot"])||$_POST["kabkot"]=='Kabupaten/Kota') {
	    $error['kabkotErr'] = "Kabupaten/Kota harus diisi";
	    $valid=false;
 	} else {
  	  $data['kabkot'] = test_input($_POST["kabkot"]);
 	}

  	if (empty($_POST["tinggi"])) {
	    $error['tinggiErr'] = "Tinggi badan harus diisi";
	    $valid=false;
  	} else {
    	$data['tinggi'] = test_input($_POST["tinggi"]);
 	}

 	if (empty($_POST["email"])) {
	    $error['emailErr'] = "Email harus diisi";
	    $valid=false;
  	} else {
    	$data['email'] = test_input($_POST["email"]);
  	}
  	if (empty($_POST["ukm"])) {

  	} else {
    	$data['ukm'] = $_POST["ukm"];
  	}
  }
  

  function test_input($data) {
  $data = trim($data);
  $data = stripslashes($data);
  $data = htmlspecialchars($data);
  return $data;
  }
  session_start();
  $_SESSION['data']=$data;

  if ($valid) {
  	
  	header("Location:hasil.php");
  }
?>
<div class="card">
	<h1 class="center color1">FORM IDENTITAS</h1>
	<form method="post" action=<?php $_SERVER['PHP_SELF'] ?>>
		<table class="color1">
		<tr>
			<td>Nama</td><td>:</td><td><input type="text" name="nama" value="<?php echo $data['nama']?>"><span class="alert"> *<?php echo $error['namaErr']?></span></td>
		</tr>
		<tr>
			<td>Jenis Kelamin</td><td>:</td><td><input type="radio" name="jenisKelamin" <?php if (isset($data['jenisKelamin']) && $data['jenisKelamin'] == "Laki-Laki") echo "checked"; ?> value="Laki-Laki">Laki-Laki<input type="radio" name="jenisKelamin" <?php if (isset($data['jenisKelamin']) && $data['jenisKelamin'] == "Perempuan") echo "checked"; ?> value="Perempuan">Perempuan <span class="alert"> *<?php echo $error['jenisKelaminErr']?></span></td>
		</tr>
		<tr>
			<td><label for="prov">Provinsi</td><td>:</td><td>
			<select name="provinsi" id='provinsi' onchange="showKabupaten()">
				<option selected disabled>Provinsi</option>
				<option value="31" <?php if(isset($data['provinsi'])&&$data['provinsi']=="31") echo "selected";?>>DKI Jakarta</option>
				<option value="32" <?php if(isset($data['provinsi'])&&$data['provinsi']=="32") echo "selected";?>>Jawa Barat</option>
				<option value="33" <?php if(isset($data['provinsi'])&&$data['provinsi']=="33") echo "selected";?>>Jawa Tengah</option>
			</select> <span class="alert"> *<?php echo $error['provinsiErr']?></td>
	
		</tr>
		<tr>
			<td>Kabupaten/Kota</td><td>:</td><td>
			<select name="kabkot" id="kabkot">
				<?php/*
					$jakarta=array('31001'=>'Jakarta Utara','31002'=>'Jakarta Timur','31003'=>'Jakarta Barat','31004'=>'Jakarta Pusat','31005'=>'Jakarta Selatan');
					$jabar = array('32001' => 'Kuningan','32002' => 'Bandung','32003' => 'Tasikmalaya','32004' => 'Purwakarta','32005' => 'Sukabumi' );
					$jateng = array('33001' =>'Semarang' ,'33002' =>'Tegal','33003' =>'Solo','33004' =>'Purworejo','33005' =>'Kudus' );
				*/?>
				<option selected="selected">Kabupaten/Kota</option>
				<option value="31001" <?php if(isset($data['kabkot'])&&$data['kabkot']=="31001") echo "selected";?>>Jakarta Utara</option>
				<option value="31002" <?php if(isset($data['kabkot'])&&$data['kabkot']=="31002") echo "selected";?>>Jakarta Timur</option>
				<option value="31003" <?php if(isset($data['kabkot'])&&$data['kabkot']=="31003") echo "selected";?>>Jakarta Barat</option>
				<option value="31004" <?php if(isset($data['kabkot'])&&$data['kabkot']=="31004") echo "selected";?>>Jakarta Pusat</option>
				<option value="31005" <?php if(isset($data['kabkot'])&&$data['kabkot']=="31005") echo "selected";?>>Jakarta Selatan</option>
				<option value="32001" <?php if(isset($data['kabkot'])&&$data['kabkot']=="32001") echo "selected";?>>Kuningan</option>
				<option value="32002" <?php if(isset($data['kabkot'])&&$data['kabkot']=="32002") echo "selected";?>>Bandung</option>
				<option value="32003" <?php if(isset($data['kabkot'])&&$data['kabkot']=="32003") echo "selected";?>>Tasikmalaya</option>
				<option value="32004" <?php if(isset($data['kabkot'])&&$data['kabkot']=="32004") echo "selected";?>>Purwakarta</option>
				<option value="32005" <?php if(isset($data['kabkot'])&&$data['kabkot']=="32005") echo "selected";?>>Sukabumi</option>
				<option value="33001" <?php if(isset($data['kabkot'])&&$data['kabkot']=="33001") echo "selected";?>>Semarang</option>
				<option value="33002" <?php if(isset($data['kabkot'])&&$data['kabkot']=="33002") echo "selected";?>>Tegal</option>
				<option value="33003" <?php if(isset($data['kabkot'])&&$data['kabkot']=="33003") echo "selected";?>>Solo</option>
				<option value="33004" <?php if(isset($data['kabkot'])&&$data['kabkot']=="33004") echo "selected";?>>Purworejo</option>
				<option value="33005" <?php if(isset($data['kabkot'])&&$data['kabkot']=="33005") echo "selected";?>>Kudus</option>
				<?php
					//if(isset($data['provinsi'])){
					/*
						if ($data['provinsi']=='31') {
							$kabkot=$jakarta;
						} elseif ($data['provinsi']=='32') {
							$kabkot=$jabar;
						} elseif ($data['provinsi']=='33') {
							$kabkot=$jateng;
						}
						foreach ($kabkot as $id => $value) {
							echo "<option value=".$id." ";
							if(isset($data['kabkot'])&&$data['kabkot']==$id) echo "selected";
							echo ">".$value."</option>";
						}*/
					//}
				?>
			</select> <span class="alert"> *<?php echo $error['kabkotErr']?></td>
		</tr>
		
		<tr>
			<td>UKM</td><td>:</td><td>
			<input type="checkbox" name="ukm[]" value="forkas" <?php if(in_array("forkas", $data['ukm'])=='1') echo "checked"; ?>>FORKAS
			<input type="checkbox" name="ukm[]" value="komnet" <?php if(in_array("komnet", $data['ukm'])=='1') echo "checked";?>>KOMNET
			<input type="checkbox" name="ukm[]" value="bimbel" <?php if(in_array("bimbel", $data['ukm'])=='1') echo "checked";?>>Bimbel
			</td><td></td>
		</tr>
		<tr>
			<td>Tinggi Badan</td><td>:</td><td><input type="number" name="tinggi" value="<?php echo $data['tinggi']?>"> <span class="alert"> *<?php echo $error['tinggiErr']?></td>
		</tr>
		<tr>
			<td>Email</td><td>:</td><td><input type="email" name="email" value="<?php echo $data['email']?>">  <span class="alert"> *<?php echo $error['emailErr']?></td>
		</tr>
	
		
	
	</table>
	<button type="submit" class="btn"><span>Submit</span></button><input class="btn" type="reset" name="reset">
	</form>
</div>
	


	<script>

		var provinsi = document.getElementById("provinsi");
		var kabupaten=document.getElementById("kabkot");
		
		function showKabupaten() {
			kabupaten.value="Kabupaten/Kota";
			for (var i = 0; i < kabupaten.children.length; i++) {
				var kodeKab=kabupaten.children[i].value;
				if(kodeKab.startsWith(provinsi.value)){
					kabupaten.children[i].style.display="block";
				}else{
					kabupaten.children[i].style.display="none";
				}
			}
		}

	</script>
</body>
</html>
