<?php 
	if(!isset($bien_bao_mat)){exit();}
	include("ket_noi.php");	
?>
<?php 
	$id=$_GET['id'];	
	$tv="select * from slideshow where id='$id' ";
	$tv_1=pg_query($conn,$tv);
	$tv_2=pg_fetch_array($tv_1);

	$link_hinh="../hinh_anh/slideshow/".$tv_2['hinh'];
	if(is_file($link_hinh))	
	{
		unlink($link_hinh);
	}
	
	$tv="DELETE FROM slideshow WHERE id = $id ";
	pg_query($conn,$tv);
?>