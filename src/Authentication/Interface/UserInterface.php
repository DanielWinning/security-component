<?php

namespace Luma\SecurityComponent\Authentication\Interface;

interface UserInterface
{
    public function getId(): int;
    public function getUsername(): string;
    public function getPassword(): string;
}