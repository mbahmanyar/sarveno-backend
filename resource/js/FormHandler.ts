import http, {HttpMethod, IResponse} from "./http";
import {alertModal} from "./modal";

export type ValidatorFn = (input: HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement, form?: HTMLFormElement) => string | null;
type FormValidatorFn = (form: HTMLFormElement) => string[];
// type SubmitFn = (data: Record<string, any>, form: HTMLFormElement) => Promise<any>;
type handleResponseFn = (response: IResponse<any>) => void;


export interface FieldValidators {
    [fieldName: string]: ValidatorFn[]
}

interface FormHandlerOptions {
    fieldValidators?: FieldValidators;
    formValidator?: FormValidatorFn; // after submit the form
    handleResponse?: handleResponseFn;
}


export default class FormHandler {
    private fieldValidators?: FieldValidators;
    private handleResponse?: handleResponseFn;

    constructor(
        private form: HTMLFormElement,
        options: FormHandlerOptions = {}
    ) {
        this.form = form;
        this.fieldValidators = options.fieldValidators;
        this.handleResponse = options.handleResponse;
        this.attachSubmit();
        this.attachBlurValidation();


    }

    private attachSubmit() {
        this.form.addEventListener('submit', this.handleSubmit.bind(this), true);
    }

    private attachBlurValidation() {
        if (!this.fieldValidators) return;

        Object.keys(this.fieldValidators).forEach(fieldName => {
            const input = this.form.elements.namedItem(fieldName) as HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement | null;
            if (input) {
                input.addEventListener('blur', () => {
                    this.validateSingleField(input)
                });
            }
        });
    }

    /**
     * process validation for a single field
     * @param input
     * @private
     */
    private validateSingleField(input: HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement) {
        if (!this.fieldValidators) return;

        const fieldName = input.name;
        const validators = this.fieldValidators[fieldName];
        if (validators) {
            this.clearFieldError(input);
            for (const validator of validators) {
                const error = validator(input, this.form);
                if (error) {
                    this.showFieldError(input, error);
                    return;
                }
            }
        }
    }

    async handleSubmit(event: Event) {
        event.preventDefault();
        this.clearErrors();

        if (this.fieldValidators) {
            Object.keys(this.fieldValidators).forEach(fieldName => {
                const input = this.form.elements.namedItem(fieldName) as HTMLInputElement | null;
                if (input) {
                    this.validateSingleField(input);
                }
            });
        }

        if (this.hasErrors()) {
            return;
        }


        const formData = new FormData(this.form);



        const action = this.form.action;
        let method = this.form.method.toUpperCase() as HttpMethod;

        // If the form has a _method field, we use that to determine the method
        if (formData.has('_method')) {
            //
            method = formData.get('_method')!.toString().toUpperCase() as HttpMethod;
            // This is useful for RESTful APIs that use PUT or DELETE methods
            formData.delete("_method"); // remove it from the data to avoid sending it
        }

        const [success, error] = await http<any>(action, method, formData, {
            headers : {
                "Content-Type": this.form.getAttribute('enctype') || 'application/json'
            }
        })

        if (success) {
            if (this.handleResponse) {
                this.handleResponse(success);
            }
        }
        if (error) {
            if (error!.code === 422 && error?.errors) {
                Object.entries(error.errors).forEach(([key, msg]) => {
                    const input = this.form.elements.namedItem(key) as HTMLInputElement | HTMLSelectElement | HTMLTextAreaElement | null;
                    if (input) {
                        this.showFieldError(input, msg as string);
                    }
                });
                return;
            }
            await alertModal({title: error.message || 'Validation Error'});

        }
        // console.log(error)


    }


    private showFieldError(input: HTMLElement, message: string) {
        const error = document.createElement('div');
        error.className = 'error field-error';
        error.textContent = message;
        input.parentElement?.append(error);
    }


    private clearFieldError(input: HTMLElement) {
        const error = input.parentElement?.querySelector('.field-error');
        error?.remove();
    }

    private clearErrors() {
        const errors = this.form.querySelectorAll('.error');
        errors.forEach(error => error.remove());
    }

    private hasErrors(): boolean {
        const errors = this.form.querySelectorAll('.error');
        return errors.length > 0;
    }

    private defaultShowError(errors: string[], form: HTMLFormElement) {
        errors.forEach(msg => {
            const error = document.createElement('div');
            error.className = 'error';
            error.style.color = 'red';
            error.textContent = msg;
            form.appendChild(error);
        });
    }


}