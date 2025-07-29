import FormHandler from "./FormHandler";
import {email, required} from "./Validators";
import {alertModal} from "./modal";
import ShoppingItemHandler from "./ShoppingItemHandler";
import {isLoggedIn, logout, redirect} from "./helper";


// check if user in register page
const registerForm = document.querySelector("#register-form") as HTMLFormElement;
if (registerForm) {
    if (isLoggedIn()) {
        window.location.href="/shopping-items";
    }

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


// check if user in login page
const loginForm = document.querySelector("#login-form") as HTMLFormElement;

if (loginForm) {

    if (isLoggedIn()) {
        window.location.href="/shopping-items";
    }

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

// check if user in shopping items page
const shoppingItemWrapper = document.querySelector('#shopping-item-wrapper') as HTMLDivElement;
if (shoppingItemWrapper) {
    const shoppingItemHandler = new ShoppingItemHandler(shoppingItemWrapper);

    shoppingItemHandler.init();
}


const logoutBtn = document.querySelector("#logout") as HTMLElement;
if (logoutBtn) {
    logoutBtn.addEventListener('click', function (e: Event) {
        e.preventDefault();
        logout();
    })
}







