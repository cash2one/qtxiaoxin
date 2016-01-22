<?php
class MClassTest extends PHPUnit_Extensions_Database_TestCase
{
    static private $pdo = null;
    private $conn = null;
    
    public function getConnection()
    {
        if($this->conn === null)
        {
            if(self::$pdo == null)
                self::$pdo = new PDO('mysql:dbname=user_center_unit;host=192.168.1.12', 'dbManager', 'QtSql2014');
            $this->conn = $this->createDefaultDBConnection(self::$pdo, 'user_center_unit');
        }
        return $this->conn;
    }
    
    /**
     * @return PHPUnit_Extensions_Database_DataSet_IDataSet
     */
    //public function getDataSet()
    //{
    //    //return $this->createFlatXMLDataSet(dirname(__FILE__).'/_files/guestbook-seed.xml'); 
    //}
    
    protected function getDataSet()
    {
        return new MyApp_DbUnit_ArrayDataSet(array(
            'tb_class' => array(
                array('name' =>'学前班', 'year' => '2013', 'sid' => '1','stid'=>1,'type'=>0,'master'=>null,'deleted'=>0),
                array('name' =>'学前班', 'year' => '2013', 'sid' => '1','stid'=>1,'type'=>0,'master'=>null,'deleted'=>0),
                array('name' =>'基础班', 'year' => '2013', 'sid' => '1','stid'=>2,'type'=>0,'master'=>null,'deleted'=>0),
                // array('gid' => 2, 'name' => 'grade2', 'stid' => '2','age'=>2),
                // array('gid' => 3, 'name' => 'grade3', 'stid' => '3','age'=>3),
            ),
            // 'tb_class_student_relation' => array(
            //     array('cid' => 1, 'student' => '1', 'state' => 1,'creater'=>1),
            // ),

            // 'tb_class_teacher_relation' => array(
            // ),
            
        ));
    }

    public function testInitDb()
    {
        $dataSet = $this->getConnection()->createDataSet(); 
    }

    public function testLoadByPk()
    {
        $class_pks = array(2,3);
        foreach($class_pks as $cid){
            $class = MClass::model()->loadByPk($cid);
            $this->assertEquals(0, $class->deleted);
        }
        
    }
}

class MyApp_DbUnit_ArrayDataSet extends PHPUnit_Extensions_Database_DataSet_AbstractDataSet
{
    /**
     * @var array
     */
    protected $tables = array();

    /**
     * @param array $data
     */
    public function __construct(array $data)
    {
        foreach ($data AS $tableName => $rows) { 
            $columns = array();
            if (isset($rows[0])) {
                $columns = array_keys($rows[0]);
            }

            $metaData = new PHPUnit_Extensions_Database_DataSet_DefaultTableMetaData($tableName, $columns);
            $table = new PHPUnit_Extensions_Database_DataSet_DefaultTable($metaData);

            foreach ($rows AS $row) {
                $table->addRow($row); 
            }
            $this->tables[$tableName] = $table; 
        }
    }

    protected function createIterator($reverse = FALSE)
    {
        return new PHPUnit_Extensions_Database_DataSet_DefaultTableIterator($this->tables, $reverse); 
    }

    public function getTable($tableName)
    {
        if (!isset($this->tables[$tableName])) {
            throw new InvalidArgumentException("$tableName is not a table in the current database."); 
        }

        return $this->tables[$tableName]; 
    }
}