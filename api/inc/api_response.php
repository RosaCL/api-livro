<?php

class api_response
{
    private $data;
    private $available_methods=['GET', 'POST'];



    public function __construct()
    {
        $this->data=[];
    }



    public function check_method($method)
{
    return in_array($method, $this->available_methods);
}

public function set_method($method)
{
    $this->data['method']=$method;
}

public function set_endpoint($endpoint)
{
    $this->data['endpoint']=$endpoint;
}

public function get_endpoint()
{
    return $this->data['endpoint'];
}

public function add_do_data($key, $value)
{
    $this->data[$key=$value];
}

public function api_request_error($message='')
{
    $data_error=[
        'status'=> 'ERROR',
        'message'=>$message,
        'results'=>null
    ];
    $this->data['dats']=$data_error;
    $this->send_response();
}

public function send_response()
{
    header("Content-Type:application/json");
    echo json_encode($this->data);
    die(1);
}








}
?>