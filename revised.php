<?php
session_start();
// If the user is not logged in redirect to the login page...
if (!isset($_SESSION['loggedin'])) {
	header('Location: login.php');
	exit();
}

include('includes/connections.php');

if(isset($_POST['search']))
{
    $fnameSearch = mysqli_real_escape_string($conn, $_POST['fnameSearch']);
    // $adrSearch = mysqli_real_escape_string($conn, $_POST['adrSearch']);
    $query = "SELECT * FROM `dghdbtbl` WHERE CONCAT(`fname`, ' ' ,`lname`) LIKE '%".$fnameSearch; $query .="%' OR `adr` LIKE '%".$fnameSearch; $query .="%' LIMIT 10";
    $search_result = filterTable($query);
}
else {
    $query = "SELECT * FROM `dghdbtbl` LIMIT 10";
    $search_result = filterTable($query);
}

function filterTable($query)
{
    $connect = mysqli_connect("localhost", "root", "", "dghcdb");
    $filter_Result = mysqli_query($connect, $query);
    return $filter_Result;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>  
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Document</title>
    <link rel="stylesheet" href="design2.css">
    <link href="https://fonts.googleapis.com/css?family=Poppins:400,600&display=swap" rel="stylesheet">
</head>
<body>
    <div class="main-container">
    <nav>
        <!-- <div class="title">
            <h1>DGHC</h1>
            <span>Dashboard</span>
        </div> -->
            <a href="revised.php" class="active"><span>H</span>ome</a>
            <a href="addnewcus.php" class="inactive"><span>A</span>dd New Customer</a>
            <a href="#" class="inactive"><span>SC</span> / PWD Search</a>
            <a href="logout.php" class="inactive"><span>L</span>ogout</a>
    </nav>
    <section>
        <form class="searchfield" action="revised.php" method="post">
                <input class="searchbox" placeholder="Input Name or Address" type="text" name="fnameSearch" tabindex="1" autocomplete="off">
                <!-- <input class="searchbox" type="text" name="adrSearch" placeholder="Customer's Name" tabindex="2" autocomplete="off"> -->
                <!-- <input type="submit" name="search" value="SEARCH" > -->
                <button type="submit" class="arrow_box" value="SEARCH" name="search">Submit</button>
        </form>
        
    </section>
    <article>
    <table id="tableMain">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Customer Name</th>
                    <th>Address</th>
                    <th>Landmark</th>
                    <th>Tank</th>
                    <!-- <th>Send to SuperHub</th> -->
                </tr>
            </thead>
            <?php
            include("includes/connections.php");
                
                
                while($row = mysqli_fetch_assoc($search_result)){
   
                        $user_ID = $row["ID"];
                        $db_fname = $row["fname"];
                        $db_lname = $row["lname"];
                        $db_adr = $row["adr"];
                        $db_lmark = $row["lmark"];
                        $db_ttype = $row["ttype"];
                        $db_contact = $row["cusno"];
                        //$db_lastorder = $row["lastorder"];

                        echo    "<tbody><tr class='breakrow'>
                                <td>$user_ID</td>
                                <td>$db_fname $db_lname</td>
                                <td>$db_adr</td>
                                <td>$db_lmark</td>
                                <td>$db_ttype</td></tr>";
                        echo    "<tr class='datarow' style='display:none !important'>
                                <td class='addinfo' colspan='5' >
                                <div class='label'>Contact Number:</div><div class='result'>$db_contact</div>
                                
                                </td></tr>
                                <tr class='datarow' style='display:none'>
                                <td colspan='5'>
                                <a class='options' href='edit.php?ID=$user_ID'>Update</a>
                                <a class='options' href='testdate.php?ID=$user_ID'>Order</a>
                                <a class='options' href='edit.php?ID=$user_ID'>Delete</a>
                                </td>
                                </tr></tbody>";
                }
        ?>
        </table>
    </article>
    <!-- <div class='label'>Last Order:</div><div class='result'>$db_lastorder</div> -->
    <!-- <div class='label'>Last Purchase:</div><div class='result'>$db_lastorder</div> -->
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script>
<script>
        //collapse and expand sections
//$('.breakrow').click(function(){
$('#tableMain').on('click', 'tr.breakrow',function(){
    $(this).nextUntil('tr.breakrow').slideToggle(500);
});
</script>
</body>
</html>
