<?php
namespace App;

use \PHPMailer\PHPMailer\Exception as MailerException;
use \PDOException;

class SubscribeNewsletterController
{
    private Db $db;
    
    public function __construct()
    {
        $this->db = new Db();
    }
    
    public function subscribe(string $email)
    {
        
        try {
            $email = trim($email);
            $this->validate($email);
            
            $mailer = new Mailer();
            $mailer->send($email, 'Uz se to blizi', 'Již brzo a navždy');
            
            $model = new SubscribeNewsletterModel($this->db);
            $model->addSubscribedUser($email);
            
            echo json_encode((object)[
                'status' => 'ok', 
                'message' => 'User subscribed'
            ]);
            
        } catch(ValidateException $e) {
            http_response_code(400);
            echo json_encode((object)[
                'status' => 'error', 
                'message' => $e->getMessage()
            ]);
        } catch(MailerException $e) {
            http_response_code(500);
            echo json_encode((object)[
                'status' => 'error', 
                'message' => 'Email sending failed'
            ]);
        } catch(PDOException $e) {
            http_response_code(500);
            echo json_encode((object)[
                'status' => 'error', 
                'message' => 'Database Error'
            ]);
        }
    }
    
    protected function validate(string $email)
    {
        $model = new SubscribeNewsletterModel($this->db);
        $email = trim($email);
        
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new ValidateException('invalid email');
        }
        if ($model->isUserAllreadySubscribed($email)) {
            throw new ValidateException('email allready subscribed');
        }
    }
    
}
