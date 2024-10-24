<?php

namespace Config;

use CodeIgniter\Config\BaseConfig;

class Email extends BaseConfig
{
    public $fromEmail = 'your-email@example.com';
    public $fromName = 'Batch System';
    public $recipients = '';

    public $protocol = 'smtp';
    public $SMTPHost = 'smtp.example.com';
    public $SMTPUser = 'your-email@example.com';
    public $SMTPPass = 'your-password';
    public $SMTPPort = 587;
    public $SMTPCrypto = 'tls';

    public $mailType = 'html';
    public $charset = 'utf-8';
    public $wordWrap = true;
}
