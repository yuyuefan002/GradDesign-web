<?php
//解析传递过来的参数

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
    public $id;
    public $timeline;
    public $series;
}


//获取id列表
$sql = "SELECT *FROM tx1";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 解析数据，保存成为json格式
    $user=new User();
    while($row = $result->fetch_assoc()) {

        $user->id[]=$row["tx1_id"];
    }
    //$array[]=$user;
} else {
    echo "0 结果";
}

//获取时间列表
$sql = "SELECT DISTINCT recorddate FROM bodycount";
$result = $conn->query($sql);
if ($result->num_rows > 0) {
    // 解析数据，保存成为json格式
    //$timeline=new User();
    while($row = $result->fetch_assoc()) {

        $user->timeline[]=$row["recorddate"];
    }

} else {
    echo "0 结果";
}

$tmp_m=null;
$tmp_l=null;
$tmp_one = null;
$tmp_id =null;
//获取设备编号
$sql_id ="SELECT tx1_id FROM tx1";
$result_id = $conn->query($sql_id);
$tmp_id=$result_id->num_rows;
$tmp_sum=0;
$tmp_tim=0;
//获取详细数据["12:00:00",100,321675013,"1","2018-01-01"]
//大循环，查询有数据的日期
$sql_loop ="SELECT DISTINCT recorddate FROM bodycount";
$result_loop = $conn->query($sql_loop);
if($result_loop->num_rows>0) {
    while($row_loop = $result_loop->fetch_assoc()) {
        //小循环，用当前的日期去查询数据,每天的数据
        $tmp_m=null;
        for ($x=1; $x<=$tmp_id; $x++) {
            //查询总人数
            $sql_sum="SELECT sum(bodycount) as sum FROM bodycount Where recorddate = \"" . $row_loop["recorddate"] . "\"and tx1_id=".$x;
            //echo $sql_sum;
            $result_sum=$conn->query($sql_sum);
            if ($result_sum->num_rows > 0) {
                $row_sum = $result_sum->fetch_assoc();
                $tmp_sum=(int)$row_sum["sum"];
            }
            //查询时间int数字型
            $sql_tim = "SELECT recordtime+1 as recordtime FROM bodycount Where recorddate = \"" . $row_loop["recorddate"] . "\"and tx1_id=".$x." order by bodycount desc limit 1";
            $result_tim = $conn->query($sql_tim);
            if ($result_tim->num_rows > 0) {
                $row_tim = $result_tim->fetch_assoc();
                $tmp_tim=(int)$row_tim["recordtime"];
            }
            //制作json格式
            $sql = "SELECT *FROM bodycount Where recorddate = \"" . $row_loop["recorddate"] . "\"and tx1_id=".$x." order by bodycount desc limit 1";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                $row = $result->fetch_assoc();
                $tmp_l = null;
                //$tmp_l[] = $row["recordtime"];
                $tmp_l[] = $tmp_tim;
                $tmp_l[] = (int)$row["bodycount"];
                $tmp_l[] = $tmp_sum;
                $tmp_l[] = $row["tx1_id"];
                $tmp_l[] = $row["recorddate"];
                $tmp_m[] = $tmp_l;

            } else {
                //echo "0 结果";
            }
        }
        $user->series[]=$tmp_m;
    }
}
//$user->series[]=$tmp_day;
//$array[]=$user;
$data=json_encode($user);
file_put_contents( 'src.json', $data );
//echo $data;

$conn->close();
?>