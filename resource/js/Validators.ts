export type ValidatorFn = (input: HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement, form?: HTMLFormElement) => string | null;


export const required:ValidatorFn = (input) =>
    !input.value.trim() ? 'This field is required.' : null;

export const email:ValidatorFn = (input) =>
    !/^\S+@\S+\.\S+$/.test(input.value) ? 'Invalid email address.' : null;
