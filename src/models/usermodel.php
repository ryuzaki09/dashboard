<?php

class Usermodel extends BaseModel {

    public function __construct(){
        parent::__construct();
    }

    public function getUserDetails(){
        $this->where(array("name" => "refresh_token")); 
        $this->from("user_details");
        $this->execute();
        return $this->fetchOne();
    }

    public function updateRefreshToken($token){
        $this->query("UPDATE user_details SET token='".$token."' WHERE name='refresh_token'");
        $this->execute();

    }

    public function getAccessToken(){
        $this->where(array("name" => "access_token")); 
        $this->from("user_details");
        $this->execute();
        return $this->fetchOne();

    }

    public function updateAccessToken($token){
        $this->query("UPDATE user_details SET token='".$token."' WHERE name='access_token'");
        $this->execute();

    }
}
