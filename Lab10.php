<?php
//Fill this place

//****** Hint ******
//connect database and fetch data here
$host = 'localhost';
$dbuser = 'root';
$passwd = 'psw010105';
$dbname = 'travel';
$db = new mysqli($host,$dbuser,$passwd,$dbname);//password will change after commit
//find continents
$query = "SELECT * FROM continents";
$resultContinent = $db->query($query);
//find countries
$query = "SELECT * FROM countries";
$resultCountries = $db->query($query);
//find images
$continent = "";
$country = "";
$title = "";
if (isset($_REQUEST['continent'])){
    $continent = ($_REQUEST['continent']&&$_REQUEST['continent']!="0")?$_REQUEST['continent']:"";
}
if (isset($_REQUEST['country'])){
    $country = ($_REQUEST['country']&&$_REQUEST['country']!="0")?$_REQUEST['country']:"";
}
if (isset($_REQUEST['title'])){
    $title = ($_REQUEST['title'])?$_REQUEST['title']:"";
}
$query = "SELECT * FROM imagedetails";
$query.=" WHERE Title LIKE '%$title%'";
if ($continent!=""){
    $query.=" AND ContinentCode = '$continent'";
}
if ($country!=""){
    $query.=" AND CountryCodeISO = '$country'";
}
$resultImage = $db->query($query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>Chapter 14</title>

      <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href='http://fonts.googleapis.com/css?family=Lobster' rel='stylesheet' type='text/css'>
    <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>

    <link rel="stylesheet" href="css/bootstrap.min.css" />
    
    

    <link rel="stylesheet" href="css/captions.css" />
    <link rel="stylesheet" href="css/bootstrap-theme.css" />    

</head>

<body>
    <?php include 'header.inc.php'; ?>
    


    <!-- Page Content -->
    <main class="container">
        <div class="panel panel-default">
          <div class="panel-heading">Filters</div>
          <div class="panel-body">
            <form action="Lab10.php" method="get" class="form-horizontal">
              <div class="form-inline">
              <select name="continent" class="form-control">
                <option value="0">Select Continent</option>
                <?php
                //Fill this place

                //****** Hint ******
                //display the list of continents

                while($row = $resultContinent->fetch_assoc()) {
                  echo '<option value=' . $row['ContinentCode'] . '>' . $row['ContinentName'] . '</option>';
                }

                ?>
              </select>     
              
              <select name="country" class="form-control">
                <option value="0">Select Country</option>
                <?php 
                //Fill this place

                //****** Hint ******
                /* display list of countries */
                while($row = $resultCountries->fetch_assoc()) {
                    echo '<option value=' . $row['ISO'] . '>' . $row['CountryName'] . '</option>';
                }
                ?>
              </select>    
              <input type="text"  placeholder="Search title" class="form-control" name=title>
              <button type="submit" class="btn btn-primary">Filter</button>
              </div>
            </form>

          </div>
        </div>     
                                    

		<ul class="caption-style-2">
            <?php 
            //Fill this place

            //****** Hint ******
            /* use while loop to display images that meet requirements ... sample below ... replace ???? with field data
            <li>
              <a href="detail.php?id=????" class="img-responsive">
                <img src="images/square-medium/????" alt="????">
                <div class="caption">
                  <div class="blur"></div>
                  <div class="caption-text">
                    <p>????</p>
                  </div>
                </div>
              </a>
            </li>        
            */
            while ($row = $resultImage->fetch_assoc()){
                echo "<li>
              <a href='detail.php?id=".$row['ImageID']."' class= 'img-responsive'>
                <img src='images/square-medium/".$row['Path']."' alt=".$row['Title'].">
                <div class='caption'>
                  <div class='blur'></div>
                  <div class='caption-text'>
                    <h1>".$row['Title']."</h1>
                  </div>
                </div>
              </a>
            </li> ";
            }
            ?>
       </ul>       

      
    </main>
    
    <footer>
        <div class="container-fluid">
                    <div class="row final">
                <p>Copyright &copy; 2017 Creative Commons ShareAlike</p>
                <p><a href="#">Home</a> / <a href="#">About</a> / <a href="#">Contact</a> / <a href="#">Browse</a></p>
            </div>            
        </div>
        

    </footer>


        <script src="https://code.jquery.com/jquery-2.2.4.min.js" integrity="sha256-BbhdlvQf/xTY9gja0Dq3HiwQF8LaCRTXxZKRutelT44=" crossorigin="anonymous"></script>
        <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js" integrity="sha384-0mSbJDEHialfmuBBQP6A4Qrprq5OVfW37PRR3j5ELqxss1yVqOtnepnHVP9aJ7xS" crossorigin="anonymous"></script>
</body>

</html>