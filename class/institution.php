<?php
class Institution {
    private $id;
    private $name;

    public function __construct($id = null, $name = null) {
        $this->id = $id;
        $this->name = $name;
    }

    public function getId() {
        return $this->id;
    }

    public function getName() {
        return $this->name;
    }

    public function renderForm() {
        if ($this->id > 0) {
            $id = $this->id;
            $name = $this->name;
            $btnName = "edit";
        } else {
            $id = "";
            $name = "";
            $btnName = "insert";
        }
        return "
            <form action='' method='post' class='table'>
                <tr>;
                    <td><input type='hidden' name='id' value='" . $id . "' /></td>
                    <td><input type='text' name='name' value='" . $name. "' /></td>
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
                <th colspan='2'>Action</th>
            </tr>";
    }

    public function renderAsOption($edit = null) {
        $selected = ($edit != null && $this->id == $edit->id) ? "selected='selected'" : "";
        return "<option value='" . $this->id . "' " . $selected . ">" . $this->name . "</option>";
     }

    public function insertToDB() {
        $conn = DB::getConnection();
        $sql = "INSERT INTO institutions (name) VALUES ('" . $this->name . "')";
        $result = $conn->query($sql);
    }

    public function saveToDB() {
        $conn = DB::getConnection();
        $sql = "UPDATE institutions SET name = '" . $this->name . "' WHERE iid = " . $this->id;
        $result = $conn->query($sql);
    }
    public function deleteFromDB() {
        $conn = DB::getConnection();
        $sql = "DELETE FROM institutions WHERE iid = " . $this->id;
        $result = $conn->query($sql);
    }
}