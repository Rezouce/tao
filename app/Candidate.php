<?php

namespace App;

use Illuminate\Contracts\Support\Arrayable;

class Candidate implements Arrayable
{
    private $login;

    private $password;

    private $title;

    private $lastname;

    private $firstname;

    private $gender;

    private $email;

    private $picture;

    private $address;

    public function __construct(array $data)
    {
        $this->login = $data['login'];
        $this->password = $data['password'];
        $this->title = $data['title'];
        $this->lastname = $data['lastname'];
        $this->firstname = $data['firstname'];
        $this->gender = $data['gender'];
        $this->email = $data['email'];
        $this->picture = $data['picture'];
        $this->address = $data['address'];
    }

    public function toArray()
    {
        return [
            'id' => $this->getId(),
            'login' => $this->login,
            'password' => $this->password,
            'title' => $this->title,
            'lastname' => $this->lastname,
            'firstname' => $this->firstname,
            'gender' => $this->gender,
            'email' => $this->email,
            'picture' => $this->picture,
            'address' => $this->address,
        ];
    }

    public function hasNameContaining(string $searchedString): bool
    {
        return false !== stripos($this->firstname, $searchedString)
            || false !== stripos($this->lastname, $searchedString);
    }

    public function getId(): string
    {
        return $this->login;
    }
}
