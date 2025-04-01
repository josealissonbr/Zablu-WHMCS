<?php
use Illuminate\Database\Capsule\Manager as Capsule;

add_hook('InvoicePaid', 1, function ($vars) {
    $invoiceId = $vars['invoiceid'];
    
    $invoice = Capsule::table('tblinvoices')->where('id', $invoiceId)->first();
    $client = Capsule::table('tblclients')->where('id', $invoice->userid)->first();
    $items = Capsule::table('tblinvoiceitems')->where('invoiceid', $invoiceId)->get();
    
    // Configurações da API do Zablu
    $zabluApiUrl = Capsule::table('tbladdonmodules')
        ->where('module', 'zablu')
        ->where('setting', 'api_url')
        ->value('value');
        
    $zabluApiKey = Capsule::table('tbladdonmodules')
        ->where('module', 'zablu')
        ->where('setting', 'api_key')
        ->value('value');
    
    if (!$zabluApiUrl || !$zabluApiKey) {
        logActivity("Zablu API: URL ou chave da API não configuradas.");
        return;
    }
    
    // Prepara os dados da transação
    $transactionData = [
        'value' => (int)($invoice->total * 100), // Converte para centavos e garante que é inteiro
        'payment_type' => 1, // À vista
        'type' => 1, // Recebimentos
        'date' => date('Y-m-d'),
        'description' => "Fatura #{$invoice->id} - {$client->firstname} {$client->lastname}",
        'is_paid' => true,
        'contact_id' => null, // Você pode adicionar um mapeamento de clientes para contatos do Zablu
        'category_id' => null, // Você pode adicionar um mapeamento de categorias
    ];
    
    // Envia a requisição para a API do Zablu
    $ch = curl_init($zabluApiUrl . '/transactions');
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($transactionData));
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'X-API-KEY: ' . $zabluApiKey
    ]);
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    
    if ($httpCode === 200) {
        logActivity("Zablu API: Transação criada com sucesso para a fatura #{$invoiceId} Resposta: {$response}");
    } else {
        logActivity("Zablu API: Erro ao criar transação para a fatura #{$invoiceId}. Código: {$httpCode}, Resposta: {$response}");
    }
});
