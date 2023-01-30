<?php
function autoloadModel($className) {
    $filename = "class/" . $className . ".php";
    if (is_readable($filename)) {
        require $filename;
    }
}
spl_autoload_register("autoloadModel");


?>

<html>
    <body>
        <h1>User Manager</h1>
        <p>Go to <a href='./index.php'>menu</a>  Add new record <a href="?action=new">here</a></p>
    </body>
</html>

<?php
echo UserManager::renderDataTable();
?>