<?php
   $accessToken = "dqlJ7qi+56CkIeXXjTYdu+vdV2pwsjB0dY9UMQDNO7be8ymtAVJO6PUkAxBKR0hdMde88YOy+xwPVGYUz06KWEZqjSo7g0o+GFkvBeHp+nnFblLPeRgz+pxef1wfVnIKs66z7jZtQzPonUFouqQFCAdB04t89/1O/w1cDnyilFU=";//copy ข้อความ Channel access token ตอนที่ตั้งค่า
   $content = file_get_contents('php://input');
   $arrayJson = json_decode($content, true);
   $arrayHeader = array();
   $arrayHeader[] = "Content-Type: application/json";
   $arrayHeader[] = "Authorization: Bearer {$accessToken}";
   //รับข้อความจากผู้ใช้
   $message = $arrayJson['events'][0]['message']['text'];
   //รับ id ของผู้ใช้
   $id = $arrayJson['events'][0]['source']['userId'];
   $group = $arrayJson['events'][0]['source']['groupId'];


#ตัวอย่าง Message Type "Text + Sticker"
   if($message == "สวัสดี" or $message == "สวัสดีครับ"){
      $arrayPostData['to'] = $id;
      $arrayPostData['messages'][0]['type'] = "text";
      $arrayPostData['messages'][0]['text'] = "สวัสดีจ้าาา";
      $arrayPostData['messages'][1]['type'] = "sticker";
      $arrayPostData['messages'][1]['packageId'] = "2";
      $arrayPostData['messages'][1]['stickerId'] = "34";
      $arrayPostData['messages'][2]['type'] = "text";
      $arrayPostData['messages'][2]['text'] = $id;
      $arrayPostData['messages'][2]['type'] = "text";
      $arrayPostData['messages'][2]['text'] = $group;
      pushMsg($arrayHeader,$arrayPostData);
   }


if($message == "นับ 1-10"){
       for($i=1;$i<=10;$i++){
          $arrayPostData['to'] = $id;
          $arrayPostData['messages'][0]['type'] = "text";
          $arrayPostData['messages'][0]['text'] = $i;
          pushMsg($arrayHeader,$arrayPostData);
       }
    }




   function pushMsg($arrayHeader,$arrayPostData){
      $strUrl = "https://api.line.me/v2/bot/message/push";
      $ch = curl_init();
      curl_setopt($ch, CURLOPT_URL,$strUrl);
      curl_setopt($ch, CURLOPT_HEADER, false);
      curl_setopt($ch, CURLOPT_POST, true);
      curl_setopt($ch, CURLOPT_HTTPHEADER, $arrayHeader);
      curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($arrayPostData));
      curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
      curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
      $result = curl_exec($ch);
      curl_close ($ch);
   }
   exit;
?>
