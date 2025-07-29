import http, {HttpMethod, IResponse} from "./http";

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
        this.form.addEventListener('submit', this.handleSubmit.bind(this));
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


        const data: Record<string, any> = {};
        new FormData(this.form).forEach((value, key) => {
            data[key] = value;
        });


        const action = this.form.action;
        const method = this.form.method.toUpperCase() as HttpMethod;

        const [success, error] = await http<any>(action, method, data)

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