<?php
/**
 * Created by PhpStorm.
 * User: 36165
 * Date: 2018/3/22
 * Time: 10:43
 */
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
class Dev{
    public $id;
}

$sql = "SELECT *FROM tx1";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    // 解析数据，保存成为json格式
    while($row = $result->fetch_assoc()) {
        $user=new Dev();
        $user->id=$row["tx1_id"];
        $array[]=$user;
    }
} else {
    echo "0 结果";
}
$data=json_encode($array);
echo $data;
$conn->close();
?>