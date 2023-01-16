<?php
class CashFlowManager {

    private static function getCashFLows($id = null) {
        $condition = ($id == null) ? "" : "WHERE cfid = " . $id;

        $conn = DB::getConnection();
        $sql = "SELECT * FROM cashflow " . $condition . " ORDER BY date ASC";
        $result = $conn->query($sql);
        $cashFlows = array();
        if ($result->num_rows > 0) {
            $rows = $result->fetch_all(MYSQLI_ASSOC);
            foreach ($rows as $row) {
                $cashFlow = new CashFlow($row['cfid'], $row['date'], UserManager::getUser($row['uid']), InstitutionManager::getInstitution($row['iid']), $row['amount']);
                array_push($cashFlows, $cashFlow);
            }

        }
        return $cashFlows;
        
    }

    private static function getCashFlow($id) {
        $cashFlows = self::getCashFlows($id);
        return $cashFlows[0];
    }

    private static function formHandler() {
        if (isset($_POST['edit'])) {
            $editCashFlow = new CashFlow ($_POST['id'], $_POST['date'], UserManager::getUser($_POST['user']), InstitutionManager::getInstitution($_POST['institution']), $_POST['amount']);
            $editCashFlow->saveToDB();
            echo "<script type='text/javascript'>window.location.replace('cashFlowManager.php');</script>";
        }
        if (isset($_GET['delete'])) {
            $deleteCashFlow = self::getCashFlow($_GET['delete']);
            $deleteCashFlow->deleteFromDB();
            echo "<script type='text/javascript'>window.location.replace('cashFlowManager.php');</script>";
        }
        if (isset($_POST['insert'])) {
            $insertCashFlow = new CashFlow ($id = null, $_POST['date'], UserManager::getUser($_POST['user']), InstitutionManager::getInstitution($_POST['institution']), $_POST['amount']);
            $insertCashFlow->insertToDB();
            echo "<script type='text/javascript'>window.location.replace('cashFlowManager.php');</script>";
        }
    }

    private static function renderAllAsTableRow() {
        $cashFlows = self::getCashFlows();
        $table = "";
        foreach ($cashFlows as $cashFlow) {
            $table .= $cashFlow->renderAsRowTable();
        }
        return $table;
    }

    public static function renderDatatable() {
        self::formHandler();
        $table = "<table border=1>";
        $table .= CashFlow::renderHead();

        if (isset($_GET['action']) && ($_GET['action'] == 'new') ? true : false) {
            $cashFlow = new CashFlow();
            $table .= $cashFlow->renderForm();
        }
        $table .= self::renderAllAsTableRow(false);
        $table .= "</table>";
        return $table;
    }
}