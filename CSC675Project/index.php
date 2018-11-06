<?php
include(realpath(dirname(__FILE__)).'/init.php');
include(realpath(dirname(__FILE__)).'/mysql.php');

$query_id = -1;
$value = "";
$value2 = "";

if(isset($_GET['query_id']))
  $query_id = (int)($_GET['query_id']);

if(isset($_GET['value']))
  $value = mysqli_real_escape_string($dbc, $_GET['value']);

if(isset($_GET['value2']))
  $value2 = mysqli_real_escape_string($dbc, $_GET['value2']);



$player_table_headers = "<tr>
            <th>Player ID</th>
            <th>Team ID </th>
            <th>Name</th>
            <th>Age</th>
            <th>Number</th>
            <th>Position</th>
          </tr>";
$teams_table_headers="<tr>
            <th>Team ID</th>
            <th>Stadium ID </th>
            <th>Name</th>
            <th>Num players</th>
            <th>Mascot</th>
            <th>Colors</th>
          </tr>";
$stadiums_table_headers="<tr>
            <th>Stadium ID</th>
            <th>Name</th>
            <th>Location</th>
            <th>Num Seats</th>
          </tr>";
$coaches_table_headers="<tr>
            <th>Coach ID</th>
            <th>Team ID</th>
            <th>Name</th>
</tr>";
$equipment_table_headers="<tr>
            <th>Equipment ID</th>
            <th>Team ID</th>
            <th>Item name</th>
</tr>";



$results_to_print=[];
$results_table_headers="";
//Gets first player of each team
if($query_id==0)
{
  $query = "SELECT * FROM Players p GROUP BY tid";
  $result = mysqli_query($dbc, $query);
  while($row = mysqli_fetch_assoc($result))
  {
      $pid = $row['pid'];
      $tid = $row['tid'];
      $pname = $row['pname'];
      $page = $row['page'];
      $pnumber = $row['pnumber'];
      $pposition = $row['pposition'];

      $string_row = "<tr><td>".$pid."</td><td>".$tid."</td><td>".$pname."</td><td>".$page."</td><td>".$pnumber."</td><td>".$pposition."</td></tr>";
      $results_to_print[] = $string_row;
  }

  $results_table_headers = $player_table_headers;
}
//Finds stadiums where number of seats are greater than X
else if($query_id==1)
{
  $query = "SELECT s.s_name
            FROM Stadiums s
            GROUP BY num_seats
            HAVING num_seats > ".((int)$value);
  $result = mysqli_query($dbc, $query);
  while($row = mysqli_fetch_assoc($result))
  {
      $s_name = $row['s_name'];

      $string_row = "<tr><td>".$s_name."</td></tr>";
      $results_to_print[] = $string_row;
  }

  $results_table_headers = "<tr><th>Stadium Name</th></tr>";
}

//Find all players in certain stadiums
else if($query_id==2)
{
  $query = "SELECT *
            FROM players p
            INNER JOIN teams ON p.tid=teams.tid
            WHERE sid IN
            (SELECT sid FROM stadiums WHERE s_name='".$value."');";
  $result = mysqli_query($dbc, $query);
  while($row = mysqli_fetch_assoc($result))
  {
      $pid = $row['pid'];
      $tid = $row['tid'];
      $pname = $row['pname'];
      $page = $row['page'];
      $pnumber = $row['pnumber'];
      $pposition = $row['pposition'];

      $string_row = "<tr><td>".$pid."</td><td>".$tid."</td><td>".$pname."</td><td>".$page."</td><td>".$pnumber."</td><td>".$pposition."</td></tr>";
      $results_to_print[] = $string_row;
  }

  $results_table_headers = $player_table_headers;
}

//Find all players who play a certain position in a certain stadium
else if($query_id==3)
{
  $query = "SELECT *
            FROM players p
            WHERE p.pposition='".$value."' AND p.tid = ANY
            (SELECT tid
            FROM teams t
            INNER JOIN stadiums s ON t.sid=s.sid
            WHERE s.s_name='".$value2."');";
  $result = mysqli_query($dbc, $query);
  while($row = mysqli_fetch_assoc($result))
  {
      $pid = $row['pid'];
      $tid = $row['tid'];
      $pname = $row['pname'];
      $page = $row['page'];
      $pnumber = $row['pnumber'];
      $pposition = $row['pposition'];

      $string_row = "<tr><td>".$pid."</td><td>".$tid."</td><td>".$pname."</td><td>".$page."</td><td>".$pnumber."</td><td>".$pposition."</td></tr>";
      $results_to_print[] = $string_row;
  }

  $results_table_headers = $player_table_headers;
}






//fetches all teams
$teams_to_print = [];
$query = "SELECT * FROM Teams ";
$result = mysqli_query($dbc, $query);
while($row = mysqli_fetch_assoc($result))
{
    $tid = $row['tid'];
    $sid = $row['sid'];
    $tname = $row['tname'];
    $num_players = $row['num_players'];
    $mascot = $row['mascot'];
    $color = $row['color'];

    $string_row = "<tr><td>".$tid."</td><td>".$sid."</td><td>".$tname."</td><td>".$num_players."</td><td>".$mascot."</td><td>".$color."</td></tr>";
    $teams_to_print[] = $string_row;
}

//fetches all players
$players_to_print = [];
$query = "SELECT * FROM Players ";
$result = mysqli_query($dbc, $query);
while($row = mysqli_fetch_assoc($result))
{
    $pid = $row['pid'];
    $tid = $row['tid'];
    $pname = $row['pname'];
    $page = $row['page'];
    $pnumber = $row['pnumber'];
    $pposition = $row['pposition'];

    $string_row = "<tr><td>".$pid."</td><td>".$tid."</td><td>".$pname."</td><td>".$page."</td><td>".$pnumber."</td><td>".$pposition."</td></tr>";
    $players_to_print[] = $string_row;
}

//fetches all stadiums
$stadiums_to_print = [];
$query = "SELECT * FROM Stadiums ";
$result = mysqli_query($dbc, $query);
while($row = mysqli_fetch_assoc($result))
{
    $sid = $row['sid'];
    $s_name = $row['s_name'];
    $location = $row['location'];
    $num_seats = $row['num_seats'];

    $string_row = "<tr><td>".$sid."</td><td>".$s_name."</td><td>".$location."</td><td>".$num_seats."</td></tr>";
    $stadiums_to_print[] = $string_row;
}

//fetches all coaches
$coaches_to_print = [];
$query = "SELECT * FROM Coaches ";
$result = mysqli_query($dbc, $query);
while($row = mysqli_fetch_assoc($result))
{
    $cid = $row['cid'];
    $tid = $row['tid'];
    $cname = $row['cname'];

    $string_row = "<tr><td>".$cid."</td><td>".$tid."</td><td>".$cname."</td></tr>";
    $coaches_to_print[] = $string_row;
}

//fetches all equipment
$equipment_to_print = [];
$query = "SELECT * FROM Equipment ";
$result = mysqli_query($dbc, $query);
while($row = mysqli_fetch_assoc($result))
{
    $eid = $row['eid'];
    $tid = $row['tid'];
    $item = $row['item'];

    $string_row = "<tr><td>".$eid."</td><td>".$tid."</td><td>".$item."</td></tr>";
    $equipment_to_print[] = $string_row;
}

?>

<!DOCTYPE html>
<html>
  <head>
    <meta name="description" content="Web interface for SFSU's CSC 675 Introduction to Database's Final project" />
    <meta name="keywords" content="interface, mysql, sfsu, san francisco state university, csc 675, final project" />
    <title>CSC 675 Final Project</title>

    <?php include(realpath(dirname(__FILE__)).'/code_header.php'); ?>

    <script type="text/javascript">
      function query_submit(query_id)
      {
        var value1 = encodeURIComponent($('#query'+query_id+'_value1').val());
        var value2 = encodeURIComponent($('#query'+query_id+'_value2').val());

        console.log(value1);
        console.log(value2);

        //if don't need second query parameter
        if(value2==="" || value2===undefined)
        {
          window.location.href= "index.php?query_id="+query_id+"&value="+value1;
        }
        else
        {
          window.location = "index.php?query_id="+query_id+"&value="+value1+"&value2="+value2;
        }


        return false;
      }


      $(document).ready(function(){

      });
    </script>

  </head>
  <body>
    <?php include(realpath(dirname(__FILE__)).'/header.php'); ?>



    <div style="padding:30px;">
    <p style="font-size:25px;font-weight:bold;">Queries:</p>
      <table class="query_table">
        <tbody>
          <tr style="border-bottom:1px solid gray;">
            <td>Query1: Find all first players of every team: </td>
            <td><input type="hidden" id="query0_value1" placeholder="43000" <?php if($query_id==0) echo "value='".$value."'"; ?> /></td>
            <td><input type="hidden" id="query0_value2"  /></td>
            <td><input type="button" value="Submit" onClick="query_submit(0);"/></td>
          </tr>
          <tr style="border-bottom:1px solid gray;">
            <td>Query2: Find stadiums where number of seats are greater than this amount: </td>
            <td><input type="text" id="query1_value1" placeholder="43000" <?php if($query_id==1) echo "value='".$value."'"; ?> /></td>
            <td><input type="hidden" id="query1_value2"  /></td>
            <td><input type="button" value="Submit" onClick="query_submit(1);"/></td>
          </tr>
          <tr style="border-bottom:1px solid gray;">
            <td>Query3: Find all players in certain stadiums: </td>
            <td><input type="text" id="query2_value1" placeholder="Boston Stadium" <?php if($query_id==2) echo "value='".$value."'"; ?> /></td>
            <td><input type="hidden" id="query2_value2"  /></td>
            <td><input type="button" value="Submit" onClick="query_submit(2);"/></td>
          </tr>
          <tr style="border-bottom:1px solid gray;">
            <td>Query4: Find all player names who play a certain position in a certain stadium: </td>
            <td><input type="text" id="query3_value1" placeholder="Catcher" <?php if($query_id==3) echo "value='".$value."'"; ?>/></td>
            <td><input type="text" id="query3_value2" placeholder="Boston Stadium" <?php if($query_id==3) echo "value='".$value2."'"; ?>/></td>
            <td><input type="button" value="Submit" onClick="query_submit(3);"/></td>
          </tr>
        </tbody>
      </table>
    </div>

    <hr>

    <div class="result_table_container">
      <p style="font-size:25px;font-weight:bold;">Query Results: </p>
      <table id="results_table" class="result_table">
        <tbody>
          <?php
            echo $results_table_headers;
            foreach($results_to_print as $row)
              echo $row;
          ?>
        </tbody>
      </table>
    </div>

    <br>
    <hr>
    <br>

    <p style="font-size:25px;font-weight:bold;margin-left:20px;">All tables and all data</p>

    <!-- Teams -->
    <div class="result_table_container">
      <p>All Teams: </p>
      <table id="teams_table" class="result_table">
        <tbody>
          <?php
            echo $teams_table_headers;
            foreach($teams_to_print as $row)
              echo $row;
          ?>
        </tbody>
      </table>
    </div>

    <!-- Players -->
    <div class="result_table_container">
      <p>All Players: </p>
      <table id="players_table" class="result_table">
        <tbody>
          <?php
            echo $player_table_headers;
            foreach($players_to_print as $row)
              echo $row;
          ?>
        </tbody>
      </table>
    </div>

    <!-- Stadiums -->
    <div class="result_table_container">
      <p>All Stadiums: </p>
      <table id="stadiums_table" class="result_table">
        <tbody>
          <?php
            echo $stadiums_table_headers;
            foreach($stadiums_to_print as $row)
              echo $row;
          ?>
        </tbody>
      </table>
    </div>

    <!-- Coaches -->
    <div class="result_table_container">
      <p>All Coaches: </p>
      <table id="coaches_table" class="result_table">
        <tbody>
          <?php
            echo $coaches_table_headers;
            foreach($coaches_to_print as $row)
              echo $row;
          ?>
        </tbody>
      </table>
    </div>

    <!-- Equipment -->
    <div class="result_table_container">
      <p>All Equipment: </p>
      <table id="equipments_table" class="result_table">
        <tbody>
          <?php
            echo $equipment_table_headers;
            foreach($equipment_to_print as $row)
              echo $row;
          ?>
        </tbody>
      </table>
    </div>

    

    <?php //include(realpath(dirname(__FILE__)).'/footer.php'); ?>
  </body>
</html>