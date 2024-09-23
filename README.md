# Punch-in

Este projeto é uma API para um sistema de registro de ponto, desenvolvida com Symfony, Docker, LexikJWTAuthenticationBundle, PostgreSQL e Nginx.

## Funcionalidades

- **Registro de ponto:** Permite que os usuários batam o ponto.
- **Cadastro de usuários:** Adicione novos usuários ao sistema.
- **Cadastro de cargos:** Crie e gerencie diferentes cargos.
- **Relacionamento entre cargos e usuários:** Atribua cargos aos usuários cadastrados.

## Tecnologias Utilizadas

- **Symfony**: Framework PHP para construção da API.
- **Docker**: Contêinerização do ambiente de desenvolvimento e produção.
- **PostgreSQL**: Banco de dados relacional.
- **Nginx**: Servidor web.
- **LexikJWTAuthenticationBundle**: Autenticação de usuários usando JWT.

## Requisitos

- **Docker** e **Docker Compose** instalados na sua máquina.

## Como rodar o projeto

1. Clone o repositório:
    ```bash
    git clone git@github.com:LeonardoKleimpaul/punch-in.git
    ```
   
2. Acesse o diretório do projeto:
    ```bash
    cd punch-in
    ```

3. Execute o seguinte comando para construir e iniciar os contêineres:
    ```bash
    docker compose -f docker-compose.yml up --build -d
    ```

   Nas próximas execuções, basta rodar:
    ```bash
    docker compose up -d
    ```

4. Gere o par de chaves para o JWT:
    ```bash
    docker compose exec php php bin/console lexik:jwt:generate-keypair --overwrite
    ```

5. Agora, a API estará rodando no endereço: `http://localhost:8080`.

## Configuração do JWT

O LexikJWTAuthenticationBundle utiliza um par de chaves (pública e privada) para assinar e verificar os tokens JWT.

Para gerar o par de chaves, use o comando acima (`lexik:jwt:generate-keypair`). Isso criará as chaves dentro do diretório `config/jwt`.

Certifique-se de que os arquivos de chave estão em um local seguro e fora do alcance do versionamento (por exemplo, adicione ao `.gitignore`).

## Rotas Principais

- **POST api/login**: Realiza a autenticação do usuário e retorna um token JWT.

## Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
