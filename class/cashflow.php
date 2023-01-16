<?php
class CashFlow {
    private $id;
    private $date;
    private $user;
    private $institution;
    private $amount;

    public function __construct($id = null, $date = null, $user = null, $institution = null, $amount = null) {
        $this->id = $id;
        $this->date = $date;
        $this->user = $user;
        $this->institution = $institution;
        $this->amount = $amount;
    }

    public function renderForm() {
        if ($this->id > 0) {
            $id = $this->id;
            $date = $this->date;
            $user = UserManager::renderAsSelect($this->user);
            $institution = InstitutionManager::renderAsSelect($this->institution);
            $amount = $this->amount;
            $btnName = "edit";
        } else {
            $id = "";
            $date = "";
            $user = UserManager::renderAsSelect(null);
            $institution = InstitutionManager::renderAsSelect(null);
            $amount = "";
            $btnName = "insert";
        }
        return "
            <form action='' method='post' class='table'>
                <tr>
                    <td><input type='hidden' name='id' value='" . $id . "' /></td>
                    <td><input type='date' name='date' value='" . $date. "' /></td>
                    <td>" . $user . "</td>
                    <td>" . $institution . "</td>
                    <td><input type='text' name='amount' value='" . $amount. "' /></td>
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
                    <td>" . $this->date . "</td>
                    <td>" . $this->user->getName() . "</td>
                    <td>" . $this->institution->getName() . "</td>
                    <td>" . $this->amount . "</td>
                    <td><a href='?edit=" . $this->id . "'>Edit</a></td>
                    <td><a href='?delete=" . $this->id . "'>Delete</a></td>
                </tr>";
        }
    }

    public static function renderHead() {
        return "
            <tr>
                <th>ID</th>
                <th>Date</th>
                <th>User</th>
                <th>Institution</th>
                <th>Amount</th>
                <th colspan='2'>Action</th>
            </tr>";
    }

    public function saveToDB() {
        $conn = DB::getConnection();
        $sql = "UPDATE cashflow SET date ='" . $this->date . "', uid =" . $this->user->getId() . ", iid =" . $this->institution->getId() . ", amount =" . $this->amount . " WHERE cfid =" . $this->id;
        $result = $conn->query($sql);
    }

    public function insertToDB() {
        $conn = DB::getConnection();
        $sql = "INSERT INTO cashflow (date, uid, iid, amount) VALUES ('" . $this->date . "', " . $this->user->getId() . ", " . $this->institution->getId(). ", " . $this->amount . ")";
        $result = $conn->query($sql);
    }

    public function deleteFromDB() {
        $conn = DB::getConnection();
        $sql = "DELETE FROM cashflow WHERE cfid =" . $this->id;
        $result = $conn->query($sql);
    }
}