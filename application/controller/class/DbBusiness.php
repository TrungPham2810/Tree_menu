<?php 
    
    class DbBusiness extends Db 
    {
    public function showData($table)
    {   
        echo  "<table class=\"show_data\" border='1' style=\"border-collapse:collapse\">
        <tr style=\"text-align:center;\">
            <td >Category_id</td>
            <td >Name</td>
            <td>Parent</td>
        </tr>";
        
         $sql1 = "SELECT * FROM $table";
        // var_dump($this->getList($sql1) ) ;
         foreach($this->getList($sql1) as $key=>$value)
         {
             echo '<tr>';
             echo "<td>".$value['category_id']."</td>";
             echo "<td>".$value['name']."</td>";
             echo "<td>".$value['parent']."</td></tr>";
         }
        echo '</table>';
    }

    public function tree($table) 
    {
        $sql1 = "SELECT * FROM $table";
        $h = $this->getList($sql1) ;
        function show($h,$a) {
            $n = count($h);
            echo "<ul>";
            for($j= 1; $j < $n; $j++) {
                if($h[$a]['category_id'] == $h[$j]['parent']) {
                    echo  "<li>".$h[$j]['name'];
                    // call again function to take children of this title
                    show($h,$j);
                    echo "</li>";
            }
            }
            echo "</ul>";
        }
        show($h,0);
    }
    // Hàm xóa theo id
    function deleteById($table, $id){
        // return $this->remove($table, "Id = $id");
        $this->remove($table, "Id = $id");
    }

    // hàm select theo id
    function selectById($table, $id){
        $sql = "SELECT * FROM $table WHERE Id = $id";
        return $this->getRow($sql);
    }
}
?>