<?php 
//activamos almacenamiento en el buffer
ob_start();
if (strlen(session_id())<1) 
  session_start();

if (!isset($_SESSION['nombre'])) {
  echo "debe ingresar al sistema correctamente para vosualizar el reporte";
}else{

if ($_SESSION['ventas']==1) {

?>

<html>
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8"/>
	<link rel="stylesheet" href="../public/css/ticket.css">
	<style type="text/css">
	body,td,th {
    font-family: Consolas, "Andale Mono", "Lucida Console", "Lucida Sans Typewriter", Monaco, "Courier New", monospace;
}
    </style>
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
	 ?>
<DIV >
	<!--codigo imprimir-->
	<br>
	<table width="286" border="0" align="center" class="cabecera" >
		<tr>
			<td width="286" align="center">
				<!--mostramos los datos de la empresa en el doc HTML-->
				.:<strong> <?php echo $empresa; ?></strong>:.<br>
				<?php echo $documento; ?><br>
	        <?php echo $direccion;?><br>
			<?php echo $telefono; ?><br>
				<?php echo $hoy; ?><br>
			</td>
		</tr>
		<tr> 
			<td align="center"></td>
		</tr>
		</tr>
		  <td align="center">==========================================</td>
		</tr>
		<tr>
			<!--mostramos los datos del cliente -->
			<td align="center"><strong>NOTA DE VENTA
			</strong></td>
		</tr>
	<tr>
			<td align="center">
				 <?php echo $reg->ORDEN;?>
			</td>
		</tr>
<tr>
		  <td align="center">=========================================</td>
		</tr>

		
		
		
		</table>
	
		<table width="287" border="0" align="center">
	<tr>
			<!--mostramos los datos del cliente -->
			<td width="87"><h4>Cliente:
			</td>
			<td width="190" colspan="4"> <?php echo $reg->cliente; ?>
			</td>
		</tr>
		<tr>
			<td><h4>
				<?php echo $reg->tipo_documento; ?>:
		  </td>
			<td colspan="4">
				<?php echo $reg->num_documento; ?>
			</td>
		</tr>
		<tr>
			<td><h4>
				Direccion: 
			</td>
			<td colspan="4">
				<?php echo $reg->direccion; ?>
			</td>
		</tr>
		<tr>
			<td><h4>
				 Tipo de Pago:
			</td>
			<td colspan="4">
				 <?php echo $reg->tipo;?>
			</td>
		</tr>
		<tr>
			<td><h4>
				 Vendedor:
			</td>
			<td colspan="4">
				 <?php echo $reg->vendedor;?>
			</td>
		</tr>
	
  </table>

	<!--mostramos lod detalles de la venta -->

	<table width="321" border="0" align="center" class="detalle">
		
	
	<br>
		<tr ><FONT size="2">
			<td width="36" ><h4>cant.</td>
			<td colspan="2" align="center" ><h4>Articulo</td>
			<td width="52" align="center"><h4>Precio</td>
			
			<td width="67"   align="center"><h4>Sub. Total</td>
			
		</FONT>
		</tr>
		<tr>
			<td colspan="6">===========================================</td>
		</tr>
		<?php
		$rsptad = $venta->ventadetalles($_GET["id"]);
		$cantidad=0;
		while ($regd = $rsptad->fetch_object()) {
		 	echo "<tr> <FONT size='2'>";
		 	echo "<td>".$regd->cantidad."</td>";
		 	echo "<td colspan='2'> ".$regd->articulo."</td>";
			echo "<td align='right'>S/".$regd->precioU."</td>";
		 	echo "<td align='right'>S/".$regd->subtotal."</td>";
		 	echo "</FONT></tr>";
		 	$cantidad+=$regd->cantidad;
		 } 

		 ?>
		 <!--mostramos los totales de la venta-->
		<tr>
			<td colspan="6">===========================================</td>
		</tr>
		<tr>
			<td>&nbsp;</td>
			<td width="80">&nbsp;</td>
			
			
			<td align="right"><b>desc:</b></td>
			
			<td align="right" colspan="2"><b>S/ <?php echo $reg->DESCUENTOT; ?></b></td>
			
		</tr>
		<tr>
			<td>&nbsp;</td>
			
			
			<td>&nbsp;</td>
			<td align="right"><b>TOTAL:</b></td>
			<td align="right" colspan="2"><b>S/ <?php echo $reg->total_venta; ?></b></td>
			
		</tr>
		<tr>
			<td colspan="3">N° de articulos: <?php echo $cantidad; ?> </td>
			
		</tr>
		<tr>
			<td colspan="4">&nbsp;</td>
		</tr>
		<tr>
	      <td colspan="4"align="center">TRANSFERENCIA O DEPOSITOS </td>
      </tr>
	    <tr>
			<td colspan="2" align="ringht">BANCO SCOTIABANK</td>
			<td colspan="2" align="center">679-0055526</td>
			
			
		</tr>
		<tr>
			<td colspan="2" align="ringht">BANCO CONTINENTAL</td>
			<td colspan="2" align="center">0011-0814-0201844806</td>
			
		</tr>
		<tr>
			<td colspan="2" align="ringht">BANCO  DE CREDITO</td>
			<td colspan="2" align="center">191-9642-8805031</td>
			
		</tr>
			<tr>
			<td colspan="2" align="ringht">YAPE</td>
			<td colspan="2" align="center">918385425</td>
			
	    </tr>
  </table>
	<br>
</DIV>
<p>&nbsp;</p>
</body>
</html>



<?php

	}else{
echo "No tiene permiso para visualizar el reporte";
}

}


ob_end_flush();
  ?>