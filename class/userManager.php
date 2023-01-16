<?php
class UserManager{

    private static function getUsers($id = null) {
        $condition = ($id == null) ? "" : "WHERE uid = " . $id;

        $conn = DB::getConnection();
        $sql = "SELECT * FROM users " . $condition . " ORDER BY name ASC";
        $result = $conn->query($sql);
        $users = array();
        if ($result->num_rows > 0) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $row) {
                $user = new User($row['uid'], $row['name'], $row['admin']);
                array_push($users, $user);
            }

        }
        return $users;
    }

    public static function getUser($id) {
        $users = self::getUsers($id);
        return $users[0];
    }

    private static function formHandler() {
        $admin = (isset($_POST['admin'])) ? $_POST['admin'] : 0;
        if (isset($_POST['edit'])) {
            $editUser = new User ($_POST['id'], $_POST['name'], $admin);
            $editUser->saveToDB();
            echo "<script type='text/javascript'>window.location.replace('userManager.php');</script>";
        }
        if (isset($_GET['delete'])) {
            $deleteUser = self::getUser($_GET['delete']);
            $deleteUser->deleteFromDB();
            echo "<script type='text/javascript'>window.location.replace('userManager.php');</script>";
        }
        if (isset($_POST['insert'])) {
            $insertUser = new User ($id = null, $_POST['name'], $admin);
            $insertUser->insertToDB();
            echo "<script type='text/javascript'>window.location.replace('userManager.php');</script>";
        }
    }

    private static function renderAllAsTableRow() {
        $users = self::getUsers();
        $table = "";
        foreach ($users as $user) {
            $table .= $user->renderAsRowTable();
        }
        return $table;
    }

    public static function renderDatatable() {
        self::formHandler();
        $table = "<table border=1>";
        $table .= User::renderHead();

        if (isset($_GET['action']) && ($_GET['action'] == 'new')) {
            $user = new User();
            $table .= $user->renderForm();
        }
        $table .= self::renderAllAsTableRow();
        $table .= "</table>";

        return $table;
    }
    
    public static function renderAsSelect($edit) {
        $users = self::getUsers();
        $select = "<select name='user'><option>---user---</option>";
        foreach ($users as $user) {
            $select .= $user->renderAsOption($edit);
        }
        $select .= "</select>";
        return $select;
    }
}