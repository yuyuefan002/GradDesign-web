<?php
//解析传递过来的参数
$id=$_SERVER['QUERY_STRING' ];
$tx1id=$id[0];
$date=substr($id,1,10);
// 加载数据库配置
require("db_config.php");
// 创建连接
$conn = new mysqli($mysql_server_name, $mysql_username, $mysql_password, $mysql_database);
// 检查连接问题
if ($conn->connect_error) {
    die("连接失败: " . $conn->connect_error);
}
$data="";
$array= array();
class User{
   // public $id;
    public $time;
    public $bodycount;
}

$sql = "SELECT *FROM bodyCount where tx1_id=".$tx1id." and recorddate=\"".$date."\"";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 解析数据，保存成为json格式
    while($row = $result->fetch_assoc()) {
        $user=new User();
        $user->time=$row["recordtime"];
        $user->bodycount=$row["bodycount"];
        $array[]=$user;
    }
} else {
    echo "0 结果";
}
$data=json_encode($array);
echo $data;
$conn->close();
?>