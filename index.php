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
        <h1>Rozcestnik</h1>
        <ul>
            <li><a href="./userManager.php">User</a></li>
            <li><a href="./cashFlowManager.php">CashFlow</a></li>
            <li><a href="institutionManager.php">Institution</a></li>
        </ul>
    </body>
</html>