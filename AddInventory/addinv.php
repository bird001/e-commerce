 <?php
   include('../DB/MySQLI.php');

    echo $category = $_POST['category']; 
    echo $invname = $_POST['Iname']; 
    echo $desc = $_POST['desc']; 
    echo $brand = $_POST['brand']; 
    echo $cost = $_POST['cost']; 
    echo $length = $_POST['length']; 
    echo $width = $_POST['width']; 
    echo $height = $_POST['height']; 
    echo $weight = $_POST['weight']; 
    echo $volume = $_POST['volume']; 
    //$image = $_POST['image']; 
    
    
    $addinv_query = "call sp_InsertInventory('$category','$invname','$desc','$brand','$cost','$length','$width','$height','$weight','$volume')";
    mysqli_query($connmysqli, $addinv_query);
    
    header("location: ../AddInventory/UpdateInventory.php"); 
    
?>