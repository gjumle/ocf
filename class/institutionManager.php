<?php
class InstitutionManager {

    private static function getInstitutions($id = null) {
        $condition = ($id == null) ? "" : "WHERE iid = " . $id;

        $conn = DB::getConnection();
        $sql = "SELECT * FROM institutions " . $condition . " ORDER BY name ASC";
        $result = $conn->query($sql);
        $institutions = array();
        if ($result->num_rows > 0) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $row) {
                $institution = new Institution($row['iid'], $row['name']);
                array_push($institutions, $institution);
            }

        }
        return $institutions;
    }

    public static function getInstitution($id) {
        $institutions = self::getInstitutions($id);
        return $institutions[0];
    }

    private static function formHandler() {
        if (isset($_POST['edit'])) {
            $editInstitution = new Institution ($_POST['id'], $_POST['name']);
            $editInstitution->saveToDB();
            echo "<script type='text/javascript'>window.location.replace('institutionManager.php');</script>";
        }
        if (isset($_GET['delete'])) {
            $deleteInstitution = self::getInstitution($_GET['delete']);
            $deleteInstitution->deleteFromDB();
            echo "<script type='text/javascript'>window.location.replace('institutionManager.php');</script>";
        }
        if (isset($_POST['insert'])) {
            $insertInstitution = new Institution ($id = null, $_POST['name']);
            $insertInstitution->insertToDB();
            echo "<script type='text/javascript'>window.location.replace('institutionManager.php');</script>";
        }
    }

    private static function renderAllAsTableRow() {
        $institutions = self::getInstitutions();
        $table = "";
        foreach ($institutions as $institution) {
            $table .= $institution->renderAsRowTable();
        }
        return $table;
    }

    public static function renderDatatable() {
        self::formHandler();
        $table = "<table border=1>";
        $table .= Institution::renderHead();

        if (isset($_GET['action']) && ($_GET['action'] == 'new')) {
            $institution = new Institution();
            $table .= $institution->renderForm();
        }
        $table .= self::renderAllAsTableRow();
        $table .= "</table>";

        return $table;
    }

    public static function renderAsSelect($edit) {
        $institutions = self::getInstitutions();
        $select = "<select name='institution'><option>---institution---</option>";
        foreach ($institutions as $institution) {
            $select .= $institution->renderAsOption($edit);
        }
        $select .= "</select>";
        return $select;
    }
}