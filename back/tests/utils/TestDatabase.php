
<?php

include_once APP_PATH . 'utils/database.php';

class TestDatabase extends Test
{
    public function doesDatabaseConnect()
    {
        $result = Database::queryGetDbName();

        $dbName = $result['data']['db_name'];

        $this->assertType($dbName, 'string');
        $this->assertEqual($dbName, DB_NAME);
    }
}
