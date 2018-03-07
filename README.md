# Support Ticket System - Sistema de Chamados

## EN:
This project was created in 2005 and adapted over the years with the target that to be an extremely simple support ticket system for the IT department. It is simple to be used by the end user and your adoption is natural and easy.

### Requirements
The requirements are:
* Apache or Nginx web server
* PHP 5 or higher, with the following extensions:
	* php_mysql
	* php_pdo_mysql
	* php_ldap
* Database MySQL
* Active Directory
* SMTP Server (already defined in PHP.ini)
* Flash Player installed in the end user's computers

### Setup
To use it in your environment, follow the steps below:

1. Change the following settings in the 'classes\util\Config.php' file:
* getUrlBase: http://localhost/tickets (must be a fully qualified domain name. Eg: http://tickets.domain.com/)
* getRemetenteEmail: Support Tickets <support-tickets@your-domain.com>
* getDominioEmail: your-domain.com
* getServidorAD: your-active-directory.domain
* getDominioAD: YOUR-AD-DOMAIN

2. Change the following connections parameters in the 'construct' method of the file 'classes\conexao\ConexaoBDR.php'
* $strHost = "localhost";
* $strUser = "root";
* $strPass = "";
* $strBase = "chamados";

3. Create a database in MySQL by importing the table definitions from the file 'database\chamados.sql'

4. Import data from your company's sectors/divisions into the 'setor' table. The 'status_setor' attribute must be = 1 (active). If the sector no longer exists in the future, you should change to the value = 0 (disabled).

5. Change the logo image using 'imagens/logo.png' file. Use the '.png' file format with transparency.

6. Do the first login in the application using the Active Directory user and password.

7. For system administrators, change the field 'flag_super_admin' in the 'usuario' table to the value = 1.

8. It is also recommended to change the variable $strHash of the file 'classes\util\Encrypt.php' to some different values of encryption, in order to guarantee the security using the tool.

### First Use
For the first use, log in using a super admin user ('flag_super_admin' = 1) and then create the groups. We usually create a group called 'TI'. This group must receive support tickets and must have an e-mail to receive the history of this tickets. This email usually refers to a list of people.

After creating the group, click on the people icon and add the logins of the users that are part of this group. Only users who have already registered in the system will be displayed on this screen.

After adding the users, choose among them which users will be administrators of this group.

For admin users, other options such as adding subjects to the group will be displayed in the top menu. These subjects are usually referenced to IT services such as Email, Internet, Computer, etc. At this point you can specify a SLA, a message to be displayed when selecting this subject and a 'format' suggestive of the ticket.

After this configuration, the system will now be able to work properly.

All files in this project are in Portuguese-BR.

## PT-BR:
Este projeto foi criado em 2005 e adaptado ao longo dos anos com o objetivo de ser um sistema extremamente simples de registro de chamados para o setor de TI. Como o mesmo é simples de ser utilizado pelo usuário a adesão ao sistema é natural e fácil.

### Requisitos
Os requisitos necessários são:
* Servidor web Apache ou Nginx
* PHP 5 ou superior, com as extensões:
	* php_mysql
	* php_pdo_mysql
	* php_ldap
* Banco de dados MySQL
* Active Directory
* Servidor SMTP (já configurado no PHP.ini)
* Flash Player instalado nas máquinas dos usuários

### Instalação
Para utilizá-lo em seu ambiente, siga os passos abaixo:

1. Alterar as seguintes configurações no arquivo 'classes\util\Config.php':
* getUrlBase: http://localhost/chamados (deve ser um nome de domínio completamente qualificado. Ex: http://chamados.dominio.com.br/)
* getRemetenteEmail: Chamados <chamados@seu-dominio.com.br>
* getDominioEmail: seu-dominio.com.br
* getServidorAD: seu-servidor-de-active-directory.domain
* getDominioAD: SEU-DOMINIO-AD

2. Alterar os parametros de conexão no método 'construtor' do arquivo 'classes\conexao\ConexaoBDR.php'
* $strHost = "localhost";
* $strUser = "root";
* $strPass = "";
* $strBase = "chamados";

3. Criar uma base de dados no MySQL importando as definições das tabelas do arquivo 'database\chamados.sql'

4. Importar os dados dos setores/divisões da sua empresa na tabela 'setor'. O atributo 'status_setor' deve ser = 1 (ativo). Caso o setor não exista mais no futuro, você deve mudar para o valor = 2 (desativado).

5. Alterar a logomarca do arquivo 'imagens/logo.png'. Considerar o uso de um arquivo em formato '.png' com transparência.

6. Efetuar o primeiro login na aplicação utilizando o usuário e senha do Active Directory.

7. Para os usuários administradores do sistema, alterar o campo 'flag_super_admin' in 'usuario' table para o valor = 1.

8. Recomenda-se também alterar a variável $strHash do arquivo 'classes\util\Encripta.php' para alguns valores diferentes de criptografia, a fim de garantir a segurança no uso da ferramenta.

### Primeiro Uso
Para o primeiro uso, efetuar o login utilizando um usuário super admin ('flag_super_admin' = 1) e criar os grupos. Geralmente criamos o grupo chamado 'TI'. Este grupo deve receber chamados e possuir um e-mail para recebimento das movimentações. Este email geralmente refere-se a uma lista de pessoas.

Após a criação do grupo, clicar no icone de pessoas e adicionar os logins dos usuários que fazem parte deste grupo. Apenas usuários que já fizeram o cadastro inicial no sistema serão exibidos nesta tela.

Após adicionar os usuários, escolher dentre eles quais serão usuários administradores do grupo em questão.

Para os usuários administradores, será apresentado no menu superior outras opções, tais como adicionar assuntos ao grupo. Estes assuntos geralmente são referenciados aos serviços de TI, tais como Email, Internet, Computador, etc. Nesse momento você pode especificar um prazo para atendimento, uma mensagem a ser exibida ao selecionar este assunto e um 'formato' sugestivo do chamado.

Após esta configuração, o sistema já estará apto a funcionar corretamente.
