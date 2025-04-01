<?php
if (!defined("WHMCS")) {
    die("This file cannot be accessed directly");
}

function zablu_config()
{
    return [
        'name' => 'Zablu',
        'description' => 'Integração com a API do Zablu para criar transações quando faturas são pagas.',
        'version' => '1.0',
        'author' => 'josealissonbr',
        'fields' => [
            'api_url' => [
                'FriendlyName' => 'URL da API',
                'Type' => 'text',
                'Size' => '100',
                'Default' => 'https://app.zablu.com.br/api/v1',
                'Description' => 'URL base da API do Zablu.',
            ],
            'api_key' => [
                'FriendlyName' => 'Chave da API',
                'Type' => 'password',
                'Size' => '100',
                'Default' => '',
                'Description' => 'Chave de acesso da API do Zablu.',
            ],
        ],
    ];
}

function zablu_activate()
{
    return ['status' => 'success', 'description' => 'Zablu foi ativado com sucesso.'];
}

function zablu_deactivate()
{
    return ['status' => 'success', 'description' => 'Zablu foi desativado com sucesso.'];
}
