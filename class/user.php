<?php
class User {
    private $id;
    private $name;
    private $admin;

    public function __construct($id = null, $name = null, $admin = null) {
        $this->id = $id;
        $this->name = $name;
        $this->admin = $admin ? $admin : 0;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    private function getAdmin() {
        return ($this->admin == 1) ? "Yes" : "No";
    }

    private function getAdminAsChecked() {
        return ($this->admin == 1) ? "checked='checked'" : "";
    }

    public function renderForm() {
        if ($this->id > 0) {
            $id = $this->id;
            $name = $this->name;
            $admin = $this->getAdmin();
            $btnName = "edit";
        } else {
            $id = "";
            $name = "";
            $admin = "";
            $btnName = "insert";
        }
        return "
            <form action='' method='post' class='table'>
                <tr>
                    <td><input type='hidden' name='id' value='" . $id . "' /></td>
                    <td><input type='text' name='name' value='" . $name. "' /></td>
                    <td><input type='checkbox' name='admin' value='1' " . $admin . "/></td>
                    <td colspan='2'><input type='submit' name='" . $btnName ."'/></td>
                </tr>
            </form>";
    }

    public function renderAsRowTable() {
        if (isset($_GET['edit']) && $this->id == $_GET['edit']) {
            return $this->renderForm();
        } else {
            return "
                <tr>
                    <td>#" . $this->id . "</td> 
                    <td>" . $this->name . "</td>
                    <td>" . $this->getAdmin() . "</td>
                    <td><a href='?edit=" . $this->id . "'>Edit</a></td>
                    <td><a href='?delete=" . $this->id . "'>Delete</a></td>
                </tr>";
        }
    }

    public static function renderHead() {
        return "
            <tr>
                <th>ID</th>
                <th width='170px'>Name</th>
                <th>Admin</th>
                <th colspan='2'>Action</th>
            </tr>";
    }

    public function renderAsOption($edit = null) {
        $selected = ($edit != null && $this->id == $edit->id) ? "selected='selected'" : "";
        return "<option value='" . $this->id . "' " . $selected . ">" . $this->name . "</option>";
    }

    public function insertToDB() {
        $conn = DB::getConnection();
        $sql = "INSERT INTO users (name, admin) VALUES ('" . $this->name . "', " . $this->admin . ")";
        $result = $conn->query($sql);
    }

    public function saveToDB() {
        $conn = DB::getConnection();
        $sql = "UPDATE users SET name = '" . $this->name . "', admin = " . $this->admin . " WHERE uid = " . $this->id;
        $result = $conn->query($sql);
    }
    public function deleteFromDB() {
        $conn = DB::getConnection();
        $sql = "DELETE FROM users WHERE uid = " . $this->id;
        $result = $conn->query($sql);
    }
}