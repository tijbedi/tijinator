<?php
/**
 * This is the DbTable class for the Events table.
 * @package Models-DBTable
 * @author 	KBedi
 * @version	1.0
 * @todo 	Add logging
 */
class DbTable_Responses extends Zend_Db_Table_Abstract
{
    /** Table name */
    protected $_name    = 'response';
    protected $_primary = 'id';
    
    /* Relationships */
	protected $_dependentTables = array('DbTable_Debate','DbTable_ResponseType');
	
	/* Dependencies */
    protected $_referenceMap    = array(
        'Debate' => array(
            'columns'           => 'debate',
            'refTableClass'     => 'DbTable_Debate',
            'refColumns'        => 'id'
        ),
            
        'Creator' => array(
            'columns'           => 'user',
            'refTableClass'     => 'DbTable_Users',
            'refColumns'        => 'user_id'
        ),
        
        'ResponseType' => array(
            'columns'           => 'type',
            'refTableClass'     => 'DbTable_ResponseTypes',
            'refColumns'        => 'id'
        ),
    );

    /**
     * Insert new row
     * Ensure that a timestamp is set for the created field.
     * @param  array $data 
     * @return int|boolean
     */
    public function insert(array $data)
    {   	
        return parent::insert($data);
    }

    /**
     * Method to delete a row
     * @param 	$where
     * @return 	int|boolean
     */
    public function delete($where)
    {
    	try
    	{
        	return parent::delete($where);
    	}
        catch(Zend_Db_Exception $e)
        {
    		return false;
    	}
    }

	/**
	 * Update Row(s)
	 * @param  array $data 
	 * @param  mixed $where 
	 * @return int|boolean
	 */
    public function update(array $data, $where)
    {
    	try
    	{
     		return parent::update($data,$where);
        }
        catch(Zend_Db_Exception $zdbe)
        {
    		return false;
    	}
    }
}
?>
