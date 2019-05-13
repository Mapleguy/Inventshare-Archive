<?php
class DB
{
	private static function Connect()
	{
		$pdo = new pdo('mysql:host=localhost;dbname=inventshare;charset=utf8', 'root', 'B8BleI4kSNfU');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	}
	
	public static function Query($query, $params)
	{
		$statement = self::Connect()->prepare($query);
		$statement->execute($params);
                if(explode(' ', $query)[0] == 'SELECT')
                {
                    $data = $statement->fetchAll();
                    return $data;
                }
	}
        
        private static function ConnectExternal($connection, $db)
	{
		$pdo = new pdo('mysql:host='.$connection.';dbname='.$db.';charset=utf8', 'root', '');
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return $pdo;
	}
        
        public static function QueryExternal($query, $params, $destination, $database)
	{
		$statement = self::ConnectExternal($destination, $database)->prepare($query);
		$statement->execute($params);
                if(explode(' ', $query)[0] == 'SELECT')
                {
                    $data = $statement->fetchAll();
                    return $data;   
                }
	}
}
?>