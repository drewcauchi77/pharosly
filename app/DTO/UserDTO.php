<?php

namespace App\DTO;

class UserDTO
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        public string $email,
        public string $password,
    ) { }

    /**
     * @return array{
     *     email: string,
     *     password: string
     * }
     */
    public function toArray(): array
    {
        return [
            'email' => trim($this->email),
            'password' => $this->password,
        ];
    }
}
