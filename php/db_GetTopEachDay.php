<?php
//解析传递过来的参数
$id=$_SERVER['QUERY_STRING' ];
//$id=1;
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
class TopEachDay{
    public $bodycount;
}
for($month=1;$month<=12;$month++) {
    $monthdate = "2018-" . $month . "-";
    for ($day = 1; $day <32; $day++) {
        if(($month==4)&&($day==31))
            break;
        if(($month==6)&&($day==31))
            break;
        if(($month==9)&&($day==31))
            break;
        if(($month==11)&&($day==31))
            break;
        if($month==2&&$day==29)
            break;
        //$date="2018-03-22";
        $date=$monthdate.$day;
        $temp="SELECT *FROM bodyCount where recorddate=\"" . $date . "\" and tx1_id =";
        $sql=$temp.$id." order by bodycount desc limit 1";
        //$sql = "SELECT *FROM bodyCount where recorddate=\"" . $date . "\" and tx1_id = 1 order by bodycount desc limit 1";
        $result = $conn->query($sql);
        if ($result->num_rows > 0) {
            // 解析数据，保存成为json格式
            $row = $result->fetch_assoc();
            $TopEachDay = new TopEachDay();
            $TopEachDay->bodycount = $row["bodycount"];
            $array[] = $TopEachDay;
        } else {
            $TopEachDay = new TopEachDay();
            $TopEachDay->bodycount = "0";
            $array[] = $TopEachDay;
        }

    }
}
$data=json_encode($array);
echo $data;
$conn->close();
?>