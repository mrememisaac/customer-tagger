<?

namespace App;

class ApiResponse{
    
    public function __constructor($message, $successful, $code = null){
        $this->message = $message;
        $this->success = $success;
        $this->code = $code;
    }
}

?>