<?php
namespace App;

class SubscribeNewsletterModel
{
    public function __construct(private Db $db)
    {
        
    }
    
    public function isUserAllreadySubscribed(string $email): bool
    {
        return $this->db->queryField(
            "SELECT COUNT(*) FROM subsribed_email WHERE email = :email", 
            ['email' => $email]
        ) > 0;
    }
    
    public function addSubscribedUser(string $email)
    {
        $this->db->sendSQL(
            "INSERT INTO subsribed_email(email) VALUES(:email)", 
            ['email' => $email]
        );
    }
    
}
