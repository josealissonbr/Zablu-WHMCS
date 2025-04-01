# Zablu-WHMCS

Módulo de integração entre WHMCS e a API do Zablu - Sistema de Gestão Financeira.

## Descrição

Este módulo permite a integração automática entre o WHMCS (Web Host Manager Complete Solution) e o sistema de gestão financeira Zablu. Quando uma fatura é paga no WHMCS, o módulo automaticamente cria uma transação correspondente no Zablu.

## Requisitos

- WHMCS versão 8.0 ou superior
- Conta ativa no Zablu
- Credenciais de API do Zablu (URL da API e Chave da API)

## Como Obter o Token de API

1. Acesse sua conta no Zablu
2. Clique no ícone do usuário (imagem de perfil) no canto superior direito
3. Selecione "Configurações"
4. Navegue até a aba "Tokens de API"
5. Clique em "Criar Token"
6. Copie o token gerado e cole-o no campo "Chave da API" nas configurações do módulo

## Instalação

1. Faça o download do módulo
2. Arraste a pasta `modules` para a raiz do seu WHMCS
3. Acesse o painel administrativo do WHMCS
4. Vá para Configurações > Módulos de Addon
5. Localize o módulo "Zablu" e clique em "Ativar"

## Configuração

1. No painel administrativo do WHMCS, vá para Configurações > Módulos de Addon > Zablu
2. Configure as seguintes opções:
   - URL da API: URL base da API do Zablu (ex: https://app.zablu.com.br/api/v1)
   - Chave da API: Cole o token de API obtido seguindo os passos acima

## Funcionalidades

- Criação automática de transações no Zablu quando faturas são pagas
- Conversão automática de valores para centavos
- Registro de logs detalhados de integração
- Tratamento de erros e respostas da API
- Suporte a múltiplas moedas

## Estrutura do Módulo

```
modules/
└── addons/
    └── zablu/
        ├── hooks.php         # Hooks do WHMCS para integração
        ├── zablu.php         # Arquivo principal do módulo
        ├── manifest.json     # Manifesto do módulo
        ├── templates/        # Templates de interface
        │   └── config.tpl    # Template de configuração
        └── lang/            # Arquivos de idioma
            └── english.php   # Traduções em inglês
```

## Como Funciona

1. Quando uma fatura é paga no WHMCS, o hook `InvoicePaid` é acionado
2. O módulo recupera os dados da fatura, cliente e itens
3. Converte o valor total para centavos
4. Cria uma transação no Zablu com os seguintes dados:
   - Valor (em centavos)
   - Tipo de pagamento (à vista)
   - Tipo de transação (recebimentos)
   - Data atual
   - Descrição (número da fatura e nome do cliente)
   - Status (pago)

## Logs e Monitoramento

O módulo registra logs detalhados no WHMCS para:
- Sucesso na criação de transações
- Erros na comunicação com a API
- Problemas de configuração

## Suporte

Para suporte técnico, entre em contato através do email: suporte@zablu.com.br

## Licença

Este módulo é proprietário e seu uso está sujeito aos termos de licença da Zablu.

## Desenvolvido por

Zablu - Sistema de Gestão Financeira
