const API_HOME_URL = 'http://localhost:8080/api/home';

async function getContentHome() {
    const token = sessionStorage.getItem('token');

    if (!token) {
        alert('Você não está logado.');
        window.location.href = '/login';
        return;
    }

    try {
        const response = await fetch(API_HOME_URL, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        });

        // Verifique o status da resposta
        if (response.ok) {
            const data = await response.json();
            document.getElementById('user_email').innerHTML = data.userEmail;
        } else {
            console.log('Erro ao buscar conteúdo da home', response.status);
        }
    } catch (error) {
        console.error('Erro de rede:', error);
    }
}


export default getContentHome;
