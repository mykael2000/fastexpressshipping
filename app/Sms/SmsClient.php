<?php

interface SmsClient {
    public function sendSms(string $to, string $message): bool;
}

?>