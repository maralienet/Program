<?php
if (isset($_POST['functionname'])) {
    $functionname = $_POST['functionname'];
    switch ($functionname) {
        case 'confirmation': {
                confirmation();
                break;
            }
        case 'editing': {
                editing();
                break;
            }
    }
}
function confirmation()
{
    require("conn.php");
    if (isset($_POST['confPass']) && isset($_COOKIE['id'])) {
        $confPass = $_POST['confPass'];
        $id = urldecode($_COOKIE['id']);

        $sql = "SELECT * from Users where password='$confPass' and userId=$id and active=1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0)
            echo 'OK';
        else
            echo 'Неверный пароль';
    }
    $conn->close();
}

function editing()
{
    require("conn.php");
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $id = $_COOKIE['id'];
        $name = isset($_POST["name"]) ? $_POST["name"] : null;
        $phonenum = isset($_POST["phonenum"]) ? $_POST["phonenum"] : null;
        $pass = isset($_POST["pass"]) ? $_POST["pass"] : null;
        $file = isset($_FILES["file"]) ? $_FILES["file"] : null;

        $changed = 0;

        if ($name) {
            $sql = "UPDATE `Customers` SET `custName`='$name' where userId=$id";
            $result = $conn->query($sql);
            $changed++;
        }
        if ($phonenum) {
            $sql = "UPDATE `Users` SET `phone`='$phonenum' where userId=$id";
            $result = $conn->query($sql);
            $changed++;
        }
        if ($pass) {
            $sql = "UPDATE `Users` SET `password`='$pass' where userId=$id";
            $result = $conn->query($sql);
            $changed++;
        }
        if ($file) {
            $filename = $_FILES["file"]["name"];
            $tempname = $_FILES["file"]["tmp_name"];
            $folder = "../../pics/customers/" . $filename;

            if (!file_exists(dirname($folder))) {
                mkdir(dirname($folder), 0777, true);
            }

            if (move_uploaded_file($tempname, $folder)) {
                $sql = "UPDATE `Customers` SET `photo`='$folder' where userId=$id";
                $result = $conn->query($sql);
                $changed++;
            } else {
                echo "files are NOT uploaded";
            }
        }

        if ($changed > 0)
            echo 'OK';
    }
    $conn->close();
}
