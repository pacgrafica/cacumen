<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>Sum of all TextBox values using jQuery</title>
<script src="//code.jquery.com/jquery-1.11.2.min.js"></script>
<script src="//code.jquery.com/jquery-migrate-1.2.1.min.js"></script>

<script type="text/javascript">
function calcular(i)
{
	unitario=$("#unitario"+i).val();
	if(unitario=='') unitario=0;
	
	valor=$("#valor"+i).val();
	if(valor=='') valor=0;
	
	total=valor*unitario;
	$("#total"+i).val(total);
	}
</script>
</head>
<body>
<input name="" type="text">
<input name="unitario1" type="text" id="unitario1" onKeyUp="calcular(1)">
<input name="valor1"  type="text" step="0.01"  id="valor1" onKeyUp="calcular(1)">
<input name="total1" type="text"  id="total1" readonly>
<br><br>

<input name="" type="text">
<input name="unitario2" type="text" id="unitario2" onKeyUp="calcular(2)">
<input name="valor2" type="text" id="valor2" onKeyUp="calcular(2)">
<input name="total2" type="text" id="total2" readonly>



</body>
</html>