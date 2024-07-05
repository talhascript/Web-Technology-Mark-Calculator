<?php
class StatusCRUD {
    public $type;
    public $data;
    public $status;
    public $error_msg;

    function __construct($t, $d, $s, $em) {
        $this->type = $t;
        $this->data = $d;
        $this->status = $s;
        $this->error_msg = $em;
    }

}

?>