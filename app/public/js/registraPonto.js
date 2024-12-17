const API_REGISTRA_PONTO_URL = 'http://localhost:8080/api/registrarponto';

async function registraPonto() {
    const token = sessionStorage.getItem('token');

    if (!token) {
        alert('Você não está logado.');
        window.location.href = '/login';
        return;
    }

    if(confirm('Deseja realmente registrar o ponto?') == false){
        return;
    }

    const options = {
        method: 'POST',
        headers: {
            'Authorization': `Bearer ${token}`,
            'Content-Type': 'application/json'
        },
    };

    const response = await fetch(`${API_REGISTRA_PONTO_URL}`, options);

    if (response.ok) {
        alert('Ponto registrado com sucesso!');
    }

    return await response.json();
}

