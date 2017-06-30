<?php
include('../DB/PDO.php');
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
    <head>
        <title>Search</title>
        <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
        <link rel="stylesheet" type="text/css" href="style.css"/>
    </head>
    <body>
        <form action="../AddInventory/addinv.php" method="POST">
            <div>
            <label for="inputIName" class="control-label">Category</label>
            <select type="text" name="category" id="category" class="form-control" required>
                <option selected>-- select category --</option>
                <?php
                $sql = "SELECT * FROM inventorycategory";
                $results = $connpdo->query($sql);
                $rows = $results->fetchAll();
                foreach ($rows as $row) {
                    echo '<option value = "'.$row['CategoryId'].'">'.$row['CategoryName'].'</option>';
                }
                ?>
            </select>
            </div>
            
            <label for="inputIName" class="control-label">Item Name</label>
            <input type="text" name="Iname" id="Iname" class="form-control"/>

            <label for="inputIName" class="control-label">Description</label>
            <input type="text" name="desc" id="desc" class="form-control"/>

            <label for="inputIName" class="control-label">Brand</label>
            <input type="text" name="brand" id="brand" class="form-control"/>

            <label for="inputIName" class="control-label">Cost</label>
            <input type="text" name="cost" id="cost" class="form-control"/>

            <label for="inputIName" class="control-label">Length</label>
            <input type="text" name="length" id="length" class="form-control"/>

            <label for="inputIName" class="control-label">Width</label>
            <input type="text" name="width" id="width" class="form-control"/>

            <label for="inputIName" class="control-label">Height</label>
            <input type="text" name="height" id="height" class="form-control"/>

            <label for="inputIName" class="control-label">Weight</label>
            <input type="text" name="weight" id="weight" class="form-control"/>
            
            <label for="inputIName" class="control-label">Volume</label>
            <input type="text" name="volume" id="volume" class="form-control"/>

            <!--
            <label for="inputIName" class="control-label">Image</label>
            <input type="text" name="image" id="image" class="form-control"/>
            -->
            <input type="submit" value="Add Inventory" />
        </form>
    </body>
</html>