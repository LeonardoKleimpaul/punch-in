const API_HOME_URL = 'http://localhost:8080/api/buscapontos';

async function buscaHistorico() {
    const token = sessionStorage.getItem('token');

    if (!token) {
        alert('Você não está logado.');
        window.location.href = '/login';
        return;
    }

    const params = new URLSearchParams();
    params.append('buscaHistorico', true);

    const urlWithParams = `${API_HOME_URL}?${params.toString()}`;

    try {
        const response = await fetch(urlWithParams, {
            method: 'GET',
            headers: {
                'Authorization': `Bearer ${token}`,
                'Content-Type': 'application/json'
            }
        });

        if (response.ok) {
            const data = await response.json();

            const container = document.querySelector('#listagem');
            container.innerHTML = 'Últimos pontos registrados:';
            container.removeAttribute('style');

            const btnLimpar = document.createElement('button');
            btnLimpar.id = 'btnLimpar';
            btnLimpar.textContent = 'Limpar';
            btnLimpar.classList.add('btn-limpar');
            container.appendChild(btnLimpar);

            btnLimpar.addEventListener('click', () => {
                container.style.visibility = 'hidden';
            });

            data.pontos.forEach(ponto => {
                const dataFormatada = formatarData(ponto.date.date);

                const balao = document.createElement('div');
                balao.classList.add('balao');
                balao.textContent = dataFormatada;

                container.appendChild(balao);
            });
        } else {
            console.log('Erro ao buscar conteúdo da home', response.status);
        }
    } catch (error) {
        console.error('Erro de rede:', error);
    }
}

function formatarData(dateString) {
    const date = new Date(dateString);

    const dia = String(date.getDate()).padStart(2, '0');
    const mes = String(date.getMonth() + 1).padStart(2, '0');
    const ano = date.getFullYear();
    const hora = String(date.getHours()).padStart(2, '0');
    const minuto = String(date.getMinutes()).padStart(2, '0');

    return `${dia}/${mes}/${ano} - ${hora}:${minuto}`;
}
