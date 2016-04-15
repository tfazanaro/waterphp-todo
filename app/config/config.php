<?php

/*
 * --------------------------------------------------------------------------
 * TRATAMENTO DE ERROS
 * --------------------------------------------------------------------------
 *
 * Você pode ativar ou desativar o modo de depuração.
 *
 * É altamente recomendado desativar em ambiente de produção, porém quando
 * estiver desenvolvendo matenha ativado este modo para visualizar qualquer
 * alerta de erro.
 *
 * Atenção: Erros fatais ou erros de sintaxe que impedem a execução do
 * programa serão exibidos mesmo que este modo esteja desativado.
 *
 * 0 ou false = Desativado
 * 1 ou true = Ativado
 */

define('DEBUG_MODE', 0);

/*
 * Você pode criar seu próprio modelo de página para depurar os erros,
 * tais como "Warning" e "Notice", caso a opção acima esteja ativada.
 * Veja o template usado na aplicação de exemplo para saber quais
 * informações você pode exibir na visão.
 *
 * Atenção: Mesmo que você substitua a visão abaixo por outra, não
 * apague os arquivos da pasta template.
 */

define('DEBUG_VIEW', 'template/debug');

/*
 * Você pode definir seu próprio modelo de página de erro 404, da mesma
 * forma que foi citado acima.
 * Esta página será exibida sempre que o controlador ou método informado
 * na URL não existir.
 */

define('ERROR_404_VIEW', 'template/404');

/*
 * --------------------------------------------------------------------------
 * SESSÃO
 * --------------------------------------------------------------------------
 *
 * Você pode definir o tempo máximo em segundos que a aplicação deve
 * aguardar pela atividade do usuário antes da sessão expirar.
 */

define('SESSION_LIFETIME', 7200); // 7200 = 2h

/*
 * ---------------------------------------------------------------------------
 * CONTROLADOR PADRÃO
 * --------------------------------------------------------------------------
 *
 * Você deve definir um controlador padrão para ser executado caso nenhum
 * controlador tenha sido informado na url do projeto.
 */

define('CONTROLLER_INDEX', 'Home');

/*
 * --------------------------------------------------------------------------
 * IDIOMA
 * --------------------------------------------------------------------------
 *
 * Você deve definir o idioma padrão da aplicação. Esta ação é útil para
 * ajudar o buscador a classificar seu site no idioma apropriado, orientar
 * os navegadores a exibir acentuação e caracteres especiais corretamente.
 *
 * Atenção: O idioma também é usado para fazer a tradução da aplicação.
 * Consulte a classe Lang na documentação para saber mais.
 *
 * Veja alguns valores possíveis:
 *
 * pt Português
 * pt-br Português do Brasil
 * en Inglês
 * en-us Inglês dos EUA
 * en-gb Inglês Britânico
 * fr Francês
 * de Alemão
 * es Espanhol
 * it Italiano
 * ru Russo
 * zh Chinês
 * ja Japonês
 *
 */

define('DEFAULT_LANGUAGE', 'pt-br');

/*
 * --------------------------------------------------------------------------
 * CRIPTOGRAFIA
 * --------------------------------------------------------------------------
 *
 * Para usar a classe Session ou Auth você deve definir uma chave para
 * criptografar os dados, uma sequência de caracteres que será usada
 * para identificar sua aplicação.
 *
 * Atenção: Se você já estiver usando a aplicação de exemplo com o framework
 * e alterar esta chave, você deverá redefinir a senha de todos os usuários
 * cadastrados. Para isso será necessário registrar um novo usuário e
 * efetuar o login novamente.
 */

define('ENCRYPTION_KEY', 'd1c9c8e42bb681e024dd07ae91aeeb4a');

/*
 * --------------------------------------------------------------------------
 * BANCO DE DADOS
 * --------------------------------------------------------------------------
 *
 * Você deve definir as informações abaixo para fazer a conexão com o banco
 * de dados da sua aplicação.
 *
 * Atenção: Defina as informações corretamente, caso contrário, uma exceção
 * será lançada sempre que tentar executar uma operação de banco de dados
 * ou se estiver usando a aplicação de exemplo com o framework.
 *
 * Consulte na documentação do PHP (php.net) os drivers de banco de dados
 * disponíveis para PDO (PHP Data Objects), e então configure o tipo de
 * conexão. Segue alguns exemplos:
 *
 * Mysql:
 * define('DB_DBDRIVER' , 'mysql');
 * define('DB_CONNPORT' , '3306');
 *
 * Postgresql:
 * define('DB_DBDRIVER' , 'pgsql');
 * define('DB_CONNPORT' , '5432');
 */

define('DB_DBDRIVER' , 'mysql');
define('DB_HOSTNAME' , 'localhost');
define('DB_CONNPORT' , '3306');
define('DB_DATABASE' , 'waterphp_todo');
define('DB_USERNAME' , 'root');
define('DB_PASSWORD' , 'root');

/*
 * --------------------------------------------------------------------------
 * E-MAIL
 * --------------------------------------------------------------------------
 *
 * Defina as informações abaixo para enviar mensagens através da sua
 * aplicação usando a classe Mail.
 *
 * Atenção: Se estiver em seu ambiente de desenvolvimento, certifique-se
 * que o servidor local e o php estão corretamente configurados para enviar
 * e-mails.
 *
 * Dica: Consulte como instalar e configurar o postfix ou sendmail em seu SO.
 */

define('MAIL_IS_HTML'   , true);
define('MAIL_CHARSET'   , 'utf-8');
define('MAIL_FROM'      , ''); // Seu E-mail: user@yourdomain.com
define('MAIL_FROM_NAME' , ''); // Seu Nome