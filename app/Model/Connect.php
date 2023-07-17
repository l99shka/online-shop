<?php

class Connect
{
    public function connect():PDO
    {
        return new PDO('pgsql:host=db;dbname=dbname', 'dbuser', 'dbpwd');
    }
}
