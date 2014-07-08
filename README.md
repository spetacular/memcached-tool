memcached-tool
==============

While we can connect memcache/memcached by telnet as below:

    telnet localhost 12345

But sometimes we wish to use php tools to do this job. That's why I create memcached-tool for php.

# Usuage
    Usage: path/to/php memcached-tool.php host:port [cmd] [option]
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 stats                 # shows general stats
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 stats --debug         # shows general stats with debug info
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 "stats slabs"         # shows slabs
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 "stats sizes"         # shows sizes stats
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 "stats shows"         # shows sizes stats

# Example
>$php memcached-tool.php 127.0.0.1:11211 "version"

    +---------+-------+ 
    | Field   | Value | 
    +---------+-------+ 
    | VERSION | 1.2.8 | 
    +---------+-------+ 

>$php memcached-tool.php 127.0.0.1:11211 "stats " 

    +------+-----------------------+-------------+
    | Type | Field                 | Value       |
    +------+-----------------------+-------------+
    | STAT | pid                   | 15171       |
    | STAT | ****                  | ****        |
    | STAT | time                  | 1404810575  |
    | STAT | listen_disabled_num   | 0           |
    +------+-----------------------+-------------+

# Thanks
The pretty table is the awesome work of "Console Table".

pear:http://pear.php.net/package/Console_Table/

git:https://github.com/pear/Console_Table
