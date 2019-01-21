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
// show data with structure tree
    public function treeSingle($table, $id) 
    {
        $sql1 = "SELECT * FROM $table";
        $list = $this->getList($sql1) ;
        function show($list,$id) {
            $n = count($list);
            for ($i = 0; $i < $n; $i++) {
                if($list[$i]['category_id'] == $id) {
                    echo $list[$i]['name'];
                }
            }
            echo "<ul>";
            for($j= 1; $j < $n; $j++) {
                if( $list[$j]['parent'] == $id ) {
                    echo  "<li>";
                    $b = $list[$j]['category_id'];
                    // call again function to take children of this title
                    show($list,$b);
                    echo "</li>";
                }
            }
            echo "</ul>";
        }
        show($list,$id);
    }

    public function treeTotal($table) {
        $sql1 = "SELECT * FROM $table";
        $h = $this->getList($sql1) ;
        $n = count($h);
        $y = array();
        for ($a = 0; $a < $n; $a++) {
            if ($h[$a]['parent'] == null) {
                echo $h[$a]['name'];
                function showTotal($h,$firstParent) {
                    $n = count($h);
                    echo "<ul>";
                    for($j= 1; $j < $n; $j++) {
                        if($h[$firstParent]['category_id'] == $h[$j]['parent']) {
                            echo  "<li>".$h[$j]['name'];
                            // call again function to take children of this title
                            showTotal($h,$j);
                            echo "</li>";
                        }
                    }
                    echo "</ul>";
                }
                showTotal($h,$a);
            }
        }        
    }
}
?>