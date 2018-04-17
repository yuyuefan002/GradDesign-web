var Dev_id = [];
//创建select元素
function createSelect(){
    var mySelect = document.createElement("select");
    mySelect.id = "mySelect";
    document.body.appendChild(mySelect);
}
//获取设备编号
function GetDev() {
    $.ajax({
        type: "get",
        async: false,   //同步加载，true为异步加载
        url: "php/db_GetDev.php",
        data: {},
        dataType: "json",
        success: function(result){
            var unitObj=document.getElementById("mySelect");//页面上的select元素
            if(result){
                for(var i = 0 ; i < result.length; i++){
                    unitObj.options.add(new Option(result[i].id));//增加option
                }
            }
        },
        error: function(ErrMsg) {
            alert("Ajax获取服务器数据出错了！"+ ErrMsg);
        }
    });
    return Dev_id;
}