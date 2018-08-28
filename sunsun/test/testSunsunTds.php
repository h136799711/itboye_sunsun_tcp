<?php
/**
 * Created by PhpStorm.
 * User: 1
 * Date: 2017-03-10
 * Time: 15:42
 */
require_once __DIR__ . '/../src/helper/Des.php';
require_once __DIR__ . '/../src/decoder/SunsunTDS.php';
require_once __DIR__ . '/../src/po/TdsPo.php';

function toStringData($data)
{
    if (is_array($data)) {
        foreach ($data as $key => &$value) {
            $data[$key] = toStringData($value);
        }
    } elseif (!is_object($data) && !is_string($data)) {
        return strval($data);
    }

    return $data;
}

$str = "{\"resType\":\"101\",\"sn\":\"971\",\"state\":\"0\",\"tm\":\"20171222053120\",\"hb\":\"120\"}";

$data = json_decode($str, JSON_OBJECT_AS_ARRAY);
$data = toStringData($data);
$pwd = "1234bcda";


//$encodeText = \sunsun\decoder\SunsunTDS::encode($data, $pwd);
//var_dump(serialize($encodeText));
//$encrypt = $encodeText;
//$encrypt = "+lZacT+tM08fOC0qYfx8RzbnkJsT0rm9qViATJPLZYfpRkyZcUNldQG3DWtuGY/ZOiuxnPshe76IaVa/CVM8j24MAjVQqjQFMbTjz1jJFcq50TqhBEWNdswqMhp3Opqgobo9PBvGoyJsRuWbBmQJ0o8GAhXyhj9Dr5wyfSQzq66gIzTSjf9FsieQzxOp2K1U6EbgtpuhQwbJElY24aqvEefHCCebQUH4sgdb6NdSebYNVLfmaMzRaPROEDxlyaNTK2SEHEUI1FxVCdnZYMBqikITuojNFY9U/u2rGe3A2g6AJF+DgFEn+SNzjV6SVq+bYXXKuD2TAVLOKTlfp+jz2g==";
$encrypt = "HDTimfo9deYH7GMQHbgBT0P+x/BFOAGLWeRzguc6gVaGThWDmYCwRA==";
//$encrypt = base64_decode($encrypt);
$encodeText = \sunsun\helper\Des::decrypt($encrypt, 'fg1f4hUu');
var_dump($encodeText);
//$encodeText = \sunsun\decoder\SunsunTDS::isLegalPwd($encrypt, $pwd);
//
//$data = [
//    'reqType' => "1",
//    "sn" => "0",
//    "did" => "10000001",
//    "ver" => "V1.0",
//    "pwd" => "gigw+DAcMITN4SuEe6JmkA==",
//];
//$pwd = "1234bcda";
//
//$encodeText = \sunsun\decoder\SunsunTDS::encode($data, $pwd);
//echo($encodeText);