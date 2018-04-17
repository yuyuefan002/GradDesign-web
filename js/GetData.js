var time = [], BodyCount = [];
function GetData(index1) {
    $.ajax({
        type: "get",
        async: false,   //同步加载，true为异步加载
        url: "php/db_GetData.php?"+index1,
        data: {},
        dataType: "json",
        success: function(result){
            if(result){
                for(var i = 0 ; i < result.length; i++){
                    time.push(result[i].time);
                    BodyCount.push(result[i].bodycount);
                }
            }
        },
        error: function(ErrMsg) {
            alert("Ajax获取服务器数据出错了！"+ ErrMsg);
        }
    });
    return time, BodyCount;
}