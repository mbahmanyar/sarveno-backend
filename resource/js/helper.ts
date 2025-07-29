export const isLoggedIn = ():boolean => {
    return localStorage.getItem('token') !== null;
}

export async function redirect(to: string) {
    new Promise(() => {
        window.location.href = to;
    })
}

export async function logout() {
    localStorage.removeItem('token');
    await redirect('/login');
}
