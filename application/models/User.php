<?php
require_once(MODELS_DIR . 'BaseModel.php');

class User extends BaseModel
{
    private static $TABELA = "user";

    function get_table_name()
    {
        return self::$TABELA;
    }
    
}
