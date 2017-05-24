<?php
/* (C) 2017 VSTek Network Capital Corporation.
 * Version 3.04.2 rev 2
 * Latest Update: Change Password verify method.
 * INFO: It's Spring.
 */

//-------------------------------------------------------------
// Change mainfile If you want to operate with another name.*
// $mainfile = "chat.php";
// *Update: Version 3.04.2 rev 1 or Higher: No longer required.
//-------------------------------------------------------------
// Change title If you want to operate with another title.
   $title = "こんにちは世界";
//-------------------------------------------------------------
// Change knowname If you want to operate with another u-name.
   $knowname = "名無しさん";
//-------------------------------------------------------------

/*--- Please do not edit below this. ---*/
//define
$file     =        "logsx.mx";
$pass     =        "passw.mx";
$okdata   =        "newuser";
$myname   = $_POST["myname"];
$mypass   = $_POST["mypass"];
$message  = $_POST["message"];
$chkdgt   = $_POST["chkdgt"];
$tbody    =        "";
$form     =        "";
$mainfile = basename($_SERVER["PHP_SELF"]);
$message  = str_replace('<', '&lt;', $message);
$message  = str_replace('>', '&gt;', $message);
//end define
if(strcmp($myname,"")==0) {
    if(strcmp($chkdgt,"")==0) {
        $myname = $knowname;
        $mypass = "";
    } else {
        $form .= "<input type = \"hidden\" name = \"myname\" id = \"myname\" value = \"".$myname."\"><input type = \"hidden\" name = \"mypass\" id = \"mypass\" value = \"".$mypass."\"><input type = \"hidden\" name = \"chkdgt\" id = \"chkdgt\" value = \"1\">";
    }
} else {
    $form .= "<input type = \"hidden\" name = \"myname\" id = \"myname\" value = \"".$myname."\"><input type = \"hidden\" name = \"mypass\" id = \"mypass\" value = \"".$mypass."\"><input type = \"hidden\" name = \"chkdgt\" id = \"chkdgt\" value = \"1\">";
}
if(file_exists($file)) {
    $logsx = json_decode(file_get_contents($file));
}
if(file_exists($pass)) {
    $passw = json_decode(file_get_contents($pass));
}
$hpass       = password_hash($mypass, PASSWORD_DEFAULT);
$userdata    = $myname.",".$hpass;
$messagedata = $myname.",".$message;
foreach($passw as $usdata) {
    $namedata = explode(",", $usdata);
    if(strcmp($namedata[0],$myname)==0) {
        if(password_verify($mypass,$namedata[1])) {
            $okdata = "true";
        } else {
            $okdata = "igpass";
        }
    }
}
if(strcmp($message,"")==0) {
    if(strcmp($chkdgt,"")==0) {
        $okdata = "notvul";
    } else {
        $okdata = "reload";
    }
}
switch($okdata) {
    case "true":
        $logsx[] = $messagedata;
        file_put_contents($file, json_encode($logsx));
        foreach($logsx as $msg) {
            $msgdata = explode(",", $msg);
            $tbody .= "<tr><td class = \"mdl-data-table__cell--non-numeric\">".$msgdata[0]."</td><td class = \"mdl-data-table__cell--non-numeric\">".$msgdata[1]."</td></tr>";
        }
        break;
        //true
    case "igpass":
        $tbody .= "<tr><td class = \"mdl-data-table__cell--non-numeric\">システム</td><td class = \"mdl-data-table__cell--non-numeric\">パスワードが違います。</td></tr>";
        break;
        //ignorepass
    case "newuser":
        $passw[] = $userdata;
        $logsx[] = $messagedata;
        file_put_contents($pass, json_encode($passw));
        file_put_contents($file, json_encode($logsx));
        foreach($logsx as $msg) {
            $msgdata = explode(",", $msg);
            $tbody .= "<tr><td class = \"mdl-data-table__cell--non-numeric\">".$msgdata[0]."</td><td class = \"mdl-data-table__cell--non-numeric\">".$msgdata[1]."</td></tr>";
        }
        break;
        //newuser
    case "notvul":
        $tbody .= "<tr><td class = \"mdl-data-table__cell--non-numeric\">システム</td><td class = \"mdl-data-table__cell--non-numeric\">ようこそ。ログを見るためには名前、パスワード、本文を入力して投稿してください。<br>本文のみの場合自動的に「名無しさん」が設定されます。<br>このシステムは<ruby><rb>決して安全ではないため</rb><rp>(</rp><rt>ザルであるため</rt><rp>)</rp></ruby>、他のサイトのパスワードを流用することはお控えください。</td></tr>";
        break;
        //notvul
    case "reload":
        file_put_contents($file, json_encode($logsx));
        foreach($logsx as $msg) {
            $msgdata = explode(",", $msg);
            $tbody .= "<tr><td class = \"mdl-data-table__cell--non-numeric\">".$msgdata[0]."</td><td class = \"mdl-data-table__cell--non-numeric\">".$msgdata[1]."</td></tr>";
        }
        $tbody .= "<tr><td class = \"mdl-data-table__cell--non-numeric\">システム</td><td class = \"mdl-data-table__cell--non-numeric\">更新されました。(このメッセージはログに記録されません。)</td></tr>";
        break;
        //reload
    default:
        $tbody .= "<tr><td class = \"mdl-data-table__cell--non-numeric\">システム</td><td class = \"mdl-data-table__cell--non-numeric\">不明なエラーです。もう一度お試しください。</td></tr>";
        break;
        //error
}
/* (C)2017 natsumi corporation, nakoWeb, VSTek Network Capital Corporation.
 * All rights reserved. License: GNU General Public License.
 * Credit Information cannot be erased.
 */
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8">
<title><?=$title;?></title>
<link rel="stylesheet" href="https://storage.googleapis.com/code.getmdl.io/1.0.0/material.indigo-pink.min.css">
<script src="https://storage.googleapis.com/code.getmdl.io/1.0.0/material.min.js"></script>
<link rel="stylesheet" href="https://fonts.googleapis.com/icon?family=Material+Icons">
</head>
<body>
    <form action = <?=$mainfile;?> method = "POST">
        <div class = "mdl-textfield mdl-js-textfield mdl-textfield--expandable">
            <label class = "mdl-button mdl-js-button mdl-button--icon" for = "myname">
                <i class = "material-icons">account_circle</i>
            </label>
            <div class = "mdl-textfield__expandable-holder">
                <input class = "mdl-textfield__input" type = "text" id = "myname" name = "myname">
                <label class = "mdl-textfield__label" for = "myname">投稿者名…</label>
            </div>
        </div>
        <div class = "mdl-textfield mdl-js-textfield mdl-textfield--expandable">
            <label class = "mdl-button mdl-js-button mdl-button--icon" for = "mypass">
                <i class = "material-icons">lock</i>
            </label>
            <div class = "mdl-textfield__expandable-holder">
                <input class = "mdl-textfield__input" type = "password" id = "mypass" name = "mypass">
                <label class = "mdl-textfield__label" for = "mypass">パスワード…</label>
            </div>
        </div>
        <div class="mdl-textfield mdl-js-textfield">
            <input type = "text" class = "mdl-textfield__input" name = "message" id = "message" style = "width:250%">
            <label class = "mdl-textfield__label" for = "message">本文…</label>
        </div>
        <input type = "submit" value = "投稿&nbsp;/&nbsp;更新" style = "width:100%" class = "mdl-button mdl-js-button mdl-button--raised mdl-button--accent">
        <?=$form;?>
    </form>
    <table class = "mdl-data-table mdl-js-data-table mdl-shadow--2dp" width = "100%">
        <thead>
            <tr>
                <th class = "mdl-data-table__cell--non-numeric" width = "10%">投稿者</th>
                <th class = "mdl-data-table__cell--non-numeric" width = "90%">本文</th>
            </tr>
        </thead>
        <tbody>
            <?=$tbody;?>
        </tbody>
    </table>
</body>
</html>
