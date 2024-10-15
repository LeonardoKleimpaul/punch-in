# Punch-in

Autores: Leonardo Kleimpaul, Luan F Tedesco

**Introdução:**
A transformação digital tem impulsionado a criação de soluções práticas e automatizadas. Diante disso, decidimos criar um sistema para facilitar o dia a dia dos trabalhadores que precisam registrar seu horário de trabalho diariamente. O projeto "Punch-in" é uma API desenvolvida com tecnologias modernas, como Symfony, Docker, PostgreSQL e Nginx, voltada para empresas que buscam otimizar o controle da jornada de seus colaboradores.

**Metodologia:**
O desenvolvimento do "Punch-in" seguiu uma abordagem prática, utilizando diversas tecnologias e ferramentas que permitiram a construção de uma API robusta e eficiente. Para o gerenciamento de usuários e controle de autenticação, foi utilizado o LexikJWTAuthenticationBundle, que garante segurança por meio de tokens JWT. Além disso, foi empregada uma metodologia de contêinerização com Docker, permitindo que os ambientes de desenvolvimento e produção fossem facilmente replicáveis. O PostgreSQL foi escolhido como banco de dados relacional, proporcionando uma base de dados estável e de alto desempenho. Por fim, o Nginx foi configurado como servidor web, garantindo alta disponibilidade e performance na entrega da API.

**Resultados:**
O projeto "Punch-in" se destaca pela integração eficiente entre suas funcionalidades e o uso de tecnologias modernas. As soluções adotadas permitem um gerenciamento eficaz tanto dos usuários quanto das jornadas de trabalho, oferecendo uma interface simples e direta para o controle de ponto. A utilização de JWT para autenticação trouxe segurança e escalabilidade à aplicação, enquanto o uso de contêineres com Docker facilitou a configuração e manutenção do ambiente de produção.

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
    docker exec php8.2-container php bin/console lexik:jwt:generate-keypair --overwrite
    ```

5. Agora, a API estará rodando no endereço: `http://localhost:8080`.

## Configuração do JWT

O LexikJWTAuthenticationBundle utiliza um par de chaves (pública e privada) para assinar e verificar os tokens JWT.

Para gerar o par de chaves, use o comando acima (`lexik:jwt:generate-keypair`). Isso criará as chaves dentro do diretório `config/jwt`.

Certifique-se de que os arquivos de chave estão em um local seguro e fora do alcance do versionamento (por exemplo, adicione ao `.gitignore`).

## Rotas Principais

- **Login**
  - Método: POST
  - URL: http://localhost:8080/api/login
  - Corpo:
    ```json
    {
      "username": "",
      "password": ""
    }
    ```
- **Registro**
  - Método: POST
  - URL: http://localhost:8080/api/registrar
  - Corpo:
    ```json
    {
      "email": "",
      "password": {
        "first": "",
        "second": ""
      }
    }
    ```

### Administração

- **Criar Cargo**

  - Método: POST
  - URL: http://localhost:8080/api/admin/cargo/criar
  - Corpo:
    ```json
    {
      "funcao": "Gerente",
      "cargaHoraria": "05:48"
    }
    ```

- **Registrar Ponto**

  - Método: POST
  - URL: http://localhost:8080/api/registrarponto

- **Associar Usuário a Cargo**

  - Método: POST
  - URL: http://localhost:8080/api/admin/userscargo/criar
  - Corpo:
    ```json
    {
      "userId": "",
      "cargoId": ""
    }
    ```

- **Criar Empresa**

  - Método: POST
  - URL: http://localhost:8080/api/admin/empresa/criar
  - Corpo:
    ```json
    {
      "nome": "",
      "cnpj": ""
    }
    ```

## Contribuindo

Contribuições são bem-vindas! Sinta-se à vontade para abrir issues e pull requests.

## Licença

Este projeto está licenciado sob a [MIT License](LICENSE).
