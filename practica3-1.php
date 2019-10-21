 <?php
//conexion BD
$mysqli = new mysqli("localhost", "root") or die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($mysqli,"mysql") or die(mysqli_error($mysqli));

//Creacion de tablas y datos
$tabla1="create table videojuego (videojuego_id int not null auto_increment,videojuego_nombre varchar(255) not null,videojuego_genero int not null,videojuego_companyia int not null,primary key (videojuego_id))";
$tabla2="create table genero (videojuego_genero int not null auto_increment, genero varchar(255) not null, primary key(videojuego_genero))";
$tabla3="create table companyia (videojuego_companyia int not null auto_increment, companyia varchar(255) not null, primary key(videojuego_companyia))";
$insert1="insert into genero (videojuego_genero,genero) values (1,'accion'),(2,'aventura'),(3,'deporte'),(4,'First person shooter')";
$insert2="insert into companyia (videojuego_companyia,companyia) values (1,'2k'),(2,'RockStar'),(3,'Electronic Arts')";
$insert3="insert into videojuego values (1,'NBA 2K20',3,1),(2,'Borderland 3',4,2),(3,'FIFA',3,3),(4, 'Uncharted', 2, 3),(5,'GTA v',4,2),(6,'madden',3,3)";

/*
mysqli_query($mysqli,$tabla1) or die (mysqli_error($mysqli));
mysqli_query($mysqli,$tabla2) or die (mysqli_error($mysqli));
mysqli_query($mysqli,$tabla3) or die (mysqli_error($mysqli));
mysqli_query($mysqli,$insert1) or die (mysqli_error($mysqli));
mysqli_query($mysqli,$insert2) or die (mysqli_error($mysqli));
mysqli_query($mysqli,$insert3) or die (mysqli_error($mysqli));
*/



$noRegistros = 2; 
$pagina = 1; 
$buskr="";
if($_GET['pagina']){
    $pagina = $_GET['pagina']; 
    $buskr=$_GET['searchs'];   
}

$query = "SELECT videojuego_id,videojuego_nombre,genero,companyia FROM videojuego, genero, companyia WHERE
          videojuego_nombre LIKE '%$buskr%' and videojuego.videojuego_genero=genero.videojuego_genero and videojuego.videojuego_companyia=companyia.videojuego_companyia LIMIT ".($pagina-1)*$noRegistros.",$noRegistros";
$result = mysqli_query($mysqli,$query) or die(mysqli_error($mysqli));

echo "<table >";
while($row = mysqli_fetch_array($result)) {
   echo "<tr>";
        echo "<td height=80 align=center><a href='practica4-1.php?id=".$row['videojuego_id']."' target='_blank'>". $row['videojuego_id']."</a></td>";
        echo "<td align=center>".$row['videojuego_nombre']."</td>";
        echo "<td align=center>".$row['genero']."</td>";
        echo "<td align=center>".$row['companyia']."</td";
    echo "</tr>";
}
$sSQL = "SELECT count(*) FROM videojuego WHERE videojuego_nombre LIKE '%$buskr%'";

$result = mysqli_query($mysqli,$sSQL);
$row = mysqli_fetch_array(mysqli_query($mysqli,$sSQL));
$totalRegistros = $row["count(*)"]; 

$noPaginas = $totalRegistros/$noRegistros; 

echo "<tr>";
echo "<td><strong>Total registros:";
echo "</strong>".$totalRegistros."</td>";
echo "<td >Pagina:";
echo "</strong>".$pagina."</td>";
echo "</tr>";
echo "<tr>";
echo "<td><strong>Pagina:";

for($i=1; $i<$noPaginas+1; $i++) { 
if($i == $pagina)
echo "<font color=red>$i </font>"; 
else
echo "<a href=\"?pagina=".$i."&searchs=".
$buskr."\" style=color:#000;> ".$i."</a>";
}

echo "</strong></td>";
echo "</tr>";
echo "</table><hr>";

?>
