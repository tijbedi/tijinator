<?php
/**
 * Reponse Model ORM
 * 
 * @package Models
 * @author 	KBedi
 * @version	1.0
 */
class Responses
{
    protected $_table;
    private $_db;

    /**
     * Class Contructor
     * @return void
     */
    public function __construct()
    {
		$registry = Zend_Registry::getInstance();
		$this->_db = $registry->get("dbAdapter");
		Zend_Db_Table_Abstract::setDefaultAdapter($this->_db);
    }

	/**
	* Retrieve table object
	* @return Model_BiTools_Table
	*/
	public function getTable()
	{
		if (null === $this->_table)
		{
			$this->_table = new DbTable_Responses();
		}
		return $this->_table;
	}
		

	/**
	 * Delete all records from the table
	 * @return boolean | int
	 */
	public function removeAll()
	{
		$table  = $this->getTable();
		return $table->delete('1=1');	
	}

	/**
	* Save a new entry
	* @param  array $data 
	* @return int|string
	*/
	public function save(array $data)
	{
		$table  = $this->getTable();
		$fields = $table->info(Zend_Db_Table_Abstract::COLS);
		
		//Store the brand_id as that will be spliced after the forthcoming loop		
		foreach ($data as $field => $value)
		{
			if (!in_array($field, $fields))
			{
				unset($data[$field]);
			}
		}
		
		//Get table metadata
		$info = $table->info();

		if($data[$info['primary'][1]] > 0 )
		{
			return $table->update($data,$where);
		}
		else
		{
			$data['id'] = null;
			$data['user'] = 1;		
			return $table->insert($data);
		}
	}

	/**
	 * Fetch all entries
	 * @return Zend_Db_Table_Rowset_Abstract
	 */
	public function fetchAll()
	{
		/**
		 * Return all the data
		 */
		return $this->getTable()->fetchAll()->toArray();
	}

	/**
	 * Fetch an individual entry
	 * @param  int|string $id 
	 * @return Array of Zend_Db_Table_Row_Abstract 
	 */
	public function fetchEntry($id)
	{
		return $this->getTable()->find($id)->current();
	}
	
	/**
	 * Fetch an individual entry
	 * @param  int|string $id 
	 * @return Array of Zend_Db_Table_Row_Abstract 
	 */
	public function fetchEntryByUrlkey($urlkey)
	{		
		return $this->getTable()->fetchAll("urlkey = '$urlkey'")->current();		
	}
		
	/**
	 * Fetch an individual entry
	 * @param  int|string $id 
	 * @return Array of Zend_Db_Table_Row_Abstract 
	 */
	public function fetchEntryByDate($debateDate)
	{		
		return $this->getTable()->fetchAll("opendate = '$debateDate'")->current();		
	}

}
?>
