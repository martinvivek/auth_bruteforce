# auth_bruteforce
Plug-in de proteção contra ataque de Brute Force para o Moodle.

# Como instalar
Para instala-lo, baixe o fonte deste plug-in em [bruteforce.zip](https://github.com/EduardoKrausME/auth_bruteforce/raw/master/bruteforce.zip)) e descompacte-o na pasta moodle/auth e deois vá ao menu Administração do site >> Avisos e siga os passos para instalação do Plug-in.

# O que é Brute-Force
Brute force é o nome dado a ataques aonde se usa todas as senhas possíveis para conseguir um acesso.

No Moodle isso é muito comum, e piora quando a pessoa que instalou o Moodle deixou o usuário "admin" ativado. Neste caso usa-se programas simples que tentam todas as senhas possíveis até que uma delas consegue acesso.

# O que faz este Plug-in?
O Moodle, por padrão, guarda estas informações na sessão, e se a sessão for limpa este taque pode acontecer sem problemas.

Este plug-in analisa cada uma das tentativas de login e caso este indivíduo já ultrapassou o limite máximo de tentativas, bloqueia o acesso e só libera o IP dele após 24 horas.