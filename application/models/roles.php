<?php
class Roles extends _MyModel
{
    function __construct()
    {
        parent::__construct();
        $this->setTable('user_role', 'role');
    }
}
