<?php 
class Db 
{
    // Biến lưu trữ kết nối
    private $__conn;
    // FUNCTION CONNECT
     function __construct()
    {
        // Nếu chưa kết nối thì thực hiện kết nối
        if (!$this->__conn){
            // Kết nối
            $this->__conn = new mysqli(DB_HOST, DB_USER, DB_PASS, DB_NAME) or die ('Lỗi kết nối');
            // Để tránh lỗi font 
            $this->__conn->set_charset("utf8");
        }
    }
 
    // FUNCTION DIS_CONNECT
    public function __destruct(){
        // Nếu đang kết nối thì ngắt
        if ($this->__conn){
            mysqli_close($this->__conn);
        }
    }
 
    // FUNCTION ADD
    public function insert($table,$data) //data sẽ ở dạng array
    {

    $field_list = '';
    $value_list = '';
 
    // Lặp qua data
    foreach ($data as $key => $value){
        $field_list .= ",$key";
        $value_list .= ",'".addslashes($value)."'";
    }
    // Vì sau vòng lặp các biến $field_list và $value_list sẽ thừa một dấu , nên ta sẽ dùng hàm trim để xóa đi
    $sql = 'INSERT INTO '.$table. '('.trim($field_list, ',').') VALUES ('.trim($value_list, ',').')';
 
    return mysqli_query($this->__conn, $sql);
    }
 
    // FUNCTION UPDATE
    public function update($table, $data, $where)
    {
        $sql = '';
        // Lặp qua data
        foreach ($data as $key => $value){
            $sql .= "$key = '".addslashes($value)."',";
        }
        // Vì sau vòng lặp biến $sql sẽ thừa một dấu , nên ta sẽ dùng hàm trim để xóa đi
        $sql = 'UPDATE '.$table. ' SET '.trim($sql, ',').' WHERE '.$where;
        return mysqli_query($this->__conn, $sql);
    }
 
    // FUNCTION DELETE
    public function remove($table, $where){
        $sql = "DELETE FROM $table WHERE $where";
        return mysqli_query($this->__conn, $sql);
    }
 
    // FUNCTION GET DATA
    public function getList($sql)
    {
        $result = mysqli_query($this->__conn, $sql);
        if (!$result){
            die ('Câu truy vấn bị sai ở đây');
        }
        $return = array();
        // Lặp qua kết quả để đưa vào mảng
        while ($row = mysqli_fetch_assoc($result)){
            $return[] = $row;
        }
        // Xóa kết quả khỏi bộ nhớ
        mysqli_free_result($result);
        return $return;
    }

    // FUNCTION CHECK 1 INFO EXISTS
    public function numRow($sql){
        $link= new mysqli('localhost', 'root', '', 'ControlData') or die ('Lỗi kết nối');
        $result=mysqli_query($link,$sql);
        $num_row=mysqli_num_rows($result);
        return $num_row;
    }

    // FUNCTION GET 1 INFO 
    public function getRow($sql)
    {
        $result = mysqli_query($this->__conn, $sql);
        if (!$result){
            return false;
        }
        $row = mysqli_fetch_assoc($result);
        // Xóa kết quả khỏi bộ nhớ
        mysqli_free_result($result);
        if ($row){
            return $row;
        }
    }
}

?>