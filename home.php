<?php

try {
    $con = new PDO('mysql:hostname=localhost;dbname=phpdemo','root','');
}
catch(PDOException $e) {
    echo $e-getMessage();
}

if(isset($_POST['rate'])) {
    $rate = $_POST['rate'];
    if(isset($_COOKIE['rate'])) {
        echo "Already Voted";
    }
    else {
        setcookie('rate',$rate,time()+10);
        $update_sql="update rate set option_value=option_value+1 where `option`='$rate'";
        $update_stmt=$con->prepare($update_sql);
        $update_stmt->execute();
        echo "thank you for voting";
    }
}

$sql = "select * from rate";
$stmt = $con->prepare($sql);
$stmt->execute();
$data = $stmt->fetchAll(PDO::FETCH_ASSOC);

?>




<form method="POST">

<table>

    <tr>
        <td>
            <input type="submit" name="rate" value="<?php echo $data['0']['option'] ?>" />
            (<?php echo $data['0']['option_value'] ?>)
        </td>
        <td>vs</td>
        <td>
            <input type="submit" name="rate" value="<?php echo $data['1']['option'] ?>" />
            (<?php echo $data['1']['option_value'] ?>)
        </td>
    </tr>

</table>


</form>