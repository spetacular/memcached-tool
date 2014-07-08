<?php
error_reporting(E_ALL);
if (php_sapi_name() != "cli") {
    echo "Please run this script using the CLI version of PHP\n";
    exit;
}
if ($argc < 2) {
    $diemsg = <<<EOT
Usage: path/to/php {$argv[0]} host:port [cmd] [option]
	/usr/local/php/bin/php {$argv[0]} 127.0.0.1:11211 stats			# shows general stats
        /usr/local/php/bin/php {$argv[0]} 127.0.0.1:11211 stats	--debug		# shows general stats with debug info
	/usr/local/php/bin/php {$argv[0]} 127.0.0.1:11211 "stats slabs"		# shows slabs
	/usr/local/php/bin/php {$argv[0]} 127.0.0.1:11211 "stats sizes"		# shows sizes stats
	/usr/local/php/bin/php {$argv[0]} 127.0.0.1:11211 "stats shows"		# shows sizes stats
Support Cmd: stats,get,version. If This Tool doesn't terminate automatically, Press Ctrl + C to kill it.
EOT;
    die($diemsg);
}



//server and port for memcached service.
if (isset($argv[1])) {
    list($address, $service_port) = explode(':', $argv[1], 2);
} else {
    $service_port = 11212;
    $address = '172.27.206.224';
}
//command
if (isset($argv[2])) {
    $cmd = $argv[2];
} else {
    $cmd = 'stats';
}

/* Create a TCP/IP socket. */
$socket = socket_create(AF_INET, SOCK_STREAM, SOL_TCP);


if ($socket === false) {
    dlog("socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n");
} else {
    dlog("socket create OK.\n");
}
/* Connect to memcache server */
dlog("Attempting to connect to '$address' on port '$service_port'...");
$result = socket_connect($socket, $address, $service_port);
if ($result === false) {
    dlog("socket_connect() failed.\nReason: ($result) " . socket_strerror(socket_last_error($socket)) . "\n");
} else {
    dlog("socket connect OK.\n");
}

$in = "{$cmd}\n";
$out = '';
/* send cmd to memcache server */
dlog("send msg:{$in} ");
socket_write($socket, $in, strlen($in));
dlog("OK.\n");
/* receive response from memcache server */
dlog("Reading response:\n");
$rsp = "";
while ($out = socket_read($socket, 2048)) {
    dlog($out, true);
    $rsp .=$out;
    if (strpos($out, "END") !== false || strpos($out, "VERSION") !== false) {
        break;
    }
    //strpos($out, "\n") !== false || 
}
showResult($rsp, $cmd);

dlog("Closing socket...");
socket_close($socket);
dlog("OK.\n\n");

/**
 * print result pretty
 * @param String $rsp 
 * @param String $cmd
 * @return type
 */
function showResult($rsp, $cmd = '') {
    $rsp = str_replace("END", "", $rsp); //remove END
    $lines = explode("\n", $rsp);
    include('Console_Table.php');
    $tbl = new Console_Table();
    if (preg_match("/^get/i", $cmd)) {
        echo $rsp;
        return;
    }
    $fieldNum = count(explode(" ", $lines[0]));
    if ($fieldNum == 1) {
        $tbl->setHeaders(
                array('Result')
        );
    } else if ($fieldNum == 2) {
        $tbl->setHeaders(
                array('Field', 'Value')
        );
    } else if ($fieldNum == 3) {
        $tbl->setHeaders(
                array('Type', 'Field', 'Value')
        );
    } else {
        $headerArray = array('Type');
        for ($i = 0; $i < $fieldNum; $i++) {
            $headerArray[] = "Item" . ($i + 1);
        }
        $tbl->setHeaders(
                $headerArray
        );
    }

    foreach ($lines as $line) {
        $line = trim($line);
        if (empty($line)) {
            continue;
        }
        $tbl->addRow(explode(" ", $line));
    }

    echo $tbl->getTable();
}
/**
 * simple debug method
 * @global type $argv
 * @param type $msg
 * @param type $dump use var_dump or echo
 */
function dlog($msg, $dump = false) {
    global $argv;
    if (isset($argv[3]) && $argv[3] == '--debug') {
        if ($dump) {
            var_dump($msg);
        } else {
            echo $msg;
        }
    }
}
?>
