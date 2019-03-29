<?

class ApiResponse{
    public function __constructor($customer, $message, $code = null){
        $this->customer =  $customer;
        $this->message = $message;
        $this->code = $code;
    }
}

?>