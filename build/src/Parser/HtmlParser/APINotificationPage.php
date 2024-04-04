<?php

declare(strict_types=1);

namespace MLocati\Nexi\Build\Parser\HtmlParser;

use DOMDocument;
use DOMElement;
use MLocati\Nexi\Build\API;
use MLocati\Nexi\Build\API\FieldsData;
use MLocati\Nexi\Build\API\Method;
use MLocati\Nexi\Build\API\Webhook;

class APINotificationPage extends APIPage
{
    public const PATH = '/en/api/notifica';

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Build\Parser\HtmlParser\APIPage::shouldHandlePath()
     */
    public function shouldHandlePath(string $path): bool
    {
        return $path === self::PATH;
    }

    /**
     * {@inheritdoc}
     *
     * @see \MLocati\Nexi\Build\Parser\HtmlParser::parseDoc()
     */
    public function parseDoc(string $see, string $path, DOMDocument $page, API $api): void
    {
        $main = $this->getElement($page, "descendant::div[@id='maincontent-wrapper']");
        $api->setWebookRequest($this->extractRequest($main, $api, $see));
        $api->setWebookResponse($this->extractResponse($main, $api, $see));
    }

    private function extractRequest(DOMElement $main, API $api, string $see): Webhook\Request
    {
        $container = $this->getElement($main, "descendant::div[@id='tab_body']");
        $data = new FieldsData(
            api: $api,
            see: "{$see}#tab_body",
            methodName: 'webhook',
            request: true,
        );
        $result = new Webhook\Request("{$see}#tab_body");
        foreach ($this->extractFields($data, $container, ['parameters', 'body'], false) as $field) {
            $result->addField($field);
        }

        return $result;
    }

    private function extractResponse(DOMElement $main, API $api, string $see): Webhook\Response
    {
        $methodDefinition = Method\Definition::getForWebhookResponse();
        $result = new Webhook\Response("{$see}#tab_response");
        foreach ($this->extractHttpResponseCodes($main, $api, $methodDefinition, $see) as [$httpCode, $description, $fields]) {
            $result->addCode($httpCode, $description);
            foreach ($fields as $field) {
                $result->addField($httpCode, $field);
            }
        }

        return $result;
    }
}
