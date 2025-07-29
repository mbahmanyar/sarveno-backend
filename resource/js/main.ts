import FormHandler from "./FormHandler";
import {email, required} from "./Validators";
import {alertModal} from "./modal";
import ShoppingItemHandler from "./ShoppingItemHandler";


const registerForm = document.querySelector("#register-form") as HTMLFormElement;


if (registerForm) {
    new FormHandler(registerForm, {
        fieldValidators: {
            email: [required, email],
            password: [required]
        },
        handleResponse: async (response) => {
            const {token} = response.data;
            // console.log(response.data)
            await alertModal({
                title: response.message
            });
            if (token) {
                localStorage.setItem('token', token);
                window.location.href = '/shopping-items';
            }
        }
    });
}

const loginForm = document.querySelector("#login-form") as HTMLFormElement;

if (loginForm) {
    new FormHandler(
        loginForm,
        {
            fieldValidators: {
                email: [required, email],
                password: [required]
            },
            handleResponse: async (response) => {
                const {token} = response.data;
                // console.log(response.data)
                await alertModal({
                    title: response.message
                });
                if (token) {
                    localStorage.setItem('token', token);
                    window.location.href = '/shopping-items';
                }
            }

        },
    )
}


const shoppingItemWrapper = document.querySelector('#shopping-item-wrapper') as HTMLDivElement;
if (shoppingItemWrapper) {
    const shoppingItemHandler = new ShoppingItemHandler(shoppingItemWrapper);

    shoppingItemHandler.init();
}

async function redirect(to: string) {
    new Promise(() => {
        window.location.href = to;
    })
}

async function logout() {
    localStorage.removeItem('token');
    await redirect('/login');
}

const logoutBtn = document.querySelector("#logout") as HTMLElement;
if (logoutBtn) {
    logoutBtn.addEventListener('click', function (e:Event) {
        e.preventDefault();
        logout();
    })
}









