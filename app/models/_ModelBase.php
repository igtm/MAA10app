<?php 
// PDO接続
class ModelBase{
	protected $db;
	protected $table_name;
	
	public function __construct(){
		$this->initDB();	
	}
	
	public function initDB(){
		$pdo = new PDO(DSN,USER_NAME,PASSWORD,
					array(PDO::ATTR_EMULATE_PREPARES => false,
					PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8'));
		$pdo->query("SET NAMES utf8");
		$pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		$this->db = $pdo;
	}

    // クエリ結果を取得
    public function select($select, array $params = array())
    {	
		$arr = array();
		foreach((array)$params as $key => $value) {
        $arr[] = $key. "=:".$key;
		}
		$where_new = join(" AND ",$arr);
		$sql = 'SELECT '.$select.' FROM '.$this->table_name.' WHERE '.$where_new;
        $stmt = $this->db->prepare($sql);
            foreach ($params as $key => $val) {
                $stmt->bindValue(':' . $key, $val);
            }
        $stmt->execute();
        $rows = $stmt->fetchAll();
		$stmt->closeCursor();
        return $rows;
	}
	
	public function insert($data)
    {
        $fields = array();
        $values = array();
        foreach ($data as $key => $val) {
            $fields[] = $key;
            $values[] = ':' . $key;
        }
        $sql = sprintf(
            "INSERT INTO %s (%s) VALUES (%s)", 
            $this->table_name,
            implode(',', $fields),
            implode(',', $values)
        );
        $stmt = $this->db->prepare($sql);
        foreach ($data as $key => $val) {
            $stmt->bindValue(':' . $key, $val);
        }
        $res  = $stmt->execute();

        return $res;        
    }
}
?>