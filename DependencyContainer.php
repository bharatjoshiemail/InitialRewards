<?php 
class DependencyContainer 
{
	private $_instance;
    private $_params = array();

    public function __construct()
    {
		// To make more dynamic we can pass params in constructor as well.
        $this->_params = array('dsn'=>'mysql:host=localhost;dbname=initial_rewards',
							'dbUser' => 'root',
							'dbPwd' => '');
    }

    public function getDb()
    {
        if (empty($this->_instances['db']) 
            || !is_a($this->_instances['db'], 'PDO')
        ) {
			$options = array(
				PDO::MYSQL_ATTR_INIT_COMMAND => 'SET NAMES utf8',
			);
            $this->_instance = new PDO(
                $this->_params['dsn'],
                $this->_params['dbUser'], 
                $this->_params['dbPwd'],
				$options
            );
			/*
			The below setAttribute tells PDO to disable emulated prepared statements and use real prepared statements. 
			This makes sure the statement and the values aren't parsed by PHP before sending it to 
			the MySQL server (giving a possible attacker no chance to inject malicious SQL).
			*/
			$this->_instance->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->_instance->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return $this->_instance;
    }
}

?>