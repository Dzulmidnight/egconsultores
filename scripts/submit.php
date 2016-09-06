<?php
 
	$controller = new ContactController();
	$controller->handleRequest();
	exit();


    class ContactController {
    
        public function hasData() {
            return isset($_POST['submit_contact']) == TRUE;
        }
    
        public function handleRequest() {
            try {
                if ($this->hasData()) {
                    $model = new ContactModel();
                    $model->parse($_POST);
                    if ($this->sendEmail($model) === TRUE) {
                        $this->respondSuccess();
                    } else {
                        $this->respondFailure("Message not sent.", 500);
                    }
                } else {
                    $this->respondFailure("Invalid Request", 400);
                }
            }
            catch (Exception $ex) {
                $this->respondFailure($ex->getMessage(), 500);
            }

        }
    
        protected function sendEmail($model) {
        	$email_to='werhumx@gmail.com';
			$email_subject='Nuevo contacto';
            $email_Body = "EG Consultores\r\n" 
                              . "Nombre: " . $model->Name . "\r\n"
                              . "Apellido: " . $model->Lname . "\r\n"
                              . "Email: " . $model->Email . "\r\n"
                              . "Dirección: " . $model->Adress . "\r\n";
    		
    		mail($email_to,$email_subject, $email_Body);
            return TRUE;
        }
    
        protected function respondSuccess() {
            $result = new ContactResultModel();
            $result->Success = 1;
            $result->Message = "Message has been sent.";
    
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    
        protected function respondFailure($message, $code = 500) {
            $result = new ContactResultModel();
            $result->Success = 0;
            $result->Message = $message;
    
            header("HTTP/1.0 " . $code . " Internal Server Error");
            header('Content-Type: application/json');
            echo json_encode($result);
        }
    }
 
 
 
 
 
 
 class ModelBase {
        public function getVal($arr, $key, $default) {
            if (isset($arr[$key])) {
                return $arr[$key];
            }
    
            return $default;
        }
    }

    class ContactModel extends ModelBase {
        public $Name;
		public $Lname;
		public $Email;
		public $Address;
        public $Company;
        public $Title;
		public $Country;
		public $Telephone;
		public $Message;
    
        public function parse($values) {
            $this->Name      =   self::getVal($values, 'name',         '(No Name)');
			$this->Lname     =   self::getVal($values, 'lname',        '(No Name)');
            $this->Email     =   self::getVal($values, 'email',        '(No Email)');
            $this->Address   =   self::getVal($values, 'address',      '(No Address)');
            $this->Company   =   self::getVal($values, 'company',      '(No Company)');
			$this->Title     =   self::getVal($values, 'title',        '(No Title)');
			$this->Country   =   self::getVal($values, 'telephone',      '(No Country)');
			$this->Message =   self::getVal($values, 'message',      '(No Message)');
			
        }
    

    }
    
    class ContactResultModel {
        public $Success = 1;
        public $Message = "OK";
    }

?>