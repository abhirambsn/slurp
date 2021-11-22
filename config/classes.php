<?php 
class UserCookie {
    public $loggedIn = false;
    public $data = [];
    public $message = null;

    function set_login_status($status=false) {
        $this->loggedIn = $status;
    }

    function set_data($data = []) {
        $this->data = $data;
    }

    function set_message($message = null) {
        $this->message = $message;
    }
}

abstract class Response {
    public $type;
    public $code;
    public $data;
}

class ErrorResponse extends Response {
    public function __construct($code, $data, $redirectUri=null) {
        $this->type = 'error';
        $this->code = $code;
        $this->data = $data;
        $this->redirectUri = $redirectUri;
    }
}

class SuccessResponse extends Response {
    public function __construct($code, $data, $redirectUri = null, $type='success') {
        $this->type = $type;
        $this->code = $code;
        $this->data = $data;
        $this->redirectUri = $redirectUri;
    }
}
?>