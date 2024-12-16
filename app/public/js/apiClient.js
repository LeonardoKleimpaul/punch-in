const API_BASE_URL = 'http://localhost:8080/api';

async function apiRequestPost(endpoint, method = 'GET', body = null) {
    const headers = { 'Content-Type': 'application/json' };

    const options = {
        method,
        headers,
    };

    if (body) {
        options.body = JSON.stringify(body);
    }

    const response = await fetch(`${API_BASE_URL}${endpoint}`, options);

    return await response.json();
}

export default apiRequestPost;
