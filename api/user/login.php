<?php


use Firebase\JWT\JWT;
use Firebase\JWT\Key;

include ("../../JWT/JWT.php");
include ("../../JWT/Key.php");

$requestMethod = $_SERVER["REQUEST_METHOD"];
$data = json_decode(file_get_contents('php://input'), true);

var_dump($data);

if(!isset($data["name"])) {
    echo "error";
    exit();
}

if(!isset($data["password"])) {
    echo "error";
    exit();
}

$pdo = new PDO("mysql:host=localhost:3306;dbname=can302_ass1", "root", null);


$sql = "
    SELECT
    id, name, password, salt
    FROM user
    where name='{$data["name"]}'
";

$result = $pdo->query($sql)->fetch(PDO::FETCH_ASSOC);

$hashed = hash("md5", $data["password"].$result["salt"]);

if($hashed === $result["password"]) {
    echo "In";
    $key = 'example_key';
    $payload = [
        'iss' => $result["id"],
    ];

    /**
     * IMPORTANT:
     * You must specify supported algorithms for your application. See
     * https://tools.ietf.org/html/draft-ietf-jose-json-web-algorithms-40
     * for a list of spec-compliant algorithms.
     */
    $jwt = JWT::encode($payload, $key, 'HS256');
//    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));
    echo $jwt;

//    print_r($decoded);

    /*
     NOTE: This will now be an object instead of an associative array. To get
     an associative array, you will need to cast it as such:
    */

//    $decoded_array = (array) $decoded;

    /**
     * You can add a leeway to account for when there is a clock skew times between
     * the signing and verifying servers. It is recommended that this leeway should
     * not be bigger than a few minutes.
     *
     * Source: http://self-issued.info/docs/draft-ietf-oauth-json-web-token.html#nbfDef
     */
//    JWT::$leeway = 60; // $leeway in seconds
//    $decoded = JWT::decode($jwt, new Key($key, 'HS256'));

} else {
    echo "Wrong password";
}

//echo json_encode($result);