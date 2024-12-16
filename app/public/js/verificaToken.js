function verificaToken() {
    const token = sessionStorage.getItem('token');
    const rotaAtual = window.location.pathname;

    console.log(token);

    if (!token && (rotaAtual == '/login' || rotaAtual == '/register')) {
        return;
    }

    if (!token) {
        window.location.href = '/login';
    }

    if (token && (rotaAtual == '/login' || rotaAtual == '/register')) {
        window.location.href = '/home';
    }
}


export default verificaToken;
