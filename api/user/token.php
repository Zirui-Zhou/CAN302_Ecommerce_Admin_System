
<?php

use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include ("../../JWT/JWT.php");
include ("../../JWT/Key.php");
        //Yii框架获取 header 参数
//$headers = \Yii::$app->getRequest()->getHeaders();
//
//        //取出 Token 值
//$token = $headers->get('token');
//$token = $_SERVER['token'];

//
//        //判断没有 Token 就返回需要登录信息
//if(empty($token)){
//        //没有token,也需要重新登录
//    echo "error**";
//    exit();
//}else{
//    echo $token;
//}
//
$token = getallheaders()["Token"];
$key = 'example_key';
$decoded = JWT::decode($token, new Key($key, 'HS256'));
$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);
$sql = "
    SELECT
    id
    FROM user
    where id='{$decoded->iss}'
";
$result = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);
if($result["id"]){
   echo "SUCCESS";
}else{
    echo "Erro";
}
//        //如果当前时间大于或等于数据库保存的登录时间，则返回登录过期信息
//if(empty($result)){
//    echo"error&&";
// }else{
//    var_dump($result); ;

//
//

