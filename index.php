<?php
$title = filter_input(INPUT_POST, "title", FILTER_SANITIZE_STRING);
$description = filter_input(INPUT_POST, "description",FILTER_SANITIZE_STRING);

?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>ToDo list assignment</title>
    <link rel="stylesheet" href="css/main.css">
</head>
<body>
    <div class="container">
    <main>
        <?php
        if(isset($delete)){
            echo "<script> alert('Todo list has been deleted')</script>";
        }
        ?>
        <section>
            <h2>Add Item</h2>
            <form action="<?php echo $_SERVER['PHP_SELF']?>" method="POST">
            <div class="row">
                <div class="col-25">
                <input type="text" id="title" name="title" placeholder="Title"><br>
                </div>
            </div>

            <div class="row">
                <div class="col-25">
                <input type="text" id="description" name="description" placeholder="Description">
                </div>
            </div>

            <div class="row">
                <button type="submit" name="add">Add Item</button>
            </div>
            </form>
        </section>
    </main>
    </div> 
</body>
</html>

<?php
require("database.php");

if(isset($_POST['add'])){

    $query= 'INSERT INTO todoitems
             (Title, Description)
             VALUES 
             (:title, :description)';
    $statement = $db->prepare($query);
    $statement->bindValue(':title', $title);
    $statement->bindValue(':description', $description);
    $statement->execute();
    $statement->closeCursor();
}
?>


<?php
    include'database.php';

    if($title){
        $query = 'SELECT * FROM todoitems';

        $db_queryrun=$db->query($query);
        
                
        if($db_queryrun){
            echo '<table width="50%" border="1" cellpadding="5" cellspacing="5" style=margin-left:auto; margin-right:auto; font-family: Tahoma, Geneva, Verdana, sans-serif;>
                  <tr>
                    <th>ToDo List</th><br>
                  </tr>';

            while($row = $db_queryrun->fetch(PDO::FETCH_OBJ)){
                echo '  <tr>
                            <td style=text-align:center;>'.$row->Title.'</td><br>
                            <td style=text-align:center;>'.$row->Description.'</td>
                            <td>
                            <form class="delete"action="delete_record.php" method="POST">
                                <input type="hidden" name="itemnum" value="<?php echo $itemnum?>">
                                <button class="red" name="delete">Delete</button>
                            </td><br>
                        </tr>';
            }
        }
        
    $results = $db_queryrun->fetchAll();
    }
?>
<?php
if(!empty($results)){
    foreach($results as $result){
        $itemnum = $result["ItemNum"];
        $title = $result["Title"];
        $description = $result["Description"];
    }
}
?>

