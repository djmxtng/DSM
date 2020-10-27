

<?php 
//activamos almacenamiento en el buffer
ob_start();
if (strlen(session_id())<1) 
  session_start();

if (!isset($_SESSION['nombre'])) {
  echo "debe ingresar al sistema correctamente para vIsualizar el reporte";
}else{

if ($_SESSION['ventas']==1) {

?>

<html>
<head>
	<meta http-equiv="content-type" content="text/html; charset=utf-8"/>
	
</head>
<body onload="window.print();">
	<?php 
// incluimos la clase venta
require_once "../modelos/Venta.php";

$venta = new Venta();

//en el objeto $rspta obtenemos los valores devueltos del metodo ventacabecera del modelo
$rspta = $venta->ventacabecera($_GET["id"]);

$reg=$rspta->fetch_object();

//establecemos los datos de la empresa
$empresa = "DISTRIBUIDORA SAN MARINO ";
$documento = "DE: HERNAN FERNANDEZ CHUMPITAZ";
$direccion = "RUC: 10413904213";
$telefono = "DIRECCION: AV UNIVERSITARIA 8960";
$email = "TELEFONO: 918385425 / 990991268";
$hoy = date('d-m-Y')  ;
$originalDate = $reg->fecha; 
$newDate = date("d-m-Y", strtotime($originalDate));
	
	if($reg->idventa<10000){$orden= $reg->idventa;}
	else{$orden=$reg->idventa-10000;}
	
	
	 ?>
<div >
	<!--codigo imprimir-->
	<br>
  <table  >
	<tr>
	  
    <tr>
      <td width="50%"><a href=" "><img src="image/logo.png" alt="" width="444" height="140" align="right"/></a></td>
	      <td width="577" align="left"><!--mostramos los datos de la empresa en el doc HTML-->
	        <strong> </strong><br>
	        <?php echo $documento; ?><br>
	        <?php echo $direccion;?><br>
			<?php echo $telefono; ?><br>
			  
	       <p align="right"><strong> Fecha: <?php echo $hoy; ?></strong></p> </td>
	      <!--?php echo $reg->fecha; ?>-->
		<td width="0"></td>
    </tr>
	    <tr>
  </table>
  	<tr><table width="2000"  class="table table-bordered">
	    <tr>
			
	      <!--mostramos los datos del cliente -->
	

	      <td width="50%">CLIENTE: <?php echo $reg->cliente; ?></td>
		  <td >TIPO DE PAGO: <?php echo $reg->tipo; ?> </td>
		  
	      
	    <tr>
	      <td><?php echo $reg->tipo_documento.": ".$reg->num_documento; ?></td>
		  <td colspan="6">FECHA DE PAGO:</td>
    </tr>
	    <tr>
	      <td> DIRECCION: <?php echo $reg->direccion; ?></td>
		  <td colspan="6"><FONT>VENDEDOR</td>
    </tr>
	    <tr>
	      <td> N° de Orden:<?php echo $reg->ORDEN;?></td>
			<td colspan="6"><?php echo $reg->vendedor;?> </td>
    </tr>
			</table>
  </tr>
      
	<br>

	<!--mostramos lod detalles de la venta -->

	<div>
		<link href="css/bootstrap.css" rel="stylesheet" />
	  <table  class="table table-bordered">
	    <tr>
	      <td width="136">CANT.</td>
		  <td width="136">POR</td>
	      <td width="623">DESCRIPCION</td>
	      <td width="188">PRECIO UN</td>
		  <td width="188">DESCUENTO</td>
	      <td width="184" align="right">TOTAL</td>
        </tr>
	    <?php
		$rsptad = $venta->ventadetalles($_GET["id"]);
		$cantidad=0;
		while ($regd = $rsptad->fetch_object()) {
		 	echo "<tr>";
		 	echo "<td>".$regd->cantidad."</td>";
			echo "<td>".$regd->por."</td>";
		 	echo "<td>".$regd->articulo."</td>";
			echo "<td align='right'>S/. ".$regd->precioU."</td>";
			echo "<td align='right'>S/. ".$regd->DESCUENTO."</td>";
		 	echo "<td align='right'>S/. ".$regd->subtotal."</td>";
		 	echo "</tr>";
		 	$cantidad+=$regd->cantidad;
		 } 

		 ?>
	    <!--mostramos los totales de la venta-->
	    <tr>
	      <td height="">&nbsp;</td><td height="">&nbsp;</td>
	      <td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
			<td align="right">&nbsp;</td>
	      <td align="right"><b>S/. <?php echo $reg->total_venta; ?></b></td>
        </tr>
		  </table>
		</div>
	
		<link href="css/bootstrap.css" rel="stylesheet" />
		<tr>
	      <td colspan="2">N° de articulos: <?php echo $cantidad; ?></td>
	      </tr>
		<table width="56%" border="1px" bordercolordark="#000000">
	    
	    <tr>
	      <td colspan="3" align="center">TRANSFERENCIA O DEPOSITOS </td>
	      </tr>
	    <tr>
			<td width="255" colspan="1" align="ringht">BANCO SCOTIABANK</td>
			<td width="234" colspan="1" align="center">679-0055526</td>
			
		</tr>
		<tr>
			<td colspan="1" align="ringht">BANCO CONTINENTAL</td>
			<td colspan="1" align="center">0011-0814-0201844806</td>
		</tr>
		<tr>
			<td colspan="1" align="ringht">BANCO  DE CREDITO</td>
			<td colspan="1" align="center">191-9642-8805031</td>
		</tr>
			<tr>
			<td colspan="1" align="ringht">YAPE</td>
			<td colspan="1" align="center">918385425</td>
		</tr>
			
			<tr>
			<td colspan="1" align="center">USO ADMINISTRATIVO</td>
			
		</tr>
      </table>
  
	
</div>

</body>
</html>



<?php

	}else{
echo "No tiene permiso para visualizar el reporte";
}

}


ob_end_flush();
  ?>