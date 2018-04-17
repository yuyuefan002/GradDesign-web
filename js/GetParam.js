var C1=[],C2=[],C3=[];
function GetParam(){
    C1=window.location.href.split("?")[1]; //得到？后面的所有参数
    C2=C1.split("=")[1]; //得到=后面的所有参数
    C3=C1.split("=")[2];
    return C2,C3;
}