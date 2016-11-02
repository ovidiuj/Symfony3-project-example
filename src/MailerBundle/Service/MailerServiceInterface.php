<?php
namespace MailerBundle\Service;


use Symfony\Component\Templating\TemplateReferenceInterface;

/**
 * Interface MailerServiceInterface
 * @package MailerBundle\Service
 */
interface MailerServiceInterface
{
    /**
     * @param $addresses
     * @param null $subject
     * @param $template
     * @param array $templateParameters
     * @param array|null $sender
     * @param string $contentType
     * @param null $charset
     * @return mixed
     */
    public function send($addresses, $subject = null, $template, array $templateParameters = [], array $sender = null, $contentType = 'text/html',  $charset = null);
    
    /**
     * Get sender
     * @return array
     */
    public function getSender();
}