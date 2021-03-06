<?php

pcntl_signal(SIGINT, "out");

$ret = 0;

$actions = [
    'new',
    'help',
    'update'
];

$path = null;
$action = false;
$options = [];

$params = array(
    'h::' => 'help'
);

$options = getopt(implode('', array_keys($params)), $params );


if($options) {
    call_user_func('Action_main', $options);
}

foreach ($argv as $k=>$v) {
    if(in_array($v, $actions)) {
        $action = $v;
    }
}

if(!$action || $action == 'help') {
    out('help');
}

switch ($action) {
    case 'new':
        for($i = 0; $i<$argc; $i++) {
            if($argv[$i] == $action) {
                if(!isset($argv[$i+1])) {
                    out(1);
                    break;
                }
                $path = $argv[$i+1];
                Action_new($path);
            }
        }
        break;
    case 'update':
        $path = realpath($argv[0]);
        Action_update($path);
        break;
}

function Action_main($options) {

    switch (array_keys($options)) {
        default:
        case 'h' :
        case 'help':
            out('help');
            break;

    }
}

function Action_new($path) {

    if(!$path) {
        out(1);
    }

    $tmp_dir = sys_get_temp_dir();

    file_put_contents($tmp_dir.'/VX.Skeleton.zip', fopen('https://github.com/ximik777/VX.Skeleton/archive/v0.0.0.zip', 'r'));

    if(!mkdir($path, 0775, true)){
        out(2);
    }

    $zip = new ZipArchive;
    $res = $zip->open($tmp_dir.'/VX.Skeleton.zip');
    if ($res === TRUE) {
        $zip->extractTo($path);
        $zip->close();
        echo "VX.Skeleton.zip extracted to $path".PHP_EOL;
    } else {
        out(3);
    }

    out(4);

}

function Action_update($path) {

    $agent = 'VX.Skeleton';

    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, $agent);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_URL, 'https://api.github.com/repos/ximik777/VX.Skeleton/contents/bin/vx');
    $result = curl_exec($ch);
    curl_close($ch);

    $obj = json_decode($result);

    $self_base64 = chunk_split(base64_encode(file_get_contents($path)), $l=60, $e="\n");

    if($self_base64 == $obj->content) {
        out('latest version');
    }

    $tmp = hash('crc32', time().rand(111,999));

    file_put_contents($path, fopen('https://raw.githubusercontent.com/ximik777/VX.Skeleton/master/bin/vx?'.$tmp, 'r'));

    echo "VX file successfully updated at $path";

    out();

}

function out($err = false) {
    global $ret;
    switch ($err) {

        case 'help':
            echo("".PHP_EOL.
                "Welcome to the vx".PHP_EOL.
                "\e[32mAvailable commands:\e[0m".PHP_EOL.
                "\t\e[35mhelp\e[0m".PHP_EOL.
                "\t\e[35mnew <project_path>\e[0m".PHP_EOL.
                "\t\e[35mupdate\e[0m".PHP_EOL.
                "".PHP_EOL.
                "(c) vx".PHP_EOL
            );
            break;
        case 'latest version':
            echo PHP_EOL."У вас уже установлена последняя версия VX".PHP_EOL;
            $ret =1;
            break;
        case 1:
            echo PHP_EOL."Укажите имя проекта".PHP_EOL;
            $ret =1;
            break;
        case 2:
            echo PHP_EOL."Не удалось создать папку по указанному пути".PHP_EOL;
            unlink(sys_get_temp_dir().'/VX.Skeleton.zip');
            $ret =1;
            break;
        case 3:
            echo PHP_EOL."Не удалось распаковать архив".PHP_EOL;
            unlink(sys_get_temp_dir().'/VX.Skeleton.zip');
            $ret =1;
            break;
        case 4:
            unlink(sys_get_temp_dir().'/VX.Skeleton.zip');
            continue;
        default:
            echo PHP_EOL."Have a nice day!".PHP_EOL;
            break;

    }


    exit($ret);
}