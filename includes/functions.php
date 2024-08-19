<?php
include('./includes/connection.php');

    function getOptions($mysqli, $chart, $column, $label){
        $sql = "SELECT ID, $column FROM $chart";
        $result = $mysqli->query($sql);
        if ($result->num_rows>0){
         echo '<option value="">'.$label.'</option>';
         while ($row = $result->fetch_assoc()) {
             echo '<option value="' . $row['ID'] . '">' . $row[$column] . '</option>';
         }   
        } else{
         echo '<option disabled>nenhuma opção encontrada...</option>';
        }
    }
?>