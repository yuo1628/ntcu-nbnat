<?php
/**
 * Author
 *
 * 呈現公告作者的類別
 *
 */
class Author {
    private $id;
    private $name;
    private $rank;
    
    public function __get($name)
    {
        return $this->$name;
    }
    
    public function __set($name, $value)
    {
        $this->$name = $value;
    }
}
// End of file