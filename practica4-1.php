<?php
//conexion BD
$mysqli = new mysqli("localhost", "root") or die ('Unable to connect. Check your connection parameters.');
mysqli_select_db($mysqli,"mysql") or die(mysqli_error($mysqli));

$tablacomentarios="create table comments (comment_id int not null,videojuego_id int not null, date date not null, persona varchar(255) not null,coment varchar(255) not null, rating float not null, primary key (comment_id))";
$insert="insert into comments values 
(1,1,'2019/05/05','M. Rajoy','¿Ustedes piensan antes de hablar o hablan tras pensar?',5),
(2,1,'2017/08/05','Ralph wiggunm','Soy un unicornio retrasado',3),
(3,1,'2010/06/10','Albert Einstein','Dos cosas son infinitas: el Universo y la estupidez humana; y yo no estoy seguro sobre el Universo.',2),
(4,2,'2009/10/06','Platon','Los sabios hablan porque tienen algo que decir. Los tontos hablan porque tienen que decir algo.',2),
(5,2,'2012/04/04','Charles Chaplin','Ríe y el mundo reirá contigo; llora y el mundo, dándote la espalda, te dejará llorar.',4),
(6,2,'2019/05/06','Homer Simpson','No nononononono, bueno si',1)
";
$update="update comments set rating=5 where comment_id=6";
//mysqli_query($mysqli,$tablacomentarios) or die (mysqli_error($mysqli));
//mysqli_query($mysqli,$insert) or die (mysqli_error($mysqli));
mysqli_query($mysqli,$update) or die (mysqli_error($mysqli));

$addcolum="ALTER TABLE videojuego ADD COLUMN (
videogame_time TINYINT UNSIGNED NULL,
videogame_cost DECIMAL(4,1) NULL,
videogame_takings DECIMAL(4,1) NULL,
videogame_release int null)";

$addcolum="ALTER TABLE videojuego ADD COLUMN (
videogame_release int null)";

$update="UPDATE videojuego SET
videogame_time = 109,
videogame_cost = 100,
videogame_takings = 342.6,
videogame_release = 2018
WHERE
videojuego_id = 2";

$update2="UPDATE videojuego SET
videogame_time = 101,
videogame_cost = 81,
videogame_takings = 242.6
WHERE
videojuego_id = 1";

//mysqli_query($mysqli,$addcolum) or die (mysqli_error($mysqli));
//mysqli_query($mysqli,$update) or die (mysqli_error($mysqli));
//mysqli_query($mysqli,$update2) or die (mysqli_error($mysqli));

$resultado=0;
$id=(int)$_GET['id'];


$query="select * from videojuego,genero,companyia where videojuego_id=".$id."  and videojuego.videojuego_genero=genero.videojuego_genero and videojuego.videojuego_companyia=companyia.videojuego_companyia";//.$_GET['id'];

//FALTA AÑADIR CAMPOS
$resultado=mysqli_query($mysqli,$query) or die (mysqli_error($mysqli));
$res=mysqli_fetch_array($resultado);
$resultado=mysqli_query($mysqli,$query) or die (mysqli_error($mysqli));
echo "<h1 align='center'>".$res['videojuego_nombre']."</h1>";
echo "<h2 align='center'>Detalles</h2>";
echo "<table style='width:100%'>";
while($row = mysqli_fetch_array($resultado)) {
    echo "<tr>";
    echo    "<td><b>Titulo</b></td>";
    echo    "<td>".$row['videojuego_nombre']."</td>";
    echo    "<td><b>Anyo de salida</b></td>";
    echo    "<td>".$row['videogame_release']."</td>";
    
    echo "</tr>";
    echo "<tr>";
    echo    "<td><b>Compañia</b></td>";
    echo    "<td>".$row['companyia']."</td>";
    echo    "<td><b>Coste</b></td>";
    echo    "<td>".$row['videogame_cost']." millones</td>";
    echo "</tr>";
    echo "<tr>";
    echo    "<td><b>Genero</b></td>";
    echo    "<td>".$row['genero']."</td>";
    echo    "<td><b>Ganancia</b></td>";
    echo    "<td>".$row['videogame_takings']." millones</td>";
    echo "</tr>";
    echo "<tr>";
    echo    "<td><b>Tiempo de juego</b></td>";
    echo    "<td>".$row['videogame_time']." Horas</td>";
    echo    "<td><b>Diferencia</b></td>";
    echo    "<td>".($row['videogame_takings']-$row['videogame_cost'])." millones</td>";
    echo "</tr>";
}

echo "</table>";
$sort1=1;
$sort2=2;
$sort3=3;
$sort4=4;
switch ((int)$_GET['sort']){
    case 1: 
    $query="select * from comments where videojuego_id=".$id." order by date ASC";
    $sort1=5;
    break;
    case 2:
    $query="select * from comments where videojuego_id=".$id." order by persona ASC"; 
    $sort2=6;
    break;
    case 3:
    $query="select * from comments where videojuego_id=".$id." order by coment ASC"; 
    $sort3=7;
    break;
    case 4:
    $query="select * from comments where videojuego_id=".$id." order by rating ASC";
    $sort4=8;
    break;
    case 5: 
    $query="select * from comments where videojuego_id=".$id." order by date desc";
        $sort1=1;
    break;
    case 6:
    $query="select * from comments where videojuego_id=".$id." order by persona desc";
        $sort2=2;
    break;
    case 7:
    $query="select * from comments where videojuego_id=".$id." order by coment desc";
        $sort3=3;
    break;
    case 8:
    $query="select * from comments where videojuego_id=".$id." order by rating desc";
        $sort4=4;
    break;
    default:
    $query="select * from comments where videojuego_id=".$id;
    break;
}
//$query="select * from comments where videojuego_id=".$id;
$review=mysqli_query($mysqli,$query) or die (mysqli_error($mysqli));
echo "<h2 align='center'>Reviews</h2>";
echo "<table style='width:100%'>";
echo "<tr>";

echo "  <td><a href='practica4-1.php?id=".$id."&&sort=".$sort1."'><b>Date</b></a></td>";
echo "  <td><a href='practica4-1.php?id=".$id."&&sort=".$sort2."'> <b> Reviewer</b></a></td>";
echo " <td><a href='practica4-1.php?id=".$id."&&sort=".$sort3."'><b>Comentario</b></a></td>";
echo "  <td><a href='practica4-1.php?id=".$id."&&sort=".$sort4."'><b>Rating</b></a></td>";
$c=0;
$style="style='background-color:#AFAFAF;'";
$media=0;
while($row = mysqli_fetch_array($review)) {
    $c++;
    if($c%2==0){

        echo "<tr>";
        echo "  <td>".$row['date']."</td>";
        echo "  <td>".$row['persona']."</td>";
        echo "  <td>".$row['coment']."</td>";
        echo "  <td >";
        for($c2=0;$c2!=$row['rating'];$c2++){

            echo "<div style='    width: 25px;float: left;
                height: 25px;
                background-image: url(estrella2.png);
                background-size: 25px;
                background-repeat: no-repeat;'></div>";

        }
        
        echo "</td>";
        echo "<tr>";
    }else{

        echo "<tr>";
        echo "  <td ".$style.">".$row['date']."</td>";
        echo "  <td ".$style.">".$row['persona']."</td>";
        echo "  <td ".$style.">".$row['coment']."</td>";
        
        echo "  <td ".$style.">";
        for($c2=0;$c2!=$row['rating'];$c2++){

            echo "<div style='    width: 25px;float: left;
                height: 25px;
                background-image: url(estrella2.png);
                background-size: 25px;
                background-repeat: no-repeat;'></div>";

        }
        
        echo "</td>";
        echo "<tr>";
    }
    $media=$media+$row['rating'];
    
}
echo "</table>";
echo "<h2>Media Rating</h2>";
$media=$media/$c;

echo "<div style='    width: 250px;
    height: 50px;'>";

for($c=0;$c!=floor($media);$c++){

echo "<div style='    width: 50px;float: left;
    height: 50px;
    background-image: url(estrella2.png);
    background-size: 50px;
    background-repeat: no-repeat;'></div>";

}
$mitad=($media-floor($media))*50;
if(floor($media)!=5){
    echo "<div style='    width:".$mitad."px;float: left;
    height: 50px;
    background-image: url(estrella2.png);
    background-size: 50px;
    background-repeat: no-repeat;'></div>";
}
echo "</div>";
echo "</div>";

?>
