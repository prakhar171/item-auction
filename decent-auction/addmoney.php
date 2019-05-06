<?php
  
    include("functions/functions.php");
    $base_url="10.1.18.33:3000/api/";
    $access_token="zV5N6mEyiL7MpuWvldgnIQZhpxhxP7arysiyCTUkEBeyLvRv0EQi1Gz32q1vnFit";


// $urlitem="10.1.18.33:3000/api/Item/1?access_token=zV5N6mEyiL7MpuWvldgnIQZhpxhxP7arysiyCTUkEBeyLvRv0EQi1Gz32q1vnFit";
// $getitem=callAPI('GET',$urlitem,false);

// echo "$getitem";

// $itemlist=array(
//   "\$class" => "org.example.mynetwork.ItemListing",
//   "listingId" => "2",
//   "reservePrice" => 100,
//   "description" => "string",
//   "state" => "FOR_SALE",
//   "enddate" => "Sun May 05 2019 19:50:40 GMT+0530 (India Standard Time)",
//   "offers" => [],
//   "EncBids" => [],
//   "item" => "resource:org.example.mynetwork.Item#2"
// );

// $iteml=json_encode($itemlist);

// echo "$iteml";
// echo "\n";

// $url="10.1.18.33:3000/api/ItemListing/?access_token=zV5N6mEyiL7MpuWvldgnIQZhpxhxP7arysiyCTUkEBeyLvRv0EQi1Gz32q1vnFit";
// echo callAPI('POST',$url,$iteml);

// {
//   "$class": "org.example.mynetwork.Offer",
//   "bidPrice": "100",
//   "listing": "resource:org.example.mynetwork.ItemListing#2",
//   "member": "resource:org.example.mynetwork.Member#a@z"
// }

// $offer=array(
//   "\$class" => "org.example.mynetwork.Offer",
//   "bidPrice" => "200",
//   "listing" => "resource:org.example.mynetwork.ItemListing#2",
//   "member" => "resource:org.example.mynetwork.Member#a%40z"
// );

// $offer=json_encode($offer);

// $email= "harshk0525@gail.com";

// $url="10.1.18.33:3000/api/Member/".$email."?access_token=zV5N6mEyiL7MpuWvldgnIQZhpxhxP7arysiyCTUkEBeyLvRv0EQi1Gz32q1vnFit";
// // echo callAPI('GET',$url,false);

// // $url="10.1.18.33:3000/api/ItemListing/2?access_token=zV5N6mEyiL7MpuWvldgnIQZhpxhxP7arysiyCTUkEBeyLvRv0EQi1Gz32q1vnFit";
// $res= callAPI('GET',$url,false);

// $res1=json_decode($res,true);
// $email="harshk025";
// $add_mem=json_encode(array(
//           "\$class"=>"org.example.mynetwork.Member",
//           "balance"=>800,
//           "key"=>"1",
//           "email"=>"harshk025",
//           "password"=>"njsds",
//           "firstName"=>"F",
//           "lastName"=>"L"
//             )
//         );
// $add_url= $base_url."Member/".$email."?access_token=".$access_token;
// $res=json_decode(CallAPI('PUT',$add_url,$add_mem), true);

// print_r($res);

// $list_url=$base_url."/ItemListing?access_token=".$access_token;

// $get_list=json_decode(CallAPI('GET',$list_url,false), true);

// print_r($get_list);

// print_r(openssl_get_cipher_methods());


// $key="322a1f6bc8bbed5e541ebe77619cb9a3635804d32db5523bc03029a51122e8b21163267a641d2693901854cde79a9860a4fdf070bce56b7ff53b479b37f5dfcc";



// $dec=decryptAES( hex2bin($key),"key1");

// echo "\n";

// echo "$dec";

// $get_mem=$add_url= $base_url."Member/"."a@b"."?access_token=".$access_token;

// $mem_detail=json_decode(CallAPI('GET',$add_url,false), true);

// if (!array_key_exists("error", $mem_detail)) {

//   print_r($mem_detail['itembids']);
// }

$data="9688806666666666666666608878032gkhcghkkckhvcbvjhb";

$enc= RSAencrypt($data);

echo RSAdecrypt($enc);
?>