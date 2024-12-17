function logout() {
    sessionStorage.removeItem('token');
    window.location.reload();
}
