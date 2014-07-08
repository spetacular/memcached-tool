memcached-tool
==============

while we can connect memcache/memcached by telnet as below:
    telnet localhost 12345

But we sometimes wish to use php tools to do this job. That's why I create memcached-tool for php.

# Usuage
    Usage: path/to/php memcached-tool.php host:port [cmd] [option]
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 stats                 # shows general stats
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 stats --debug         # shows general stats with debug info
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 "stats slabs"         # shows slabs
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 "stats sizes"         # shows sizes stats
        /usr/local/php/bin/php memcached-tool.php 127.0.0.1:11211 "stats shows"         # shows sizes stats

# Example
 #php memcached-tool.php 127.0.0.1:11211 "version"
+---------+-------+
| Field   | Value |
+---------+-------+
| VERSION | 1.2.8 |
+---------+-------+

# php memcached-tool.php 127.0.0.1:11211 "stats " 
+------+-----------------------+-------------+
| Type | Field                 | Value       |
+------+-----------------------+-------------+
| STAT | pid                   | 15171       |
| STAT | uptime                | 10198683    |
| STAT | time                  | 1404810575  |
| STAT | version               | 1.2.8       |
| STAT | pointer_size          | 64          |
| STAT | rusage_user           | 5046.347377 |
| STAT | rusage_system         | 7739.975718 |
| STAT | curr_items            | 120128      |
| STAT | total_items           | 130305289   |
| STAT | bytes                 | 56578058    |
| STAT | curr_connections      | 10          |
| STAT | total_connections     | 175350915   |
| STAT | connection_structures | 564         |
| STAT | cmd_flush             | 0           |
| STAT | cmd_get               | 143025918   |
| STAT | cmd_set               | 130305289   |
| STAT | get_hits              | 18507769    |
| STAT | get_misses            | 124518149   |
| STAT | evictions             | 55812225    |
| STAT | bytes_read            | 79614229399 |
| STAT | bytes_written         | 24526011518 |
| STAT | limit_maxbytes        | 67108864    |
| STAT | threads               | 2           |
| STAT | accepting_conns       | 1           |
| STAT | listen_disabled_num   | 0           |
+------+-----------------------+-------------+
